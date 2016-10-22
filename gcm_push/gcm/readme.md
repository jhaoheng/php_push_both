![img](https://developers.google.com/cloud-messaging/images/notifications-overview.svg)

- app 註冊 token 後，若刪除 app，則 gcm 一樣會回送 
	`{"multicast_id":7074160172763484045,"success":0,"failure":1,"canonical_ids":0,"results":[{"error":"NotRegistered"}]}`
