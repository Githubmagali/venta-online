<?php
$producto = new productosController();
$productos = $producto->productosController();
#print_r($productos);

if (isset($_POST['btnPost'])) {
    $id = $_POST['id'];
    $producto = $_POST['productoPost'];
    $precio   = $_POST['precioPost'];
    $cantidad = $_POST['cantidadPost'];

    $_SESSION['carrito'][$producto]['cantidad'] = $cantidad;
    $_SESSION['carrito'][$producto]['precio'] = $precio;
    $_SESSION['carrito'][$producto]['id'] = $id;

    header("location:index.php?view=check");
    exit;
}

if (isset($_POST['eliminar'])) {
    $id = $_POST['eliminar'];

    foreach ($_SESSION['carrito'] as $producto => $detalles) {
        if ($detalles['id'] == $id) {
            unset($_SESSION['carrito'][$producto]);
            break;
        }
    }

    header("location:index.php?view=carrito");
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda online</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/lux/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<style>

</style>


<body class="d-flex flex-column  min-vh-100">
    <main class="flex-fill">
        <div class="col-12 d-flex flex-column flex-lg-row justify-content-lg-between py-3
        bg-body-tertiary align-items-lg-center">
            <div class="mb-3 mb-lg-0">Logo</div>
            <div class="d-flex  align-content-lg-center flex-column flex-lg-row gap-2 gap-lg-4" id="menu">
                <a href="index.php?view=inicio">Inicio</a>
                <a href="index.php?view=check ">Comprar </a>
                <a href="index.php?view=carrito">Carrito</a>

            </div>
        </div>


        <div class=" py-5">
            <div class="d-flex flex-column mb-6 p-5 ">
                <h1 class="text-2xl font-bold "> </h1>

                <a class="text-dark" href="index.php?view=inicio">Volver</a>
            </div>

            <div class="container">
                <div class="row">
                    <?php foreach ($productos as $item) { ?>
                        <div class="col-12 col-md-6 col-lg-3 mb-4 ">

                            <form method="post" class="card h-100 ">
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                    style="height:250px; overflow:hidden;">
                                    <img src="img/<?= $item['img'] ?>" class=" w-100 h-100" style="object-fit:cover;">
                                </div>
                                <div class="card-body d-flex flex-column">

                                    <h5 class="mt-4 font-semibold text-lg"><?= htmlspecialchars($item['nombre']) ?></h5>
                                    <p class="text-gray-500 text-sm min"><?= $item['descripcion'] ?></p>
                                    <p class="text-gray-500 text-sm">Precio:
                                        <?= MONEDA . " " . number_format($item['precio'], 2) ?></p>

                                    <div class="mb-3">
                                        <label for="cantidad_<?= $item['id'] ?>" class="form-label">Cantidad:</label>
                                        <input type="number" min="1" name="cantidadPost" id="cantidad_<?= $item['id'] ?>"
                                            value="<?= isset($_SESSION['carrito'][$item['nombre']]['cantidad']) ? $_SESSION['carrito'][$item['nombre']]['cantidad'] : 1 ?>"
                                            class="form-control text-center">
                                        <input type="file" id="inputImagenes" name="imagenes[]" multiple accept="image/*">

                                    </div>
                                    <div id="preview" class="preview-container"></div>

                                    <input type="hidden" name="productoPost" value="<?= $item['nombre'] ?>">
                                    <input type="hidden" name="precioPost" value="<?= $item['precio'] ?>">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">

                                    <button type="submit" name="btnPost" class="btn btn-success mt-auto">Agregar</button>

                                </div>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>



        <!--Overlay -->
        <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEliminarLabel">Confirmar eliminación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        ¿Seguro que desea eliminar este producto del carrito?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form method="post">
                            <input type="hidden" name="eliminar" id="inputEliminar">
                            <button type="submit" class="btn btn-danger">Confirmar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--Footer -->
    <footer class="bg-secondary-subtle text-white bg-opacity-100 text-center py-3 mt-5 ">
        <div class="container">
            <p class="mb-0">&copy; <?= date('Y') ?> Fernandez Magali Victoria</p>
            <p class="mb-0">
                <a href="#" class="text-white text-decoration-none me-3">Política de privacidad</a>
                <a href="#" class="text-white text-decoration-none">Contacto</a>
            </p>
        </div>
    </footer>

</body>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modalEliminar = document.getElementById('modalEliminar');
        const inputEliminar = document.getElementById('inputEliminar');

        if (modalEliminar) {
            modalEliminar.addEventListener('show.bs.modal', (event) => {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                inputEliminar.value = id;
            });
        }
    });
</script>
<script>
    const inputImagenes = document.getElementById('inputImagenes');
    const cantidadInput = document.getElementById('cantidadPost');
    const preview = document.getElementById('preview');

    // Cuando el usuario selecciona archivos
    inputImagenes.addEventListener('change', (event) => {
        const archivos = event.target.files;
        cantidadInput.value = archivos.length; // Actualiza el input numérico
        preview.innerHTML = ''; // Limpia el contenedor

        // Mostrar una vista previa de cada imagen
        Array.from(archivos).forEach(file => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('miniatura');
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });

    // Intersection Observer: detecta cuándo las imágenes cargadas aparecen en pantalla
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                console.log(`Imagen visible:`, entry.target.src);
                entry.target.classList.add('visible');
            }
        });
    }, {
        threshold: 0.5
    });

    // Observar cuando se agreguen nuevas imágenes al DOM
    const observerDOM = new MutationObserver(() => {
        const imagenes = document.querySelectorAll('.miniatura');
        imagenes.forEach(img => observer.observe(img));
    });
    observerDOM.observe(preview, {
        childList: true
    });
</script>



</html>