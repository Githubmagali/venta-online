<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");

if (isset($_POST['query'])) {
    $q = $conexion->real_escape_string($_POST['query']);
    $sql = "SELECT * FROM productos WHERE nombre LIKE '%$q%' LIMIT 5";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            echo "<div class='border-bottom py-2'>";
            echo "<strong>" . $row['nombre'] . "</strong> - $" . $row['precio'];
            echo "</div>";
        }
    } else {
        echo "<div class='text-muted'>No se encontraron resultados</div>";
    }
}
