<?php
  session_start();

  //ここでＤＢサーバーに接続する
$db['host'] = "localhost";  // DBサーバのURL
$db['dbname'] = "admin";  // データベース名
$db['user'] = "admin";
$db['pass'] = "admin";
// エラーメッセージの初期化
$errorMessage = "";

//ログインボタンが押された場合

    //下の入力チェックはbootstrapの機能でできるため不要の可能性あり
 /*   //1.IDとパスワードの入力チェック
    if(empty($_POST["id"])){    //idの値が空のとき
      $errorMessage = 'IDが未入力です。';
    }else if (empty($_POST["Password"])){   //パスワードの値が未入力のとき
      $errorMessage = 'パスワードが未入力です。';
    } */

      // 2. ユーザIDとパスワードが入力されていたら認証する
        $dsn ='mysql:host=localhost;dbname=admin;charset=utf8';

      //3.エラー処理
      try{
      //$pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
      $pdo = new PDO($dsn, $db['user'], $db['pass']);

                    // 入力したIDのユーザー名を取得
                    $id = $_POST['loginId'];
                    $pass = $_POST['Password'];
                    $sql = "SELECT * FROM user WHERE userid = ? and password = ?";  //入力したIDからユーザー名を取得
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$id, $pass]);
                    $result = $stmt->fetch();
                    if(empty($result['id'])){
                      $_SESSION['error'] = 200;
                      header('location: error.php');
                      exit;
                    }else{
                      $userdata = ['id'=>$result['id'], 'name'=>$result['name'], 'role'=>$result['role']];
                      $_SESSION['userdata'] = $userdata;
                        if($result['rank'] == 4){
                          header('location: student.php');
                          exit;
                        }else{
                          header('location: teacher.php');
                          exit;
                        }
                    }
                  }catch(Exception $e){
                    echo 'Error:'. $e->getMessage();
                    die();
                  }  
?>