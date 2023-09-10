<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.scorer.gitcoin.co/registry/stamps/0x00De4B13153673BCAE2616b67bf822500d325Fc3?limit=1000&include_metadata=false');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  'accept: application/json',
  'X-API-Key: TNEGHQEp.vsTwO4RyQrl24yzxMPst8qEoGDjKhMCU',
]);

$response = curl_exec($ch);

curl_close($ch);

print_r($response);