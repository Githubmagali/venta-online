<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <script
        src="https://www.paypal.com/sdk/js?client-id=AZbCN7l_8QD7DwAKONa1PK79QxdGQl8UBWkPp9xAFn4EwDEbL1ZDF0I4Ek_zlw0NDWSSB3WU4R4KR7FW">
    </script>

    <body>
        <div>Button</div>
        <div id="paypal-button-conteiner"></div>

        <script>
            paypal.Buttons({
                style: {
                    color: 'blue',
                    shape: 'pill',
                    label: 'pay'
                },
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: 100
                            }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    actions.order.capture().then(function(detalles) {
                        window.location.href = "completado.html"
                    });
                },
                onCancel: function(data) {
                    alert("Pago cancelado")
                    console.log('data :', data);


                }
            }).render('#paypal-button-conteiner');
        </script>
    </body>
</body>

</html>