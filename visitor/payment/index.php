<?php

require('config.php');
require('razorpay-php/Razorpay.php');
session_start();

// Create the Razorpay Order

use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);

//
// We create an razorpay order using orders api
// Docs: https://docs.razorpay.com/docs/orders

if(isset($_POST['pay_fees'])){
  $visitor_name = $_POST['visitor_name'];
  $email = $_POST['visitor_email'];

  $_SESSION['email'] = $email;
  $total_fees = $_SESSION['fees'] * $_SESSION['no_of_members'];  
  $orderData = [
      'receipt'         => "NM". rand(1000,9000),
      'amount'          => $total_fees * 100, // 2000 rupees in paise
      'currency'        => 'INR',
      'payment_capture' => 1 // auto capture
  ];

  $razorpayOrder = $api->order->create($orderData);

  $razorpayOrderId = $razorpayOrder['id'];

  $_SESSION['razorpay_order_id'] = $razorpayOrderId;

  $displayAmount = $amount = $orderData['amount'];

  if ($displayCurrency !== 'INR')
  {
      $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
      $exchange = json_decode(file_get_contents($url), true);

      $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
  }

  $data = [
      "key"               => $keyId,
      "amount"            => $amount,
      "name"              => "National Museum",
      "description"       => "Ticketless Entry Pass",
      "image"             => "http://localhost/museum/img/logo.png",
      "prefill"           => [
      "name"              => $visitor_name,
      "email"             => $email,
      ],
      "notes"             => [
      "address"           => "National Museum Entry Fees",
      "merchant_order_id" => "12312321",
      ],
      "theme"             => [
      "color"             => "#F37254"
      ],
      "order_id"          => $razorpayOrderId,
  ];

  if ($displayCurrency !== 'INR')
  {
      $data['display_currency']  = $displayCurrency;
      $data['display_amount']    = $displayAmount;
  }

  $json = json_encode($data);

  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>National Museum | Pay Fees</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="icon" href="../../img/logo.png">
    <style>
      body{
        /* background: linear-gradient(to left, aqua, aquamarine); */
        width: 100px;
        height: 100px;
        background-color: #00ffbb;
        animation-name: example;
        animation-duration: 10s;
      }

      @keyframes example {
        0%   {background-color: #00cafc;}
        25%  {background-color: #00e1ff;}
        50%  {background-color: #00fffb;}
        100% {background-color: #00ffd5;}
      }
      .razorpay-payment-button{
        color: purple;
        margin: 0;
        position: absolute;
        font-size : 200%;
        top: 50%;
        left: 50%;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        font-weight:bold;
        font-style : "sans-serif"
        border: 3px solid;
        border-radius: 10px;
      }
      .razorpay-payment-button:hover{
        transition: 0.5s;
        font-size : 300%;
        background-color: #00fffb;
      }
    </style>
  </head>
  <body>

    <a href="../"><button class="btn btn-outline-primary btn-lg"><i class="fa fa-arrow-back"></i> Back</button></a>
    <form action="verify.php" method="POST">
      <script
        src="https://checkout.razorpay.com/v1/checkout.js"
        data-key="<?php echo $data['key']?>"
        data-amount="<?php echo $data['amount']?>"
        data-currency="INR"
        data-name="<?php echo $data['name']?>"
        data-image="<?php echo $data['image']?>"
        data-description="<?php echo $data['description']?>"
        data-prefill.name="<?php echo $data['prefill']['name']?>"
        data-prefill.email="<?php echo $data['prefill']['email']?>"
        data-order_id="<?php echo $data['order_id']?>"
        <?php if ($displayCurrency !== 'INR') { ?> data-display_amount="<?php echo $data['display_amount']?>" <?php } ?>
        <?php if ($displayCurrency !== 'INR') { ?> data-display_currency="<?php echo $data['display_currency']?>" <?php } ?>
      >
      </script>
    </form>
  </body>
  </html>
  <?php

}else{
  header("Location: ../");  
}
?>