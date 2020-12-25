<?php
// AWS SDK for PHPをインクルード
require 'vendor/autoload.php';
 
use Aws\Credentials\CredentialProvider;
use Aws\Ses\SesClient;
use Aws\Exception\AwsException;
 
// iniファイルで設定した[]のテキストを設定
// 今回はdefault
$profile   = 'default';
 
// iniファイルのパス
$path      = 'ses_key.ini';
 
// iniファイルでの認証するための処理
$provider = CredentialProvider::ini($profile, $path);
$provider = CredentialProvider::memoize($provider);
 
// SES用オブジェクト生成
$client = new SesClient([
    'region' => 'ap-northeast-1',
    'version' => '2010-12-01',
    'credentials' => $provider
]);
 
// 送信元メールアドレス
$from_email = 'from_address@xxx';
 
//送信者名表示
$from_name = mb_encode_mimeheader("サンプル太郎",'utf-8')." <{$from_email}>";
 
// 送信先メールアドレス
$to_email = 'to_address@xxx';
 
// メール件名
$subject        = 'テストメール';
// メール本文
$plaintext_body = 'テストメール本文ですよ';
// 文字コード
$char_set       = 'UTF-8';
 
try {
      
    // メール送信
    $result    = $client->sendEmail([
        'Destination' => [
            'ToAddresses' => [$to_email],
        ],
        'ReplyToAddresses' => [$from_email],
        'Source' => $from_name,
        'Message' => [
            'Body' => [
                'Text' => [
                    'Charset' => $char_set,
                    'Data' => $plaintext_body,
                ],
            ],
            'Subject' => [
                'Charset' => $char_set,
                'Data' => $subject,
            ],
        ],
         
    ]);
    $messageId = $result['MessageId'];
    echo("送信成功! Message ID: $messageId" . "\n");
} catch (AwsException $e) {
    // output error message if fails
    echo $e->getMessage();
    echo("送信に失敗しました：" . $e->getAwsErrorMessage() . "\n");
    echo "\n";
}