<?php
require __DIR__ . '/vendor/autoload.php';

// Cargar config
$config = require __DIR__ . '/config.php';

// Setear el token de acceso
MercadoPago\SDK::setAccessToken($config['access_token']);

// Obtener el token del frontend (se pasa como JSON)
$data = json_decode(file_get_contents('php://input'), true);
$token = $data['token'];  // El token generado por MercadoPago desde el frontend

// Crear un objeto de pago
$payment = new MercadoPago\Payment();
$payment->transaction_amount = 100; // Monto de la transacción
$payment->token = $token;           // El token de tarjeta generado en el frontend
$payment->description = 'Pago de prueba';
$payment->installments = 1;         // Número de cuotas
$payment->payment_method_id = 'visa';  // Método de pago ('visa', 'master', etc.)
$payment->payer = array(
    "email" => "test_user_123456@testuser.com"  // Email del comprador (puedes usar un email de prueba)
);

// Guardar el pago
$payment->save();

// Verificar el estado del pago
echo json_encode([
    'status' => $payment->status,               // Estado del pago
    'status_detail' => $payment->status_detail  // Detalle del estado del pago
]);
?>
