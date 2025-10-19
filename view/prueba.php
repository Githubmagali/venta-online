<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Producto Ejemplo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: #fafafa;
        }

        .price-container h4 {
            display: inline-block;
            margin-right: 10px;
        }

        .product-variants select,
        .product-quantity input,
        .product-file input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
        }

        .btn {
            display: inline-block;
            background: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:disabled {
            background: #aaa;
            cursor: not-allowed;
        }

        .free-shipping-message {
            background: #e6f6e6;
            border: 1px solid #8cd98c;
            padding: 10px;
            margin: 15px 0;
            border-radius: 4px;
        }
    </style>
</head>

<body>

    <h2>Nombre del producto</h2>

    <!-- Precio -->
    <div class="price-container">
        <h4 class="price-compare" style="text-decoration: line-through; color: gray;">$12.000</h4>
        <h4 class="price">$9.999</h4>
    </div>

    <!-- Promoción -->
    <div class="promotion">
        <p><strong>10% de descuento</strong> pagando con tarjeta VISA</p>
    </div>

    <!-- Envío gratis -->
    <div class="free-shipping-message">
        <strong>Envío gratis</strong> superando los $15.000<br>
        <small>No acumulable con otras promociones</small>
    </div>

    <!-- Formulario del producto -->
    <form id="product_form" class="js-product-form" method="post" action="/carrito">

        <!-- ID oculto -->
        <input type="hidden" name="add_to_cart" value="12345">

        <!-- Variantes -->
        <div class="product-variants">
            <label for="variant">Talle o color:</label>
            <select name="variant" id="variant">
                <option value="1">Talle S</option>
                <option value="2">Talle M</option>
                <option value="3">Talle L</option>
            </select>
        </div>

        <!-- Input de cantidad -->
        <div class="product-quantity">
            <label for="quantity">Cantidad:</label>
            <input type="number" id="quantity" name="quantity" min="1" value="1">
        </div>

        <!-- Input para subir archivo -->
        <div class="product-file">
            <label for="custom_file">Subí una imagen o archivo (opcional):</label>
            <input type="file" id="custom_file" name="custom_file">
        </div>

        <!-- Botón CTA -->
        <input type="submit" class="btn" value="Agregar al carrito">

        <!-- Mensaje cuando se agregó -->
        <p style="display:none;" class="added-message">Ya agregaste este producto. <a href="/carrito">Ver carrito</a>
        </p>

    </form>

    <!-- Descripción -->
    <div class="product-description">
        <h3>Descripción</h3>
        <p>
            Este es un producto de ejemplo. Ideal para ver cómo se renderizan los componentes
            de una página de producto, incluyendo precio, variantes, cantidad, y CTA.
        </p>
    </div>

</body>

</html>