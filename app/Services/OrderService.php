<?php

namespace App\Services;

use App\Models\CartModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Validation\OrderValidation;
use App\Models\PaymentModel;
use App\Services\Payments\PaymentService;
use App\Factories\TaxFactory;
use APP\Models\TaxModel;
use App\Models\WalletModel;
use App\Services\BaseService;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf as Dompdf;

class OrderService extends BaseService
{

    protected $cartModel, $productModel, $paymentService, $orderModel, $orderItemModel, $paymentModel, $orderValidation, $tax, $walletModel;

    public function __construct()
    {
        parent::__construct();
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->paymentModel = new PaymentModel();
        $this->paymentService = new PaymentService();
        $this->orderValidation = new OrderValidation();
        $this->tax = new TaxModel();
        $this->walletModel = new WalletModel();
    }

    public function addOrder()
    {
        try {
            $validation = $this->orderValidation->validateOrder();

            if (!$validation['status']) {
                return $this->validationError($validation);
            }

            $userId = $this->user['id'];
            $data = service('request')->getPost();

            $total = $this->cartModel->cartTotal($userId);

            if (empty($total) || empty($total['total'])) {
                return $this->error('No items in cart to place oreder');
            }

            $cartItems = $this->cartModel->getCartByUser($userId);

            if (!$cartItems) {
               return $this->error('Cart is empty');
            }

            $data['user_id'] = $userId;
            $data['subtotal'] = $total['total'];
            $data['total'] = $total['total'];
            $data['order_id'] = generateOrderId();

            if ($data['payment_method'] == 'cod') {
                $data['payment_status'] = 'cod_pending';
                $data['order_status'] = 'confirmed';
            } else {
                $data['payment_status'] = 'paid';
                $data['order_status'] = 'confirmed';
            }

            $services = TaxFactory::makeAll();

            $this->db->transBegin();
            foreach ($services as $service) {

                $taxClass = $service->calculate($data['subtotal']);
                ceil($data['total'] += $taxClass['taxamount']);
            }
            $data['total'] = ceil($data['total']);
            $orderId = $this->orderModel->createOrder($data);
            $tax = [
                [
                    'user_id' => $userId,
                    'order_id' => $orderId,
                    'name' => 'total price',
                    'amount' => ceil($data['subtotal']),
                    'status' =>  $data['payment_method'] === 'cod' ? 'unpaid' : 'paid'
                ]
            ];




            foreach ($services as $service) {

                $taxClass = $service->calculate($data['subtotal']);

                $tax[] = [
                    'user_id' => $userId,
                    'order_id' => $orderId,
                    'name' => $taxClass['taxname'],
                    'amount' => $taxClass['taxamount'],
                    'status' => $data['payment_method'] === 'cod' ? 'unpaid' : 'paid'
                ];
            }


            if (!$orderId) {
                $this->db->transRollback();

               return $this->error('no order found');
            }



            foreach ($cartItems as $item) {

                $this->orderItemModel->createOrderItem([
                    'order_id' => $orderId,
                    'user_id' => $userId,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'product_price' => $item['price'],
                    'total' => $item['quantity'] * $item['price']
                ]);
            }

            if ($data['payment_method'] === 'cod') {
                $this->tax->insertTax($tax);

                $this->cartModel->clearCart($userId);

                $this->db->transComplete();

                if (!$this->db->transStatus()) {

                    return [
                        'status' => false,
                        'message' => 'Failed to place order',
                        'csrf' => [
                            'token' => csrf_token(),
                            'hash' => csrf_hash()
                        ]
                    ];
                }
                $metadata=changeToJson( ['id'=>$orderId],[]);
                 $this->logger->logActivity('New Announce ment Added',$metadata);
                return $this->success('order placed', [
                    'redirect_url' => base_url('user/orders'),
                    'order_id' => $orderId,
                    'csrf' => [
                        'token' => csrf_token(),
                        'hash' => csrf_hash()
                    ]
                ],);
            }

            if ($data['payment_method'] === 'wallet') {

                $balance = $this->walletModel->getBalance($userId);

                if ($balance < $data['total']) {

                    $this->db->transRollback();

                    return $this->error('Insufficent balance in account');
                }

                $this->tax->insertTax($tax);

                $transactionId = 'WALLET-' . $orderId;

                $this->walletModel->addWallet([
                    'user_id' => $userId,
                    'type' => 'debit',
                    'source' => 'order payment',
                    'amount' => $data['total'],
                    'reference_id' => $transactionId,
                    'note' => 'Order payment'
                ]);


                $this->orderModel->updatePayment($orderId, $transactionId, 'paid');

                $this->orderModel->updateOrderStatus($orderId, 'confirmed');

                $this->cartModel->clearCart($userId);

                $this->db->transComplete();

                if (!$this->db->transStatus()) {

                    return $this->error('Failed to place oreder');
                }
                 $metadata=changeToJson( ['id'=>$orderId],[]);
                 $this->logger->logActivity('New Announce ment Added',$metadata);

                return $this->success('order placed', [
                    'status' => true,
                    'message' => 'Order placed',
                    'redirect_url' => base_url('user/orders'),
                    'order_id' => $orderId,
                    'csrf' => [
                        'token' => csrf_token(),
                        'hash' => csrf_hash()
                    ]
                ],);
            }

            $this->db->transRollback();
            return $this->error('Invalid Payment Method');
        } catch (\Exception $e) {
            customLog('error' . $e->getFile() . $e->getLine() . $e->getMessage());
            $this->db->transRollback();
            return $this->error('Some thinfg went erong' . $e->getMessage(), []);
        }
    }


