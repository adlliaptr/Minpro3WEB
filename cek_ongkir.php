<?php
include 'config_API.php';

$origin = $_POST['origin'];
$destination = $_POST['destination'];
$weight = $_POST['weight'];
$courier = $_POST['courier'];

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "origin=$origin&destination=$destination&weight=$weight&courier=$courier",
  CURLOPT_HTTPHEADER => array(
    "content-type: application/x-www-form-urlencoded",
    "key: 93a5677b6e24be57b571af14bbbbbd3c"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo json_encode(array("status" => "error", "message" => "cURL Error #: " . $err));
} else {
  $data = json_decode($response, true);

  if(isset($data['rajaongkir']['results'][0]['costs'])){
    $results = $data['rajaongkir']['results'][0]['costs'];

    $output = [];
    
    foreach ($results as $result) {
        $service = $result['service'];
        $description = $result['description'];
        $biaya = $result['cost'][0]['value'] . " " . $result['cost'][0]['etd'] . " hari";

        $output[] = array(
            "service" => $service,
            "description" => $description,
            "biaya" => $biaya
        );
    }

    echo json_encode($output);
  } else {
    echo json_encode(array("status" => "error", "message" => "No results found"));
  }
}
?>
