<?php
session_start();


require_once(ROOT_PATH .'Controllers/ContactControl.php');
$tableData = new ConnectDb();


if (isset($_POST['update']) && $_POST['update']) {  //更新ボタンクリックするとバリデーションし、エラーメッセージを$errorに戻り値として渡す。エラーが無ければ更新処理を行う。
    $Contact = new Contact();
    $error = $Contact->tableUpdate();
} elseif (!isset($_GET['id']) || $_GET['id'] == "") {  //ゲット値が空であれば
    header("Location: contact.php");
    exit();
}


if (isset($_GET['id']) && $_GET['id']) {    //contact.phpからidの値をGET形式で受け取ったとき
    $_SESSION = [];
    $tableData->showTableData();
} elseif (isset($_GET['id']) && $_GET['id'] && empty($tableData->dbCulum)) { //idの値をGETできなかったとき
    header("Location: contact.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>データ更新画面</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/contact.css">
</head>
<body>
    <div class="contact-container">
        <h1 class="contact_title">更新画面</h1>
        <div class="errorMessate">
            <?php
            if (!empty($error)) {
                echo implode('<br>', $error);
            }
            ?>
        </div>
        <form action="./update.php" method="post" name="form">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($_SESSION['id'] ?? $tableData->dbCulum[0]['id'], ENT_QUOTES); ?>">
            <table class="contact-table">
                <tr>
                    <th class="contact-item">氏名</th>
                    <td class="contact-body">
                        <input type="text" name="fullname" class="form-text" value="<?php echo htmlspecialchars($_SESSION['fullname'] ?? $tableData->dbCulum[0]['fullname'], ENT_QUOTES); ?>"/>
                    </td>
                </tr>
                <tr>
                    <th class="contact-item">フリガナ</th>
                    <td class="contact-body">
                        <input type="text" name="furigana" class="form-text" value="<?php echo htmlspecialchars($_SESSION['furigana'] ?? $tableData->dbCulum[0]['kana'], ENT_QUOTES); ?>"/>
                    </td>
                </tr>
                <tr>
                    <th class="contact-item">電話番号</th>
                    <td class="contact-body">
                        <input type="tell" name="tellNumber" class="form-text" value="<?php echo htmlspecialchars($_SESSION['tellNumber'] ?? $tableData->dbCulum[0]['tel'], ENT_QUOTES); ?>"/>
                    </td>
                </tr>
                <tr>
                    <th class="contact-item">メールアドレス</th>
                    <td class="contact-body">
                        <input type="email" name="email" class="form-text" value="<?php echo htmlspecialchars($_SESSION['email'] ?? $tableData->dbCulum[0]['email'], ENT_QUOTES); ?>"/>
                    </td>
                </tr>
                <tr>
                    <th class="contact-item">お問い合わせ内容</th>
                    <td class="contact-body">
                    <textarea cols="40" rows="8" name="message"><?php echo htmlspecialchars($_SESSION['message'] ?? $tableData->dbCulum[0]['body'], ENT_QUOTES); ?></textarea>
                    </td>
                </tr>
            </table>
            <div class="confirmMessage">
                <p>上記の内容でよろしいですか？</p>
            </div>
            <div class="submit-confirm">
            <input type="submit" name="cansel" value="キャンセル" onclick="location.href='contact.php?id=1 ">
            </div>
            <div class="submit-confirm">
            <input type="submit" name="update" value="更新">
            
        </form>

    <div>
</body>
