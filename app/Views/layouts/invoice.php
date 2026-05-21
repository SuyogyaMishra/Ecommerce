<!DOCTYPE html>
<html>
<head>
<title>Invoice</title>

<style>
body{font-family:Arial;font-size:12px;color:#111}
.container{width:100%}

.header{width:100%;margin-bottom:20px}
.title{font-size:22px;font-weight:bold}
.small{font-size:12px;color:#555}

.box{width:50%;vertical-align:top}

.table{width:100%;border-collapse:collapse;margin-top:20px}
.table th,.table td{border:1px solid #ddd;padding:8px}
.table th{background:#f3f4f6;text-align:left}

.summary{width:300px;margin-left:auto;margin-top:20px}
.summary td{padding:6px}
.total{font-weight:bold;background:#f8fafc}

.section-title{font-weight:bold;margin-top:20px;margin-bottom:5px}

.hr{border-top:1px solid #ddd;margin:15px 0}

.footer{margin-top:30px;font-size:11px;color:#666}
</style>

</head>

<body>

<?php if(empty($items)) exit; ?>

<?php
$order=$items[0];

$productRows=[];
$paymentRows=[];

foreach($items as $i){

 $productKey=$i['product_name'];

 if(!isset($productRows[$productKey])){
  $productRows[$productKey]=[
   'name'=>$i['product_name'],
   'price'=>(float)$i['product_price'],
   'qty'=>(int)$i['quantity'],
   'total'=>(float)$i['item_total']
  ];
 }

 $paymentRows[$i['payment_name']] = (float)$i['payment_amount'];
}
?>

<div class="container">

<!-- HEADER -->
<table class="header">
<tr>
<td class="box">
 <div class="title">ABC ECOMMERCE</div>
 <div class="small">
  123 Business Street,<br>
  New Delhi, India - 110001<br>
  GSTIN: 07ABCDE1234F1Z5<br>
  support@company.com<br>
  +91 99999 99999
 </div>
</td>

<td class="box" style="text-align:right">
 <div class="title">INVOICE</div>
 <div class="small">
  <b>Invoice ID:</b> <?= $order['id'] ?><br>
  <b>Date:</b> <?= date('d-m-Y') ?><br>
 </div>
</td>
</tr>
</table>

<div class="hr"></div>

<!-- CUSTOMER INFO -->
<table class="header">
<tr>
<td class="box">
 <div class="section-title">Bill To</div>
 <div class="small">
  <b><?= $order['user_name'] ?></b><br>
  <?= $order['user_email'] ?><br>
  <?= $order['user_phone'] ?><br>
 </div>
</td>

</tr>
</table>

<!-- ITEMS -->
<table class="table">
<tr>
 <th>Product</th>
 <th>Price</th>
 <th>Qty</th>
 <th>Total</th>
</tr>

<?php foreach($productRows as $p){ ?>
<tr>
 <td><?= $p['name'] ?></td>
 <td><?= number_format($p['price'],2) ?></td>
 <td><?= $p['qty'] ?></td>
 <td><?= number_format($p['total'],2) ?></td>
</tr>
<?php } ?>

</table>


<!-- SUMMARY -->
<table class="summary">
<?php $grandTotal = 0; ?>
<?php foreach($paymentRows as $name=>$amount){ 
 $grandTotal += $amount;
?>
<tr>
 <td><?= ucfirst($name) ?></td>
 <td><?= number_format($amount,2) ?></td>
</tr>
<?php } ?>
<tr class="total">
 <td><b>Grand Total</b></td>
 <td><b><?= ceil($grandTotal) ?></b></td>
</tr>

</table>

<!-- FOOTER -->
<div class="footer">
Thank you for your purchase. For any queries contact support@company.com
</div>

</div>

</body>
</html>