<?php
  $config = require __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Pago con MercadoPago</title>
</head>
<body>
  <h2>Formulario de tarjeta de prueba</h2>
  <form id="form-checkout">
    <div>
      <label for="form-checkout__cardholderName">Nombre del titular</label>
      <input type="text" id="form-checkout__cardholderName" />
    </div>
    <div>
      <label for="form-checkout__cardholderEmail">Email</label>
      <input type="email" id="form-checkout__cardholderEmail" />
    </div>
    <div>
      <label for="form-checkout__cardNumber">Número de tarjeta</label>
      <input type="text" id="form-checkout__cardNumber" />
    </div>
    <div>
      <label for="form-checkout__expirationDate">Fecha de vencimiento</label>
      <input type="text" id="form-checkout__expirationDate" placeholder="MM/AA" />
    </div>
    <div>
      <label for="form-checkout__securityCode">Código de seguridad</label>
      <input type="text" id="form-checkout__securityCode" />
    </div>
    <div>
      <label for="form-checkout__installments">Cuotas</label>
      <select id="form-checkout__installments"></select>
    </div>
    <div>
      <label for="form-checkout__identificationType">Tipo de documento</label>
      <select id="form-checkout__identificationType"></select>
    </div>
    <div>
      <label for="form-checkout__identificationNumber">Número de documento</label>
      <input type="text" id="form-checkout__identificationNumber" />
    </div>
    <div>
      <label for="form-checkout__issuer">Banco emisor</label>
      <select id="form-checkout__issuer"></select>
    </div>
    <button type="submit" id="form-checkout__submit">Pagar</button>
  </form>

  <p><strong>Card token generado:</strong> <span id="token-output"></span></p>

  <script src="https://sdk.mercadopago.com/js/v2"></script>
  <script>
    const mp = new MercadoPago('<?= $config["public_key"] ?>', {
      locale: 'es-AR'
    });

    const cardForm = mp.cardForm({
      amount: "100",
      autoMount: true,
      form: {
        id: "form-checkout",
        cardholderName: { id: "form-checkout__cardholderName" },
        cardholderEmail: { id: "form-checkout__cardholderEmail" },
        cardNumber: { id: "form-checkout__cardNumber" },
        expirationDate: { id: "form-checkout__expirationDate" },
        securityCode: { id: "form-checkout__securityCode" },
        installments: { id: "form-checkout__installments" },
        identificationType: { id: "form-checkout__identificationType" },
        identificationNumber: { id: "form-checkout__identificationNumber" },
        issuer: { id: "form-checkout__issuer" }
      },
      callbacks: {
        onFormMounted: () => {
        console.log("Formulario montado correctamente");
      },
        onSubmit: event => {
          event.preventDefault();
          const data = cardForm.getCardFormData();
          if (data.token) {
            document.getElementById("token-output").innerText = data.token;
          } else {
            console.error("No se generó el token.");
          }

          // Enviar el token al backend usando Fetch
          fetch("pago.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify({ token: data.token })  // Pasamos el token al backend
          })
          .then(response => response.json())
          .then(data => {
            console.log("Respuesta del servidor:", data);
            // Aquí podrías manejar la respuesta del servidor
          })
          .catch(error => {
            console.error("Error al enviar el token:", error);
          });
        }
      }
    });
  </script>
</body>
</html>
