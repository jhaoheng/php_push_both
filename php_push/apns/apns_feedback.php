<?php

function apns_feedback()
{
    $stream_context = stream_context_create();
    stream_context_set_option($stream_context, 'ssl', 'local_cert', 'apns_dev.pem');
    stream_context_set_option($stream_context, 'ssl', 'passphrase', 'test');
    $apns = stream_socket_client('ssl://feedback.sandbox.push.apple.com:2196', $errcode, $errstr, 60, STREAM_CLIENT_CONNECT, $stream_context);

    if(!$apns) {
        echo "ERROR $errcode: $errstr\n";
        return;
    }

    $feedback_tokens = array();
    //and read the data on the connection:
    while(!feof($apns)) {
        $data = fread($apns, 38);
        if(strlen($data)) {
            $feedback_tokens[] = unpack("N1timestamp/n1length/H*devtoken", $data);
        }
    }
    fclose($apns);
    // echo $feedback_tokens;
    // var_dump($feedback_tokens);
    foreach ($feedback_tokens as $key => $value) {

        echo "[".$key ."] :<br>";
        foreach ($value as $key2 => $value2) {
            if ($key2=='timestamp') {
                $value2 = date('Y-m-d H:i:s', $value2);
            }
            echo $key2 ." => ". $value2 ."<br>";
        }
        echo "<br>";
    }
}

?>
