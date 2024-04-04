<?php
// Konfigurasi API RajaOngkir
define('RAJAONGKIR_ENDPOINT', 'https://api.rajaongkir.com/starter');
define('RAJAONGKIR_API_KEY', '93a5677b6e24be57b571af14bbbbbd3c'); // Ganti dengan API Key Anda

function getProvinsi() {
    global $conn;
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => RAJAONGKIR_ENDPOINT . "/province",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array(
            "key: " . RAJAONGKIR_API_KEY
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "Error: " . $err;
    } else {
        $data = json_decode($response, true);
        return $data['rajaongkir']['results'];
    }
}

function getKota($province_id) {
    global $conn;
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => RAJAONGKIR_ENDPOINT . "/city?province=" . $province_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array(
            "key: " . RAJAONGKIR_API_KEY
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "Error: " . $err;
    } else {
        $data = json_decode($response, true);
        return $data['rajaongkir']['results'];
    }
}

function getNamaProvinsi($province_id) {
    $provinsi = getProvinsi();
    foreach ($provinsi as $item) {
        if ($item['province_id'] == $province_id) {
            return $item['province'];
        }
    }
    return '';
}

function getNamaKota($city_id) {
    global $conn;
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => RAJAONGKIR_ENDPOINT . "/city?id=" . $city_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array(
            "key: " . RAJAONGKIR_API_KEY
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "Error: " . $err;
    } else {
        $data = json_decode($response, true);
        if(isset($data['rajaongkir']['results'])) {
            return $data['rajaongkir']['results']['city_name'];
        }
    }
    return '';
}



function getLayananPengiriman($origin, $destination, $weight, $courier) {
    global $conn;
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => RAJAONGKIR_ENDPOINT . "/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query([
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier
        ]),
        CURLOPT_HTTPHEADER => array(
            "key: " . RAJAONGKIR_API_KEY
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "Error: " . $err;
    } else {
        $data = json_decode($response, true);
        return $data['rajaongkir']['results'];
    }
}

$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action == 'getProvinsi') {
    $provinsi = getProvinsi();
    echo json_encode($provinsi);
}

if ($action == 'getKota') {
    $province_id = $_POST['province_id'];
    $kota = getKota($province_id);
    echo json_encode($kota);
}


?>
