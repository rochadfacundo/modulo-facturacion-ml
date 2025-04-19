<?php
$config = require __DIR__ . '/config.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pago con Checkout Pro</title>
</head>
<body>

  <h2>Botón de pago con MercadoPago - Checkout Pro</h2>

  <!-- Contenedor del botón -->
  <div id="wallet_container"></div>

  <script src="https://sdk.mercadopago.com/js/v2"></script>
  <script>
    const mp = new MercadoPago("<?= $config['public_key'] ?>");

    // 1. Pedimos el ID de la preferencia al backend
    fetch("crear-preferencia.php")
      .then(res => res.json())
      .then(data => {
        console.log("Preferencia creada:", data.id);

        // 2. Iniciamos el checkout
        mp.checkout({
          preference: {
            id: data.id
          },
          render: {
            container: "#wallet_container", // div donde se inyecta el botón
            label: "Pagar con Mercado Pago"
          }
        });
      })
      .catch(error => {
        console.error("Error creando la preferencia:", error);
      });
  </script>
</body>
</html>
