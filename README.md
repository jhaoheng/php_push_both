# README

php 推播

- apns_sampleApp : ios objc app sample
- gcm_sampleApp : android app sample
- ios_apns_test : only ios push, use php. Include easy version and log version
- php_push : both push gcm and apns.

## ios_apns_test

1. php_apns.php : 簡單版的 php 推播，在 php 中設定相關參數
2. php_apns_cli.php : 透過指令，取得相關參數 

## php_push

- push_main.php : 主要推播的檔案
	- apns/apns.php : 
	- gcm/gcm.php : 
- config.php : 設定所有 apns / gcm 相關參數，設定好此項目即可推播


## gcm

- 關於 gcm 送出格式問題
	- gcm.php
		- 確定 $data 送出的對應陣列格式是否與手機端相同，若不相同，則手機無法顯示
	- config.php
		- 確定 $gcm_message 中的格式，是否與手機相同，否則手機無法顯示

# APP

- apns_sampleApp : 處理 apns log 
- gcm_sampleApp : 處理 gcm log