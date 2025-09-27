<?php



$action   = $_POST['action']   ?? '';
$id       = $_POST['id'] ?? '';
$restarUno = $_POST['restarUno'] ?? '';

if ($action === 'quitar') {

    // Total del carrito
    $total = 2;

    // Cantidad de productos en el carrito
    $numero = 3;

    $subtotal = 45;

    $respuesta = [
        'ok'     => true,
        'sub'    => $subtotal,
        'total'  => $total,
        'numero' => $numero
    ];

    echo json_encode($respuesta);
}
