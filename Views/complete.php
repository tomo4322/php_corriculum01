<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: contact.php");
    exit();
}

require_once(ROOT_PATH .'Controllers/ContactControl.php');
$insertData = new ConnectDb();
$insertData->index(); //ポストされた値をDbに保存



?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>お問い合わせ完了画面</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/contact.css">
</head>
<body>
    <div class="complete-container">
        <h1 class="complete_title">完了画面</h1>
        <div class="completText">
            <h2 class="thanksMessage">
                お問い合わせ内容を送信しました。<br>
                ありがとうございました。
            </h2>
        </div>
        <div class="completeBtn"><a href="index.php">トップ画面へ</a></div>
    </div>
</body>