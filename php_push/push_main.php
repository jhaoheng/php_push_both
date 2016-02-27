<?php
include ("config.php");
include ("apns/apns.php");
include ("gcm/gcm.php");


if ($category == "ios") {

    $infoArr = array(
        'apns_mode' => $apns_mode,
        'apns_phasePass' => $apns_phasePass,
        'apns_pem_path' => $apns_pem_path,
        'apns_token' => $apns_token,
        'apns_message' => $apns_message);

    apns_push($infoArr);
}
else if ($category == "android") {
    
    $infoArr = array(
        'gcm_API_KEY' => $gcm_API_KEY,
        'gcm_token' => $gcm_token,
        'gcm_message' => $gcm_message);

    gcm_push($infoArr);
}
else {
    echo "error category!!";
}

//debug view
if ($is_show_log == "yes") {
    echo "<br><br><hr><br>測試參數:<br><br>";
    foreach ($infoArr as $key => $value) {
        echo "'" . $key . "' => ";
        if (!is_array($value)) {
            echo $value."<br>";
        }
        else {
            echo "<br>";
            ($category == 'ios') ? $value=$value[aps] : $value;
            foreach ($value as $key2 => $value2) {
                echo "[" . $key2 . " => " . $value2 . "]" . "<br>";
            }
            // var_dump($value);
        }
        echo "<br>";
    }
}

?>