    public function getOrders()
    {
        try {

            $userId = $this->user['id'];

            $page = (int) service('request')->getGet('page') ?? 1;

            $limit = (int) service('request')->getGet('limit') ?? 10;

            $keyword = service('request')->getGet('search');

            $offset = ($page - 1) * $limit;


            $orders = $this->orderModel->getOrders(
                $userId,
                $limit,
                $offset,
                $keyword
            );

            $total = $this->orderModel->countOrders($userId);
            
            if(!$total){
               return $this->error('No orders Found');
            }
            return $this->success('orders found', [
                'status' => true,
                'message' => 'Orders fetched successfully',
                'orders' => [
                    'users' => $orders,
                    'page' => (int)$page,
                    'limit' => (int)$limit
                ],
                'totalPages' => ceil($total / $limit),
                'totalRecords' => (int)$total,
                'user' => $this->user
            ]);
        } catch (\Throwable $e) {

            customLog($e->getMessage());

            return $this->error('some error occurs');
        }
    }


    public function adminOrders()
    {
        try {

            $page = service('request')->getGet('page') ?? 1;

            $limit = service('request')->getGet('limit') ?? 10;

            $search = service('request')->getGet('search');

            $column = service('request')->getGet('sortColumn')??'id';
             $direction= service('request')->getGet('sortDirection');

            $offset = ($page - 1) * $limit;

            $orders = $this->orderModel->getAdminOrders(
                $limit,
                $offset,
                $direction,
                $search,
                $column
            );

            $total = $this->orderModel->countAdminOrders($search);

            $pending = $this->orderModel->countPendingOrders();

            $completed = $this->orderModel->countCompletedOrders();


            return $this->success('found',[
                'orders' => [
                    'users' => $orders,
                    'page' => $page,
                    'limit' => $limit
                ],
                'totalPages' => ceil($total / $limit),
                'totalOrders' => $total,
                'pendingOrders' => $pending,
                'completedOrders' => $completed
            ]);

        } catch (\Exception $e) {

            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    public function updateOrder()
    {
        $data = service('request')->getJSON(true);
        $orderId = $data['id'];
        $status = $data['order_status'];
        $result = $this->orderModel->updateOrderStatus($orderId, $status);
        if (!$result) {
           return $this->error('unable to updtae data');
        }
        $metadata=changeToJson( ['id'=>$orderId],['updated to'=>$status]);
         $this->logger->logActivity('Order status updated successfully ',$metadata);

        return $this->success('fetched',[
            'status' => true,
            'message' => 'Order updated successfully',
        ]);
    }
    public function deleteOrder($id)
    {
        $order = $this->orderModel->getOrderById($id);

        if (!$order['order_status'] == 'pending') {
            return $this->error('Order can not be cancelled afer pending status');

        }
        $result = $this->orderModel->deleteOrder($id);

        if (!$result) {
           return $this->error('failled to delete orders');
        }
          $metadata=changeToJson( ['id'=>$id],[]);
         $this->logger->logActivity('Order deleted successfully ',$metadata);
       return $this->success('Order Deleted Successfully');
    }

    public function deleteUserOrder($id)
    {
        $order = $this->orderModel->getSingleOrder($id, $this->user['id']);

        if (!$order['order_status'] == 'pending' || !$order['order_status'] == 'confirmed') {
            return $this->error('Order can not be cancelled afer pending status bfore confirmed');
          
        }
        $result = $this->orderModel->deleteUserOrder($id, $this->user['id']);

        if (!$result) {
            return $this->error('Order can not be cancelled some error occured');

        }

         $metadata=changeToJson( ['id'=>$id],[]);
         $this->logger->logActivity('Order deleted successfully by user ',$metadata);
        return $this->success('order delted successfully');
    }


    public function orderDetails($id)
    {
        try {

            $rows = $this->orderModel->orderDetails($id);

            if (!$rows) {

                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Order not found'
                ]);
            }

            $first = $rows[0];

            $items = [];
            $payments = [];

            foreach ($rows as $row) {

                if ($row['item_id']) {

                    $items[$row['item_id']] = [
                        'id' => $row['item_id'],
                        'product_id' => $row['product_id'],
                        'product_name' => $row['product_name'],
                        'image' => base_url($row['image']),
                        'quantity' => $row['quantity'],
                        'price' => $row['product_price'],
                        'total' => $row['item_total']
                    ];
                }

                if ($row['payment_id']) {

                    $payments[$row['payment_id']] = [
                        'id' => $row['payment_id'],
                        'name' => $row['payment_name'],
                        'amount' => $row['payment_amount'],
                        'status' => $row['payment_row_status']
                    ];
                }
            }

            return $this->response->setJSON([

                'status' => true,

                'order' => [

                    'id' => $first['id'],
                    'customer_name' => $first['customer_name'],
                    'customer_email' => $first['customer_email'],
                    'phone' => $first['phone'],

                    'address' => [
                        'address' => $first['address']
                    ],

                    'payment' => [
                        'method' => $first['payment_method'],
                        'status' => $first['payment_status']
                    ],

                    'status' => $first['order_status'],
                    'subtotal' => $first['subtotal'],
                    'total' => $first['total'],
                    'transaction_id' => $first['transaction_id'],
                    'created_at' => $first['created_at']

                ],

                'items' => array_values($items),

                'payments' => array_values($payments)

            ]);
        } catch (\Exception $e) {

            customLog(
                $e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine()
            );

            return $this->response->setJSON([
                'status' => false,
                'message' => 'Internal server error'
            ]);
        }
    }

    public function invoice($id)
    {
        try {

            $data['items'] = $this->orderModel->orderInvoiceDetails($id);

            $html = view('layouts/invoice', $data);

            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $dompdf->stream("invoice_$id.pdf", ["Attachment" => 0]);
        } catch (\Exception $e) {
            customLog($e->getFile() . " " . $e->getLine() . " " . $e->getMessage());
        }
    }
}
