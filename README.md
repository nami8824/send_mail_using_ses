# send_mail_using_ses
Amazon SESを使ってテスト用にmail送信する

## composer インストール
aws/aws-sdk-phpを使えるように

## 鍵情報を入力
IAMで取得した、Amazon SESをプログラム経由で利用するための情報を取得して
ses_key.iniの中のaws_access_key_idとaws_secret_access_keyを入力

## 送信元、送信先のアドレスを入力
send.phpを編集してAmazon SESで認証されたメールアドレスを$from_email,$to_emailに入力

## 送信する
php send.php
をコマンドで実行して送信
