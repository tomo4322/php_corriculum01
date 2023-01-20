<?php

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: contact.php");
    exit();
}
session_start();

require_once(ROOT_PATH .'Controllers/ContactControl.php');
Message(); //ポスト値をセッション値に変換

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>お問い合わせ確認画面</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/contact.css">
</head>
<body>
    <div class="contact-container">
        <h1 class="contact_title">確認画面</h1>
        <form action="./complete.php" method="post" name="form">
            <table class="contact-table">
                <tr>
                    <th class="contact-item">氏名</th>
                    <td class="contact-body">
                        <input  name="fullname" class="form-text" value="<?php echo htmlspecialchars($_SESSION['fullname'], ENT_QUOTES) ?>"/>
                    </td>
                </tr>
                <tr>
                    <th class="contact-item">フリガナ</th>
                    <td class="contact-body">
                        <input  name="furigana" class="form-text" value="<?php echo htmlspecialchars($_SESSION['furigana'], ENT_QUOTES) ?>"/>
                    </td>
                </tr>
                <tr>
                    <th class="contact-item">電話番号</th>
                    <td class="contact-body">
                        <input  name="tellNumber" class="form-text" value="<?php echo htmlspecialchars($_SESSION['tellNumber'], ENT_QUOTES) ?>"/>
                    </td>
                </tr>
                <tr>
                    <th class="contact-item">メールアドレス</th>
                    <td class="contact-body">
                        <input  name="email" class="form-text" value="<?php echo htmlspecialchars($_SESSION['email'], ENT_QUOTES) ?>"/>
                    </td>
                </tr>
                <tr>
                    <th class="contact-item">お問い合わせ内容</th>
                    <td class="contact-body">
                    <textarea cols="40" rows="8" name="message"><?php echo htmlspecialchars($_SESSION['message'], ENT_QUOTES) ?></textarea>
                    </td>
                </tr>
            </table>
            <div class="confirmMessage">
                <p>上記の内容でよろしいですか？</p>
            </div>
            <div class="submit-confirm">
                <input type="submit" name="submit" value="キャンセル" onClick="form.action='contact.php';return true">
            </div>
            <div class="submit-confirm">
            <input type="submit" name="submit" value="送信" onClick="form.action='complete.php';return true">
            </div>
        </form>
    <div>
</body>
