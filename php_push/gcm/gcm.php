<?php


function push_gcm($arr)
{
    //申請的API金鑰
    $API_KEY = "AIzaSyCPTtNTYyzprq1a-lD4syP3-RzDa7NENKU";

    //已知的APP推播識別token
    $APP_token = $arr['0'];
    $msg = $arr['1'];

    //設定識別ID
	$registatoin_ids = array($APP_token);
	//設定內容
    $data = array("message" => $msg);

    //設定json內容
    $url = 'https://android.googleapis.com/gcm/send';
	$json = array(
            'registration_ids' => $registatoin_ids,
            'data' => $data,
        );

    $headers = array(
            'Authorization: key=' . $API_KEY,
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
