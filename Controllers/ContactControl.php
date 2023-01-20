<?php
 require_once(ROOT_PATH .'Models/user.php');

 function Message()
 {
    $_SESSION['fullname']   = $_POST['fullname'];
    $_SESSION['furigana']   = $_POST['furigana'];
    $_SESSION['tellNumber'] = $_POST['tellNumber'];
    $_SESSION['email']      = $_POST['email'];
    $_SESSION['message']    = $_POST['message'];
 }

class Contact
{
    public $errmessage; //入力画面用のエラーメッセージ
    public $errmessageUpdate; //更新画面用のエラーメッセージ
    
    public function check()
    {
        //バリデーション
        $errmessage = array();
        if (isset($_POST['check']) && $_POST['check']) {
            if (!$_POST['fullname']) {
                $errmessage[] = "※名前を入力してください";
            } elseif (mb_strlen($_POST['fullname']) > 10) {
                $errmessage[] = "※名前は10文字以内にしてください";
            }
        
            if (!$_POST['furigana']) {
                $errmessage[] = "※フリガナを入力してください";
            } elseif (mb_strlen($_POST['furigana']) > 10) {
                $errmessage[] = "※フリガナは10文字以内にしてください";
            }
        
            if (!preg_match("/^[0-9]+$/", $_POST['tellNumber'])) {
                $errmessage[] = "※正しい電話番号を入力してください";
            }
        
            if (!$_POST['email']) {
                $errmessage[] = "※メールアドレスを入力してください";
            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errmessage[] = "※正しく入力してください";
            }
        
            if (!$_POST['message']) {
                $errmessage[] = "※お問い合わせを入力してください";
            }

            Message();

            //エラーメッセージ出力し、無ければ確認画面へ
            if (!empty($errmessage)) {
                echo '<h2 class="error">'.implode('<br>', $errmessage).'</h2>';
            } else {
                header('Location: confirm.php', true, 307);
            }
            $this->errmessage = $errmessage;
            return $errmessage;
        }
    }



    public function tableUpdate()
    {
        //バリデーション

        $errmessageUpdate = array();
        
        if (!$_POST['fullname']) {
            $errmessageUpdate[] = "※変更する名前が空でした";
        } elseif (mb_strlen($_POST['fullname']) > 10) {
            $errmessageUpdate[] = "※変更する名前は10文字以内にしてください";
        }
    
        if (!$_POST['furigana']) {
            $errmessageUpdate[] = "※変更するフリガナが空でした";
        } elseif (mb_strlen($_POST['furigana']) > 10) {
            $errmessageUpdate[] = "※変更するフリガナは10文字以内にしてください";
        }
            
        if (!preg_match("/^[0-9]+$/", $_POST['tellNumber'])) {
            $errmessageUpdate[] = "※正しい電話番号を入力してください";
        }

        if (!$_POST['email']) {
            $errmessageUpdate[] = "※変更するメールアドレスが空でした";
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errmessageUpdate[] = "※変更するメールアドレスは正しく入力してください";
        }
    
        if (!$_POST['message']) {
            $errmessageUpdate[] = "※変更するお問い合わせ内容が空でした";
        }
        
        $_SESSION['id']   = htmlspecialchars($_POST['id'], ENT_QUOTES);
        Message();

        $this->errmessageUpdate = $errmessageUpdate;

        //エラーメッセージが無ければデータを更新し入力画面へ遷移
        if (empty($errmessageUpdate)) {
            $tableData = new ConnectDb();
            $tableData->update();
        }
        return $errmessageUpdate;
    }
}


class ConnectDb //データベース
{
    public $contactsData;
    public $dbCulum;

    //登録用
    public function index() {
        $register = new User();
        $register->index();
    }

    //データベースに保存された値を取得
    public function show() {
        $getData = new DbData();
        $getData->getData();
        $this->contactsData = $getData->contactsData;
    }

    //クリックされた箇所のデータを取得
    public function showTableData() {
        $tableData = new TableData();
        $tableData->getTableData();
        $this->dbCulum = $tableData->dbCulum;
    }

    //データ更新
    public function update() {
        $updateDb = new Update();
        $updateDb->tableUpdate();
        header('Location: contact.php', true, 302);
    }

    //データ削除
    public function delete() {
        $tableDataDelete = new Delete();
        $tableDataDelete->deleteTable();
        header('Location: contact.php');
    }
 }
