<?php

/*
需到此檔案中設定
- token
- 開發憑證名稱
- gateway
- msg
*/

// 在 ios 中取得 deviceToken
$deviceToken = '32a3bedfc3f17b252b02a218561050f1f86a0ce03136172956fd2f9114151f8c';
//ktb token:8d53b44e88c5e8adba948f2a88d92bfab2249deb3e95dbf7d494d5de5009a640

// Put your private key's passphrase here:
$passphrase = 'test';

// Put your alert message here:
$message = 'hello this is idgate!';

$localcert ='apns_dev.pem';

////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', $localcert);
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
//app store 發布位置
//$fp = stream_socket_client(“ssl://gateway.push.apple.com:2195“, $err, $errstr, 60, //STREAM_CLIENT_CONNECT, $ctx);
//此為 sandbox 測試地址，發佈到 appstore 記得修改
//gateway.sandbox.push.apple.com:2195
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
