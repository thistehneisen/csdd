<?php

require_once 'init.php';
use PHPHtmlParser\Dom;
use PHPHtmlParser\Options;

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
$cookies['userSawThatSiteUsesCookies'] = '1';

foreach ($cookies as $key => $val) {
    $cookieStr .= $key . '=' . $val . '; ';
}

curl_close($curl);

$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_URL, E_CSDD . 'tadati/');
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Cookie: ' . $cookieStr));
for ($i = 65; $i <= 90; $i++) {
    $L1 = chr($i);
    for ($j = 65; $j <= 90; $j++) {
        $L2 = chr($j);
        for ($x=1; $x <= 9999; $x++) {
            $sleepTime = 3;
            $VNZ = $L1.$L2.$x;
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(['rn' => $VNZ]));

            retry_vnz:
            $sleepTime++;
            $response = curl_exec($curl);

            if (strpos($response, 'Aizdomas par robota') !== false) {
                echo 'ROBOOOOT'.PHP_EOL;
                sleep($sleepTime);
                goto retry_vnz;
            }

            $dom = new Dom;
            $dom->loadStr($response);

            $tableText = $dom->find('#refer-table');
        
            foreach ($tableText as $i => $data) {
                $fullData .= $data->innerHtml;
            }

            $db->insert('vehicle_numbers', [
                'vnz'               => $VNZ,
                'data'              => $fullData,
                'response'          => $response
            ]);

            unset($dom, $tableText, $fullData, $sleepTime);
        }
    }
}