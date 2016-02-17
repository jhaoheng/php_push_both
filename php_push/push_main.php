<?php
include ("apns/apns.php");
include ("gcm/gcm.php");

//包含:
// - category : 種類，'ios'、'android'
// - DeviceToken : 裝置推播號碼
// - PushSubject : 推播顯示文字

$category = $_GET['category'];

$DeviceToken = $_GET['DeviceToken'];
$PushSubject = $_GET['PushSubject'];


//測試用:(ios)
// $category = 'ios';
// $DeviceToken = '32a3bedfc3f17b252b02a218561050f1f86a0ce03136172956fd2f9114151f8c';
// $PushSubject = 'hello';



//測試用:(android)
// $category = 'android';
// $DeviceToken = '';
// $trannum = '';


if ($category == 'ios') {

    //send ios push
    //0:mode
    //1:DeviceToken
    //2:msgContent : $PushSubject
    $infoArr = array($DeviceToken, 'dev', $PushSubject);
    ios_push($infoArr);
}
elseif ($category == 'android') {

    //send android push
    //0:DeviceToken
    //1:msg : $PushSubject
    $infoArr = array($DeviceToken, $PushSubject);
    gcm_push($infoArr);
}


?>
