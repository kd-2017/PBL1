<?php
  # セッション開始
  session_start();
  # 教員、生徒判定フラグ取得
  $admin = $_SESSION['userid']['admin'];
  # 生徒なら
  if ($admin == 0) {
    #セッション削除
    session_destroy();
    # 強制ログアウト&ログイン画面に戻る
    header('location: login.html');
    exit;
  }

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ユーザー登録完了</title>
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
        <form action="User2.php" method="post" name="Login_Form" class="form-signin">       
          <h2 class="form-signin-heading">
<?php
  echo $_SESSION['user_text'];
?>
          </h2>
          <hr class="colorgraph"><br> 
          <center>
              <!-- 登録ボタン -->
              <button class="btn btn-lg btn-primary btn-block" name="Submit" value="Top" type="Submit" style="width: 20%">TOPへ</button>
          </center>
        </form>
      </div>
    </div>
  </body>
</html>