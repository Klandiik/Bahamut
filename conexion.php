<?php
//autor: christian adrian pereira 
//autor: pedro manuel merino garcia
//autor: noe jefferson chavarry llerenas
try {
    // Definir la conexión con la base de datos (usando el objeto PDO)
    $conn = new PDO("mysql:host=localhost;dbname=bahamut;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Asegura el manejo de errores con excepciones
} catch (PDOException $e) {
    die("Error en la conexión a la base de datos: " . $e->getMessage()); // Si ocurre un error, muestra un mensaje adecuado
}
?>
