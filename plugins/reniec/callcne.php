<?php 

    // Definimos la función cURL
    function curl($url) {
        $ch = curl_init($url); // Inicia sesión cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Configura cURL para devolver el resultado como cadena
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Configura cURL para que no verifique el peer del certificado dado que nuestra URL utiliza el protocolo HTTPS
        $info = curl_exec($ch); // Establece una sesión cURL y asigna la información a la variable $info
        curl_close($ch); // Cierra sesión cURL
        return $info; // Devuelve la información de la función
    }

    if (isset($_POST['ced'])) {
        $ced = $_POST['ced'];
    }else{
        $ced = $_REQUEST['ced'];
    }

    $sitioweb = curl('http://www4.cne.gob.ve/web/registro_civil/buscar_rep.php?ced='.$ced);  // Ejecuta la función curl escrapeando el sitio web https://devcode.la and regresa el valor a la variable $sitioweb
    $partes = explode("|", $sitioweb);

    $datos = array(
            0 => $ced, 
            1 => $partes[0],
    );

    echo json_encode($datos);
    //echo $sitioweb;
?>