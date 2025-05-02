<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Leer el parámetro "codigo" de la URL
$codigo = isset($_GET["codigo"]) ? trim($_GET["codigo"]) : "";

if (empty($codigo)) {
    response(400, "Bad Request: código de producto no proporcionado");
    exit;
}

// 2. Conexión a la base de datos
$host     = "localhost";
$user     = "root";
$password = "";
$dbname   = "pos";

$conexion = mysqli_connect($host, $user, $password, $dbname);

if (!$conexion) {
    response(500, "Internal Server Error: no se pudo conectar a la base de datos");
    exit;
}

// 3. Protección contra inyección SQL
$codigo_seguro = mysqli_real_escape_string($conexion, $codigo);

// 4. Consulta
$sql = "
    SELECT 
        producto_codigo,
        producto_nombre, 
        producto_precio, 
        producto_imagen 
    FROM productos 
    WHERE producto_codigo = '$codigo_seguro'
";

$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    response(500, "Internal Server Error: error en la consulta");
    exit;
}

// 5. Procesar resultado
if ($fila = mysqli_fetch_assoc($resultado)) {
    response(200, "OK: Producto encontrado", $fila);
} else {
    response(404, "Not Found: Producto no encontrado");
}

// 6. Cerrar conexión
mysqli_close($conexion);

// --------------------------------------------------------
// Función helper para enviar respuesta JSON uniforme
// --------------------------------------------------------
function response(int $status, string $mensaje, array $data = null) {
    http_response_code($status);
    $respuesta = [
        "status"  => $status,
        "mensaje" => $mensaje
    ];
    if ($data !== null) {
        $respuesta["data"] = $data;
    }
    echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
}
