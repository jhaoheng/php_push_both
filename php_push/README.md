## README

主要檔案

- config : 設定所有 apns / gcm 相關參數，只需調整此設定檔
- push_main.php : 
- apns.php :
- gcm.php :

## push_main

1. 透過 get 設定參數
ex:

	```
	http://[host_name]:[port]/push_main.php?category=&DeviceToken=&trannum=&PushSubject=
	```

2. get 參數相關
	- category : 設定要推播的裝置為 **android** or **ios**
	- DeviceToken : 推送裝置手機 token
	- PushSubject : 推送內容

3. 關於 config.php
	- $is_show_log : 顯示 log 在畫面上
	- 測試設定 : 開啟測試，可用測試參數進行推播，可針對特定裝置推播
	- ios 參數設定 : 含 推播模式、金鑰密碼、token、推播內容...等，設定可調整。
	- android 參數設定 : $gcm_API_KEY、$gcm_token、$gcm_message 
