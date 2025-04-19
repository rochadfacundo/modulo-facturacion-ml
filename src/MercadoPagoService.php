<?php

class MercadoPagoService
{
    private string $accessToken;

    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function crearPago(array $data): array
    {
        $url = 'https://api.mercadopago.com/v1/payments';

        $headers = [
            "Authorization: Bearer " . $this->accessToken,
            "Content-Type: application/json",
            "X-Idempotency-Key: " . uniqid("facu_", true)
        ];
        $payload = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new Exception("Error en la solicitud: $error");
        }

        curl_close($ch);
        return [
            'http_code' => $httpCode,
            'response' => json_decode($response, true)
        ];
    }

    // 🆕 NUEVO MÉTODO para Checkout Pro
    public function crearPreferencia(array $data): array
    {
        $url = 'https://api.mercadopago.com/checkout/preferences';
        $headers = [
            "Authorization: Bearer " . $this->accessToken,
            "Content-Type: application/json"
        ];
        $payload = json_encode($data);
    
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new Exception("Error en la solicitud: $error");
        }
    
        curl_close($ch);
        return [
            'http_code' => $httpCode,
            'response' => json_decode($response, true)
        ];
    }
    
}
