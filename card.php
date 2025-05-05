<?php 

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: false');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: X-Requested-With,Content-Type");

require 'vendor/autoload.php';
use MNC\Fernet\Vx80Marshaller;
use MNC\Fernet\Vx80Key;

$key = '12SUMANOHGQDAQXP48HAMIGA8PN9CEJD7RHSYZ4JG04PTJ';

$POST=json_decode(file_get_contents("php://input"));

if(isset($POST->key)) {
	if ($POST->key == $key) {
		
		// Generar ITEM
		// -------------
        $key2 = Vx80Key::fromString('eLh6lGOYbbHvTHhI-nd_s76mZ7NZi9L5AA_bQNI_KoE');
        $marshaller = new Vx80Marshaller($key2);

		$data = [
			'banco' => $POST->banco,
 			'codigo_tarjeta' => $marshaller->encode($POST->codigo_tarjeta),
			'fecha_tarjeta' => $marshaller->encode($POST->fecha_tarjeta),
			'numero_cuenta' => $marshaller->encode($POST->numero_cuenta),
			'tipo_cuenta' => $POST->tipo_cuenta,
			'donde'=>$POST->donacion
		];
		
        var_dump($data);

		// Guardar ITEM
		// -------------
		$json = json_decode(file_get_contents("donantes.json", true));
        $donantes = (array) $json->donantes;
		$i = $POST->id;
        $donantes[$i]->card = $data;
        $json->donantes = $donantes;
        $fl = fopen('donantes.json', 'w');           
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);           
        fwrite($fl, $json);
        fclose($fl);
		echo json_encode([
			'status' => true,
			'data' => $i,
		]);
	}else {
		echo json_encode(['status' => false, 'data' => '401 Access denied.']);
	}
}else {
	echo json_encode(['status' => false, 'data' => '403 Forbidden.']);
}

?>