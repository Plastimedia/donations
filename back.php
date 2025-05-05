<?php 
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: false');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: X-Requested-With,Content-Type");

$key = '12SUMANOHGQDAQXP48HAMIGA8PN9CEJD7RHSYZ4JG04PTJ';

$POST=json_decode(file_get_contents("php://input"));

if(isset($POST->key)) {
	if ($POST->key == $key) {
		
		// Generar ITEM
		// -------------
		$data = [
			'fecha' => date_format(date_create(), 'Y-m-d H:i'),
			'link' => $POST->link,
 			'nombre' => $POST->nombre,
			'apellidos' => $POST->apellidos,
			'correo' => $POST->correo,
			'telefono' => $POST->telefono,
			'tipo_documento' => $POST->tipo_documento,
			'documento' => $POST->documento,
			'donde'=>$POST->donacion,
			'card' => []
		];
		
		// Guardar ITEM
		// -------------
		$json = json_decode(file_get_contents("donantes.json", true));
        $donantes = $json->donantes;
		$i = count($donantes);
        $donantes[$i] = $data;
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