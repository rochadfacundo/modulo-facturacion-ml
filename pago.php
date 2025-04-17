<?php
require_once __DIR__ . '/src/MercadoPagoService.php';

$config = require __DIR__ . '/config.php';
$mp = new MercadoPagoService($config['access_token']);

// Token generado con Postman o frontend
$token = "bdd70e0913692d27482c31cf7ede9632";  
try {
    $resultado = $mp->crearPago([
        "transaction_amount" => 100,
        "token" => $token,
        "description" => "Pago usando cURL sin SDK",
        "installments" => 1,
        "payment_method_id" => "visa",
        "payer" => [
            "entity_type" => "individual",
            "type" => "customer",
            "identification" => [
                "type" => "DNI",
                "number" => "12345678"
            ]
        ]
    ]);

    echo json_encode($resultado, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
