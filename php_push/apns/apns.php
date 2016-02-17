<?php

/*

argv
[1]: token
[2]: mode : dev / pro
[3]: passphrase
[4]: message

*/
/*
    $dev_cer_path , $pro_cer_path : 輸入憑證名稱，請將憑證跟此份檔案放同一個位置
    $passphrase : 憑證密碼
*/

function ios_push($arr)
{
    $dev_cer_path = "apns_dev.pem";
    $pro_cer_path = "apns_pro.pem";
    $passphrase = "test";
    // token;
    $deviceToken = $arr['0'];
    $mode = $arr['1'];
    $message = $arr['2'];

    // check mode , dev or pro
    $ssl_gateway;
    $sslCert;
    if ($mode == 'dev') {
        $ssl_gateway = 'ssl://gateway.sandbox.push.apple.com:2195';
        $ssl_cert = $dev_cer_path;
    }
    else if ($mode == 'pro'){
        $ssl_gateway = 'ssl://gateway.push.apple.com:2195';
        $ssl_cert = $pro_cer_path;
    }

    // echo $dev_cer_path;
    // exit;

    ////////////////////////////////////////////////////////////////////////////////
    //驗證socket通道

    $ctx = stream_context_create();
    stream_context_set_option($ctx, 'ssl', 'local_cert', $ssl_cert);
    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

    // Open a connection to the APNS server
    $fp = stream_socket_client($ssl_gateway, $err1,$errstr2, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

    if (!$fp)
    {
        exit("Failed to connect: $err $errstr" . PHP_EOL);
    }

    // Create the payload body
    $body['aps'] = array(
        'alert' => $message,
        'sound' => 'default',
        'badge' => '1',
        'content-available' => '1',
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
}


?>
