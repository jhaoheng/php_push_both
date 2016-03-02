[Binary Provider API](https://developer.apple.com/library/ios/documentation/NetworkingInternet/Conceptual/RemoteNotificationsPG/Appendixes/BinaryProviderAPI.html)

推播的 api 有兩種

- [Binary Provider API](https://developer.apple.com/library/ios/documentation/NetworkingInternet/Conceptual/RemoteNotificationsPG/Appendixes/BinaryProviderAPI.html) (目前使用) 
	- gateway : 
		- gateway.push.apple.com, port 2195
		- gateway.sandbox.push.apple.com, port 2195
	- feedback : 
		-  feedback.push.apple.com on port 2196
		-  feedback.sandbox.push.apple.com on port 2196  
- [APNs Provider API](https://developer.apple.com/library/ios/documentation/NetworkingInternet/Conceptual/RemoteNotificationsPG/Chapters/APNsProviderAPI.html#//apple_ref/doc/uid/TP40008194-CH101-SW1)
	- Development server: api.development.push.apple.com:443
	- Production server: api.push.apple.com:443


## 多國語言

- apns 中，若 push 想顯示多國語言，可設定 `loc-key and loc-args properties of the aps payload dictionary for client-side fetching of localized alert strings`
- 或者，利用 token 註冊時，返回用戶裝置的語言，並且經由 server 直接推播該本地化語言，因推播顯示會依照 server 推送過來的文字，直接顯示。

## binary Notification format(非 apns api)

![img1](https://developer.apple.com/library/ios/documentation/NetworkingInternet/Conceptual/RemoteNotificationsPG/Art/aps_binary_provider_3_2x.png)

- 根據上圖 Frame data 的封裝，是可以同時封裝多組 item(message)


## payload

[The Remote Notification Payload](https://developer.apple.com/library/ios/documentation/NetworkingInternet/Conceptual/RemoteNotificationsPG/Chapters/TheNotificationPayload.html#//apple_ref/doc/uid/TP40008194-CH107-SW1)

## 測試同時多組發送-測試共 100 push

1. 直接重複送出整組 : 穩定，全接收到，測試100x3組，全收到

2. 延伸 msg : lost 封包，99/100，94/100，96/100
	- 總執行 50 次
	- 開啟通道
	- 延伸 $msg x2
	- 一次 fwrite 送出
	- 關閉通道

3. fwrite : lost 封包，63/100，100/100，99/100，98/100
	- 總執行 50 次
	- 開啟通道
	- (一組 msg 對應一個 fwrite ) x2
	- 關閉通道
 

