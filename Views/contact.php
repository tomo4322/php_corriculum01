<?php
ini_set('display_errors', "On");

session_start();
header('Expires:-1');
header('Cache-Control:');
header('Pragma:');


// ポストが空、update.php内キャンセルボタンクリック時にセッションを初期化
if (isset($_GET['id']) === 1 || empty($_POST)) {
    $_SESSION['fullname']   = '';
    $_SESSION['furigana']   = '';
    $_SESSION['tellNumber'] = '';
    $_SESSION['email']      = '';
    $_SESSION['message']    = '';
}


require_once(ROOT_PATH .'Controllers/ContactControl.php');
$errors = new Contact();   //バリデーション用
$DbData = new ConnectDb(); //Db関係

// 削除ボタンクリック時の処理
if (isset($_GET['delete_id'])) {
    $DbData->delete();
}

// Dbに登録されているデータを呼び出す
$DbData->show();


?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>お問い合わせフォーム</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/contact.css">
</head>
<body>
    <div class="contact-container">
        <h1 class="contact_title">お問い合わせ</h1>
        <div class="errorMessage">
            <?php $errors->check();?> <!--- バリデーション実行、エラーメッセージが無ければconfirm.phpに移動 --->
        </div>
        <div class="form-wrapper">
            <form action="./contact.php" method="post" name="form">
                <table class="contact-table">
                    <tr>
                        <th class="contact-item">氏名</th>
                        <td class="contact-body">
                            <input type="text" name="fullname" class="form-text" value="<?php echo htmlspecialchars($_SESSION['fullname'], ENT_QUOTES); ?>"/> 
                        </td>
                    </tr> 
                    <tr>
                        <th class="contact-item">フリガナ</th>
                        <td class="contact-body">
                            <input type="text" name="furigana" class="form-text" value="<?php echo htmlspecialchars($_SESSION['furigana'], ENT_QUOTES); ?>"/> 
                        </td>
                    </tr>
                    <tr>
                        <th class="contact-item">電話番号</th>
                        <td class="contact-body">
                            <input type="tell" name="tellNumber" class="form-text" value="<?php echo htmlspecialchars($_SESSION['tellNumber'], ENT_QUOTES); ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th class="contact-item">メールアドレス</th>
                        <td class="contact-body">
                            <input type="email" name="email" class="form-text" value="<?php echo htmlspecialchars($_SESSION['email'], ENT_QUOTES);?>"/> 
                        </td>
                    </tr>
                    <tr>
                        <th class="contact-item">お問い合わせ内容</th>
                        <td class="contact-body">
                        <textarea cols="40" rows="8" name="message"><?php echo htmlspecialchars($_SESSION['message'], ENT_QUOTES); ?></textarea>
                        </td>
                    </tr>
                </table>
                <div class="submit"><input type="submit" name="check" class="btn" value="確認画面へ"></div>
                <div class="data-table">
                    <table class="dataTable">
                        <tr>
                            <th>氏名</th>
                            <th>フリガナ</th>
                            <th>電話番号</th>
                            <th>メールアドレス</th>
                            <th>お問い合わせ内容</th>
                            <th>編集</th>
                            <th>削除</th>
                        </tr> 
                        <!--- Dbから取得したデータをループさせて表示 --->
                            <?php foreach ($DbData->contactsData as $dbCulum) : ?>
                                <tr>
                                    <td><?php echo $dbCulum['fullname']; ?></td>
                                    <td><?php echo $dbCulum['kana']; ?></td>
                                    <td><?php echo $dbCulum['tel']; ?></td>     
                                    <td><?php echo $dbCulum['email']; ?></td>
                                    <td><?php echo $dbCulum['body']; ?></td>
                                    <td>
                                        <a class="btn" href="update.php?id=<?php echo $dbCulum['id']; ?>'">編集</a> <!--- 編集ボタンクリック時にクリック箇所のidをGETでupdate.phpに渡している --->
                                    </td>
                                    <td class="delete">
                                        <a href="contact.php?delete_id=<?php echo $dbCulum['id']; ?>" onclick="return confirm('本当に削除しますか？')" name="delete">削除</a> <!--- 削除ボタンクリック時にポップアップ表示 --->
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                    </table>
                </div>
            </form>
        </div>
    <div>
</body>

