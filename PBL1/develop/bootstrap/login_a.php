<?php
  session_start();
  //ここでＤＢサーバーに接続する
$db['host'] = "ＤＢサーバーのアドレス";  // DBサーバのURL
$db['dbname'] = "PBL1";  // データベース名
  if(isset($_POST["Login"])){
  if(empty($_REQUEST['loginId']) || empty($_REQUEST['loginPass'])){
    $_SESSION['error'] = 100;
    header('location:error.php');
    exit;
  }
  $uid = $_REQUEST['loginId'];
  $password = $_REQUEST['loginPass'];
  //echo 'uid;' . $uid. ' ,pass;' .$password; 

  $dsn = 'mysql:host=localhost;dbname=login;charset=utf8';
  $pod_user = 'denshi';
  $pod_password = 'kobe';
  try{
      $pdo = new PDO($dsn, $pod_user, $pod_password);
      $sql = 'select * from user where uid = ? and password = ?';
      $stmt = $pdo->prepare($sql);
      $result = $stmt->fetch();
      if(empty($result['uid'])){
      $_SESSION['error'] = 200;
      header('localtion: error.php');
      exit;
      }else{
        $userdata = ['uid' =>$result['uid'], 'name' => $result['name'], 'role' =>$result['role']];
        $_SESSION['userdata'] = $userdata;
          if($result['role']==1){
            header('location: student.php');
            exit;
          }else{
            header('location:teacher.php');
            exit;
          }
      }
  }catch(Exception $e){
    echo 'Error:' . $e->getMessage();
    die();
  }
}
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



