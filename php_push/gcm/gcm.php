<?php


function gcm_push($arr)
{
    $gcm_API_KEY = $arr['gcm_API_KEY'];
    $gcm_token = $arr['gcm_token'];
    $gcm_message = $arr['gcm_message'];

    if(empty($gcm_token))
    {
        echo "empty token";
    }

    //設定識別ID
	$registatoin_ids = array($gcm_token);
	//設定內容
    $data = array("message" => $gcm_message);

    //設定json內容
    $url = 'https://android.googleapis.com/gcm/send';
	$json = array(
            'registration_ids' => $registatoin_ids,
            'data' => $data,
        );

    $headers = array(
            'Authorization: key=' . $gcm_API_KEY,
            'Content-Type: application/json'
        );

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);	//忽略SSL驗證
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($json));
	$result = curl_exec($curl);
	curl_close($curl);
    echo $result;
	echo "<hr>";
}

?>
