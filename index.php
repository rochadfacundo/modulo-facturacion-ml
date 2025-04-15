<?php

require __DIR__ . '/vendor/autoload.php';

MercadoPago\SDK::setAccessToken('TEST-xxxxxxxxxxxxxxxxxxxxx'); 

$payment = new MercadoPago\Payment();
$payment->transaction_amount = 100;
$payment->description = "Producto de prueba";
$payment->payment_method_id = "visa";
$payment->payer = array(
    "email" => "test_user_123456@testuser.com"
);
$payment->save();

echo "Pago creado con ID: " . $payment->id;
