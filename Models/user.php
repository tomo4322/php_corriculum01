<?php


class User //データを登録
{
    public function index()
    {
        $fullname   = $_POST['fullname'];
        $kana       = $_POST['furigana'];
        $tel        = $_POST['tellNumber'];
        $email      = $_POST['email'];
        $body       = $_POST['message'];
        try {
            require_once(ROOT_PATH .'Models/Db.php');
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->beginTransaction();
            $sql = "INSERT INTO contacts (fullname, kana, tel, email, body) VALUES (:fullname, :furigana, :tellNumber, :email, :message)";
            $stmt = $dbh->prepare($sql);
            $params = array(':fullname' => $fullname, 'furigana' => $kana, 'tellNumber' => $tel, 'email' => $email, 'message' => $body);
            $stmt->execute($params);
            $dbh->commit();
        } catch (PDOException $e) {
            echo "接続失敗: " . $e->getMessage() . "\n";
            exit();
        }
    }
}


class DbData //データを取得
{
    public $contactsData;

    public function getData()
    {
        try {
            require_once(ROOT_PATH .'Models/Db.php');
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->beginTransaction();
            $stmt = $dbh->prepare('SELECT * FROM contacts');
            $stmt->execute();
            $dbh->commit();
            $contactsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->contactsData = $contactsData;
            return $contactsData;
        } catch (PDOException $e) {
            echo "接続失敗: " . $e->getMessage() . "\n";
            exit();
        } finally {
            $dbh = null;
        }
    }
}


class TableData //クリックされた箇所のデータを取得
{
    public $dbCulum;

    public function getTableData()
    {
        $id = $_GET['id'];

        try {
            require_once(ROOT_PATH .'Models/Db.php');
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->beginTransaction();
            $stmt = $dbh->prepare('SELECT * FROM contacts WHERE id = :id');
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $dbh->commit();
            $dbCulum = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->dbCulum = $dbCulum;
            return $dbCulum;
        } catch (PDOException $e) {
            echo "接続失敗: " . $e->getMessage() . "\n";
            exit();
        } finally {
            $dbh = null;
        }
    }
}

 
class Update //データを更新
{
    public function tableUpdate()
    {   $id         = $_POST['id'];
        $fullname   = $_POST['fullname'];
        $kana       = $_POST['furigana'];
        $tel        = $_POST['tellNumber'];
        $email      = $_POST['email'];
        $body       = $_POST['message'];
        try {
            require_once(ROOT_PATH .'Models/Db.php');
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->beginTransaction();
            $stmt = $dbh->prepare("UPDATE contacts SET fullname=:fullname, kana=:kana, tel=:tel, email=:email, body=:body WHERE id=:id ");
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":fullname", $fullname);
            $stmt->bindParam(":kana", $kana);
            $stmt->bindParam(":tel", $tel);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":body", $body);
            $stmt->execute();
            $dbh->commit();
        } catch (PDOException $e) {
            echo "接続失敗: " . $e->getMessage() . "\n";
            error_log($e->getMessage());
            exit();
        }
    }
}



class Delete //データを削除
{
    public function deleteTable()
    {
        $id = $_GET['delete_id'];
        try {
            require_once(ROOT_PATH .'Models/Db.php');
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->beginTransaction();
            $stmt = $dbh->prepare("DELETE FROM contacts WHERE id=:id ");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $dbh->commit();
        } catch (PDOException $e) {
            echo "接続失敗: " . $e->getMessage() . "\n";
            error_log($e->getMessage());
            exit();
        }
    }
}
