<?php

$order = array (
  'campaign_id' => '919520',
  'ip' => $_SERVER["HTTP_CF_CONNECTING_IP"],
  'name' => $_POST['name'],
  'phone' => $_POST['phone'],
  'sid1' => $_SERVER["HTTP_HOST"]
);


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://tracker.everad.com/conversion/new" );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_POST,           1 );
curl_setopt($ch, CURLOPT_POSTFIELDS,     http_build_query($order) );
curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/x-www-form-urlencoded'));

$result=curl_exec ($ch);

if ($result === 0) {
  echo "Timeout! Everad CPA 2 API didn't respond within default period!";
} else {
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  if ($httpCode === 200) {
    require_once('_thankyou/ok.php');
  } else if ($httpCode === 400) {
    echo "Order data is invalid! Order is not accepted!";
  } else {
    echo
    "Unknown error happened! Order is not accepted! Check campaign_id, probably no landing exists for your campaign!";
  }
}
