<?php

/*
ex: php php_noti_cli.php argv[1] argv[2] argv[3] argv[4]

ex1: [dev]
php php_noti_cli.php [token] dev [pass] [here is MAX!!]

ex2: [pro]
php php_noti_cli.php [token] dev [pass] [here is MAX!!]

argv
[1]: token
[2]: mode : dev / pro
[3]: passphrase
[4]: message

*/

$is_show_log = 1; // 是否顯示在畫面上
$is_force_write_log = 1; // 強制寫入，若 0 則只有錯誤才寫入 log
$error_flag = 0;
$log_msg;

function isArgvErr($temp)
{
    for ($i=1; $i<=4 ; $i++) {
        if ( empty($temp[$i]) ) {
            return 1;
        }
    }
}

function logWrite($err_msg='')
{
    $log_w = fopen('error_log.txt', 'at');
    fwrite($log_w, $err_msg);
    fclose($log_w);
}

// if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
// {
//     echo 'This is a server using Windows!';
// }

$log_msg = PHP_EOL.PHP_EOL;
$log_msg = $log_msg. "======================================";
$log_msg = $log_msg. PHP_EOL.PHP_EOL;

date_default_timezone_set('Asia/Taipei');
$log_msg = $log_msg . "date : " . date("Y-m-d h:i:sa") . PHP_EOL.PHP_EOL;

///////////////////////////////////
// check cli argv
if (isArgvErr($argv)){
    $log_msg = $log_msg .  "**** Argv sentence is error, plz check your sentence ****".PHP_EOL;
    $error_flag = 1;
}
else {
    // token;
    $deviceToken = $argv[1];

    $log_msg = $log_msg . "deviceToken is : " . $deviceToken . PHP_EOL;

    // check mode , dev or pro
    $mode;
    $ssl_gateway;
    $sslCert;
    if ($argv[2] == 'dev') {
        $mode = 'dev';
        $ssl_gateway = 'ssl://gateway.sandbox.push.apple.com:2195';
        $ssl_cert = 'apns_dev.pem';
    }
    else if ($argv[2] == 'pro'){
        $mode = 'pro';
        $ssl_gateway = 'ssl://gateway.push.apple.com:2195';
        $ssl_cert = 'apns_pro.pem';
    }
    else {
        $error_flag = 1;
    }

    $log_msg = $log_msg . "Push mode is : " . $mode . PHP_EOL;
    $log_msg .= "ssl_gateway is : " . $ssl_gateway . PHP_EOL;
    $log_msg .= "ssl_cert is : " . $ssl_cert . PHP_EOL;
    // Put your private key's passphrase here:
    $passphrase = $argv[3];

    // Put your alert message here:
    $message = $argv[4];
    $log_msg .= "MSG is : " . PHP_EOL .$message . PHP_EOL;
}

// 錯誤 || 強制寫入 log，若將強制寫入關閉，則只有“錯誤”才會紀錄
if ( $error_flag )
{
    goto finish;
}

////////////////////////////////////////////////////////////////////////////////
//驗證socket通道

$log_msg .= PHP_EOL.PHP_EOL;

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', $ssl_cert);
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client($ssl_gateway, $err1,$errstr2, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
{
    $error_flag = 1;
    $log_msg .= "Failed to connect: $err1 $errstr2" . PHP_EOL;
    goto finish;
    // exit("Failed to connect: $err $errstr" . PHP_EOL);
}

$log_msg .= 'Connected to APNS' . PHP_EOL.PHP_EOL;

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
    $log_msg .= 'Message not delivered' . PHP_EOL;
else
    $log_msg .= 'Message successfully delivered' . PHP_EOL;

// Close the connection to the server
fclose($fp);


//
finish:

$log_msg = $log_msg. PHP_EOL ."======================================";
$log_msg = $log_msg. PHP_EOL.PHP_EOL;

if ( $error_flag || $is_force_write_log ) {
    logWrite($log_msg);
}

if ($is_show_log) {
    echo $log_msg . PHP_EOL;
}
// if ($error_flag) {
//     exit;
// }

?>
