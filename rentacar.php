<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscador de Rentacars en Mallorca</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<?php

function obtenerDatos($url) {
    $xml = simplexml_load_file($url);
    return $xml;
}

function imprimirTabla($datos) {
    echo "<table>";
    echo "<thead><tr>
            <th>Licencia de rentacar</th>
            <th>Nombre comercial</th>
            <th>Dirección completa</th>
            <th>Número de vehículos</th>
          </tr></thead><tbody>";

    foreach ($datos as $rentacar) {
        echo "<tr>
                <td>{$rentacar->Licencia}</td>
                <td>{$rentacar->NombreComercial}</td>
                <td>{$rentacar->Direccion}</td>
                <td>{$rentacar->NumVehiculos}</td>
              </tr>";
    }

    echo "</tbody></table>";
}


$url = "https://catalegdades.caib.cat/Turisme/Empreses-Lloguer-Cotxes-Mallorca/rjfm-vxun";
$datosXML = obtenerDatos($url);

$municipio = $_GET['municipio'] ?? '';
$codigoPostal = $_GET['codigo_postal'] ?? '';
$nombre = $_GET['nombre'] ?? '';

$datosFiltrados = [];

foreach ($datosXML->Rentacar as $rentacar) {
    if (
        (empty($municipio) || $rentacar->Municipio == $municipio) &&
        (empty($codigoPostal) || $rentacar->CodigoPostal == $codigoPostal) &&
        (empty($nombre) || stripos($rentacar->NombreComercial, $nombre) !== false || stripos($rentacar->NombreRazonSocial, $nombre) !== false)
    ) {
        $datosFiltrados[] = $rentacar;
    }
}


imprimirTabla($datosFiltrados);
?>

</body>
</html>

