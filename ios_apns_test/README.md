# README

此為單獨測試 ios 的推播版本

## php_apns_cli
此為透過指令的方式推送 apns

```
php php_noti_cli.php argv[1] argv[2] argv[3] argv[4]
```

會寫下錯誤 log

## php_apns

透過網頁呼叫此 .php  
在頁面內確定相關資料即可推播

---

憑證命名：apns_dev.pem

放同一個資料夾即可

## 將 cer->pem  
```
openssl x509 -in develop.cer -inform der -out develop.pem
```
  
## 將 p12->pem  
```
openssl pkcs12 -nocerts -out developKey.pem -in developKey.p12
--
Enter Import Password://可不輸入
MAC verified OK
Enter PEM pass phrase://一定要輸入
Verifying – Enter PEM pass phrase:
```

## 將 憑證.pem 與 金鑰.pem 合併
```
cat develop.pem developKey.pem > apns_dev.pem
apnd_dev.pem 請與 php 放到同一個目錄下
```

- 測試電腦中，安裝的證書，是否可正常運作 ```telnet gateway.sandbox.push.apple.com 2195```  
Trying 17.172.232.226…  
Connected to gateway.sandbox.push-apple.com.akadns.net.  
Escape character is ‘^]’.  
她會嘗試發送一個規則的，不加密的連接到 APNS 服務。如果你看到上面的反饋，那就說明你的 MAC 能夠連到 APNS。
按下 CTRL+C 關閉連接。如果得到一個錯誤訊息，那麼請確保你的防火牆允許通過 2195 的 port。

- 測試剛剛產生的 憑證(pem)與金鑰(pem) 是否可正常運作 ```openssl s_client -connect gateway.sandbox.push.apple.com:2195 -cert develop.pem -key developKey.pem```  
你會看到一個完整的輸出，如果連接是成功的，你可以輸入一些字符。當你按下 enter ，服務就會斷開。  
若有問題，則 openssl 將會給你一個錯誤消息。

## 將最後的憑證轉為 p12
```
openssl pkcs12 -export -in develop.pem -inkey developKey.pem -out bundle.p12
```

