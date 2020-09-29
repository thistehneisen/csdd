<?php

require_once 'library/constants.php';

$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, 1);

$params = array(
    'email'     => E_CSDD_LOGIN,
    'psw'       => E_CSDD_PASSWORD,
    'longses'   => '1'
);

curl_setopt($curl, CURLOPT_URL, E_CSDD . 'login/?action=doLogin');
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));

$response = curl_exec($curl);

$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
$header = substr($response, 0, $header_size);
$body = substr($response, $header_size);

preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $header, $matches);
$cookies = array();
foreach ($matches[1] as $item) {
    parse_str($item, $cookie);
    $cookies = array_merge($cookies, $cookie);
}

var_dump($header);
var_dump($body);
var_dump($cookies);

if (1 === 2) {
    $curl       = curl_init();
    $params     = ['rn' => 'MK2248'];

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, E_CSDD . 'tadati/');
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Cookie: test=cookie"));
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));

    $response = curl_exec($curl);
    var_dump($response);
}
