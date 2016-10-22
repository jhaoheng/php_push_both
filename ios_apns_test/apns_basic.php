<?php

/*
需到此檔案中設定
- token
- 開發憑證名稱
- gateway
- msg
*/

// 在 ios 中取得 deviceToken
$deviceToken = '54b12748b9aa3bc204a96146743e38077d0bbe158139741ae74f746b840a668c';

$message = 'hello!';

$localcert ='./apns_dev.pem';

////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', $localcert);
// stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

//gateway.sandbox.push.apple.com:2195
//gateway.push.apple.com:2195
$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
$body['aps'] = array(
'alert' => $message,
'sound' => 'default',
'badge' => '1',
'content-available' => '1'
);

// Encode the payload as JSON
$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result)
echo 'Message not delivered' . PHP_EOL;
else
echo 'Message successfully delivered' . PHP_EOL;

// Close the connection to the server
fclose($fp);
?>
