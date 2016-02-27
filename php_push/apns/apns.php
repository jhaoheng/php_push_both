<?php

/*
    $apns_phasePass : 憑證密碼
*/

function apns_push($arr)
{
    $apns_mode = $arr['apns_mode'];
    $apns_phasePass = $arr['apns_phasePass'];
    $apns_pem_path = $arr['apns_pem_path'];
    $apns_token = $arr['apns_token'];
    $apns_message = $arr['apns_message'];

    if(empty($apns_token))
    {
        echo "error : empty token";
    }

    // check mode , dev or pro
    $ssl_gateway;
    if ($apns_mode == 'dev') {
        $ssl_gateway = 'ssl://gateway.sandbox.push.apple.com:2195';
    }
    else if ($apns_mode == 'pro'){
        $ssl_gateway = 'ssl://gateway.push.apple.com:2195';
    }
    $ssl_cert = $apns_pem_path;

    ////////////////////////////////////////////////////////////////////////////////
    //驗證socket通道

    $ctx = stream_context_create();
    stream_context_set_option($ctx, 'ssl', 'local_cert', $ssl_cert);
    stream_context_set_option($ctx, 'ssl', 'passphrase', $apns_phasePass);

    // Open a connection to the APNS server
    $fp = stream_socket_client($ssl_gateway, $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

    if (!$fp)
    {
        exit("Failed to connect: $err $errstr" . PHP_EOL);
    }

    // // Create the payload body = $apns_message
    // $body['aps'] = array(
    //     'alert' => $message,
    //     'sound' => 'default',
    //     'badge' => '1',
    //     'content-available' => '1',
    // );

    // Encode the payload as JSON
    $payload = json_encode($apns_message);

    // Build the binary notification
    $msg = chr(0) . pack('n', 32) . pack('H*', $apns_token) . pack('n', strlen($payload)) . $payload;

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
