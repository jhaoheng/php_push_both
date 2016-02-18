## README

主要檔案

- push_main.php : 內有預設測試參數，不用特別傳遞 get，開啟註解可使用
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

3. 關於 ios 
	- 有多一個參數 "dev" 與 "pro"
		- 若選擇 dev，則使用 apns_dev.pem 的憑證
		- 若選擇 pro，則使用 apns_pro.pem 的憑證
	- 關於 pem 憑證，制式名稱為 ```apns_dev.pem``` 與 ```apns_pro.pem```
	- 設定憑證密碼，請至 ```apns.php```
4. 關於 gcm
	- 金鑰 api_key，請至 gcm.php 修改 