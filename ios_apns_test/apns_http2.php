<?php
//http://qiita.com/itosho/items/2402df4de85b360d5bd9

if(defined('CURL_HTTP_VERSION_2_0')){

    $device_token   = '1a6869c947894a9df0a0974bf149edd4ea841fd24544ccc7d00ed7c928cb4ead';
    $pem_file       = 'apns_pro.pem';
    $pem_secret     = 'test';
    $apns_topic     = 'com.idgatetest.testapp';


    $sample_alert = '{"aps":{"alert":"hi","sound":"default"}}';
    $url = "https://api.push.apple.com/3/device/$device_token";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $sample_alert);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("apns-topic: $apns_topic","content-length: 4096"));
    curl_setopt($ch, CURLOPT_SSLCERT, $pem_file);
    curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $pem_secret);
    // curl_setopt($ch, CURLOPT_SSLVERSION, 3);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);


    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    //On successful response you should get true in the response and a status code of 200
    //A list of responses and status codes is available at
    //https://developer.apple.com/library/ios/documentation/NetworkingInternet/Conceptual/RemoteNotificationsPG/Chapters/TheNotificationPayload.html#//apple_ref/doc/uid/TP40008194-CH107-SW1
    echo "<br>response : <br>";
    var_dump($response);
    echo "<br>";
    echo "<br>httpcode : <br>";
    var_dump($httpcode);

    //測試用
    $info = curl_getinfo($ch);
    // $errno = curl_errno($ch);
    $error = curl_error($ch);
    //
    //
    echo "<br>";
    echo "<br>";
    // echo $info;
    var_dump($info);
    echo "<br>";
    // echo "<br>errno:<br>";
    // var_dump($errno);
    echo "<br>";
    echo "<br>error:<br>";
    var_dump($error);
}
else {
    echo "no support";
}
?>
