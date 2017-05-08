<?php
  session_start();

  //ここでＤＢサーバーに接続する
$db['host'] = "ＤＢサーバーのアドレス";  // DBサーバのURL
$db['dbname'] = "PBL1";  // データベース名

// エラーメッセージの初期化
$errorMessage = "";

//ログインボタンが押された場合
  if(isset($_POST["Login"])){
    //下の入力チェックはbootstrapの機能でできるため不要の可能性あり
 /*   //1.IDとパスワードの入力チェック
    if(empty($_POST["id"])){    //idの値が空のとき
      $errorMessage = 'IDが未入力です。';
    }else if (empty($_POST["Password"])){   //パスワードの値が未入力のとき
      $errorMessage = 'パスワードが未入力です。';
    } */

    //IDとパスワードが入力されている場合IDを格納する
    if(!empty($_POST["id"]) && !empty($_POST["`Password"])){
      //ここでIDをuseridに格納
      $userid =$_POST["id"];

      // 2. ユーザIDとパスワードが入力されていたら認証する
        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

      //3.エラー処理
      try{
      $pdo = new PDO($dsn, $db['userid'], $db['password'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
            //入力したIDでデータベースのuserテーブルのuseridを検索
            $stmt = $pdo->prepare('SELECT * FROM User WHERE userid = ?');
            $stmt->execute(array($userid));
            //入力したパスワードを格納
            $password = $_POST["Password"];

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($password, $row['password'])) {
                    session_regenerate_id(true);

                    // 入力したIDのユーザー名を取得
                    $id = $row['id'];
                    $sql = "SELECT * FROM User WHERE userid = $id";  //入力したIDからユーザー名を取得
                    $stmt = $pdo->query($sql);
                    foreach ($stmt as $row) {
                        $row['name'];  // ユーザー名
                    }
                    $_SESSION["NAME"] = $row['name'];
                    //idとパスワードが同じ場合パスワード変更画面に移動
                    if(strcmp($id, $passwrd) === 0){
                      header("Location: ここにパスワード変更画面のURL");
                    }else{
                    header("Location: ここにログイン後の画面のURL");  // メイン画面へ遷移
                  }
                    exit();  // 処理終了
                } else {
                    // 認証失敗
                    $errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
                }
            } else {
                // 4. 認証成功なら、セッションIDを新規に発行する
                // 該当データなし
                $errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
            }
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            //$errorMessage = $sql;
            // $e->getMessage() でエラー内容を参照可能（デバック時のみ表示）
            // echo $e->getMessage();

            }
  
    }
  }
 // 6行目 DBサーバーの接続先
//49行目　ログイン後の画面のURL
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>出席管理システムログイン</title>
    <!-- BootstrapのCSS読み込み -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/roguin.css" rel="stylesheet">
    <!-- jQuery読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- BootstrapのJS読み込み -->
    <script src="js/bootstrap.min.js"></script>
  </head>
  <body>
  <div class = "container">
  <div class="wrapper">
    <form action="" method="post" name="Login_Form" class="form-signin">       
        <h3 class="form-signin-heading">IDとパスワードを入力してください</h3>
        <hr class="colorgraph"><br>

        ID<br>
        <input type="text" class="form-control" name="loginId" required="" autofocus="" /><br>
        パスワード<br>
        <input type="password" class="form-control" name="Password" required=""/> 

        <button class="btn btn-lg btn-primary btn-block"  name="Login"　id="Login" value="Login" type="Submit">ログイン</button>        
    </form>     
  </div>
</div>
  </body>
</html>



