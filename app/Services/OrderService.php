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
use App\Models\WalletPaymentModel;
use CodeIgniter\Config\BaseService;

class OrderService extends BaseService
{

    protected $cartModel, $productModel, $paymentService, $user, $orderModel, $orderItemModel, $paymentModel, $orderValidation, $tax,$walletModel,$walletPaymentModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->paymentModel = new PaymentModel();
        $this->paymentService = new PaymentService();
        $this->orderValidation = new OrderValidation();
        $this->tax = new TaxModel();
        $this->user = service('jwt')->decode(service('request')->getCookie('token'));
        $this->walletModel= new WalletModel();
        $this->walletPaymentModel =  new WalletPaymentModel();
    }

    public function addOrder()
    {
        $validation = $this->orderValidation
            ->validateOrder();

        if (!$validation['status'])
            return $validation;
        $userId = $this->user->id;

        $data = service('request')->getPost();

        $total = $this->cartModel->cartTotal($userId);
         $shipping = TaxFactory::make('shiping');


        $data['user_id'] = $userId;
        $data['subtotal'] = $total['total'];
        $data['total'] = $total['total'];
        $data['order_id'] = generateOrderId();
        

        if ($data['payment_method'] == 'cod') {
            $data['payment_status'] = 'cod_pending';
            $data['order_status'] = 'confirmed';
        } else {
            $data['payment_status'] = 'pending';
            $data['order_status'] = 'awaiting_payment';
        }

        $shippingTax = $shipping->calculate($data['total']);

        $data['total'] += $shippingTax['taxamount'];

        $orderId = $this->orderModel->createOrder($data);
     
        $rows = [
            [ 
                'user_id' => $userId,
                'order_id' => $orderId,
                'name' => $shippingTax['taxname'],
                'amount' => $shippingTax['taxamount'],
                'status' =>'paid'
            ],
             [
                'user_id' => $userId,
                'order_id' => $orderId,
                'name' => 'total',
                'amount' => $data['total'],
                'status' =>'paid'
            ],
        ];


         


        $cartItems = $this->cartModel->getCartByUser($userId);

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
            $this->tax->insertTax($rows);

            $this->cartModel->clearCart($userId);

            return [
                'status' => true,
                'message' => 'Order placed',
                'redirect_url' => base_url('user/orders'),
                'order_id' => $orderId,
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash()
                ]
            ];
        }
       
        if ($data['payment_method'] === 'wallet') {

            $balance = $this->walletModel->getBalance($userId);
            $this->tax->insertTax($rows);


            if ($balance < $data['total']) {
                return [
                    'status' => false,
                    'message' => 'Insufficient wallet balance',
                    'csrf' => [
                        'token' => csrf_token(),
                        'hash' => csrf_hash()
                    ]
                ];
            }
             $transactionId = 'WALLET-' . $orderId;
             $walletId =  $this->walletModel->addWallet([
                'user_id' => $userId,
                'type' => 'debit',
                'source' => 'order payment',
                'amount' =>  $data['total'],
                'reference_id' => $transactionId,
                'note' => 'Order payment'
            ]);

            $this->walletPaymentModel->insertPayment([
                'user_id' => $userId,
                'order_id' => $orderId,
                'wallet_id' => $walletId ?? null,
                'transaction_id' => $transactionId,
                'amount' =>  $data['total'],
                'type' => 'debit',
                'status' => 'paid',
                'note' => 'Wallet order payment'
            ]);
            $this->orderModel->updatePayment($orderId,'WALLET-' . $orderId,'paid');
            $this->orderModel->updateOrderStatus($orderId,'confirmed');
            $this->cartModel->clearCart($userId);

            return [
                'status' => true,
                'message' => 'Order placed',
                'redirect_url' => base_url('user/orders'),
                'order_id' => $orderId,
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash()
                ]
            ];
        }
    }


    public function getOrders()
    {
        try {

            $userId = $this->user->id;

            $page = (int) service('request')->getGet('page') ?? 1;

            $limit = (int) service('request')->getGet('limit') ?? 10;

            $offset = ($page - 1) * $limit;

            $orders = $this->orderModel->getOrders(
                $userId,
                $limit,
                $offset
            );

            $total = $this->orderModel->countOrders($userId);

            return [
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
            ];
        } catch (\Throwable $e) {

            log_message('error', $e->getMessage());

            return [
                'status' => false,
                'message' => 'Failed to fetch orders'
            ];
        }
    }


    public function adminOrders()
    {
        try {

            $page = service('request')->getGet('page') ?? 1;

            $limit = service('request')->getGet('limit') ?? 10;

            $search = service('request')->getGet('search');

            $offset = ($page - 1) * $limit;

            $orders = $this->orderModel->getAdminOrders(
                $limit,
                $offset,
                $search
            );

            $total = $this->orderModel->countAdminOrders($search);

            $pending = $this->orderModel->countPendingOrders();

            $completed = $this->orderModel->countCompletedOrders();

            return [
                'status' => true,
                'orders' => [
                    'users' => $orders,
                    'page' => $page,
                    'limit' => $limit
                ],
                'totalPages' => ceil($total / $limit),
                'totalOrders' => $total,
                'pendingOrders' => $pending,
                'completedOrders' => $completed
            ];
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
            return [
                'status' => false,
                'message' => 'Failed to update order',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash()
                ]
            ];
        }
        return [
            'status' => true,
            'message' => 'Order updated successfully',
            'csrf' => [
                'token' => csrf_token(),
                'hash' => csrf_hash()
            ]
        ];
    }
    public function deleteOrder($id)
    {
        $order = $this->orderModel->getOrderById($id);

        if (!$order['order_status'] == 'pending') {
            return [
                'status' => true,
                'message' => 'Order can not be cancelled afer pending status'
            ];
        }
        $result = $this->orderModel->deleteOrder($id);

        if (!$result) {
            return [
                'status' => false,
                'message' => 'Failed to delete order',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash()
                ]
            ];
        }
        return [
            'status' => true,
            'message' => 'Order deleted successfully',
            'csrf' => [
                'token' => csrf_token(),
                'hash' => csrf_hash()
            ]
        ];
    }

    public function deleteUserOrder($id)
    {
        $order = $this->orderModel->getSingleOrder($id, $this->user->id);

        if (!$order['order_status'] == 'pending' || !$order['order_status'] == 'confirmed') {
            return [
                'status' => true,
                'message' => 'Order can not be cancelled afer pending status bfore confirmed'
            ];
        }
        if ($order['payment_status'] == 'paid' && $order['payment_method'] != 'cod') {
            $payment = $this->paymentModel->getPaymentByOrderId($order['id']);
            return  $this->paymentService->refundPayment($payment['gateway_payment_id'], $payment['amount'], $payment['gateway'], $order['order_id']);
        }
        $result = $this->orderModel->deleteUserOrder($id, $this->user->id);

        if (!$result) {
            return [
                'status' => false,
                'message' => 'Failed to delete order',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash()
                ]
            ];
        }

        if (!$result) {
            return [
                'status' => false,
                'message' => 'Failed to delete order',
                'csrf' => [
                    'token' => csrf_token(),
                    'hash' => csrf_hash()
                ]
            ];
        }
        return [
            'status' => true,
            'message' => 'Order deleted successfully',
            'csrf' => [
                'token' => csrf_token(),
                'hash' => csrf_hash()
            ]
        ];
    }
}
