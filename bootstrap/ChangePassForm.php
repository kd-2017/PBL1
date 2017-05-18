<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>パスワード変更</title>
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
        <form action="ChangePass.php" method="post" name="Login_Form" class="form-signin">       
          <h3 class="form-signin-heading">
<?php
    # セッション開始
    session_start();
    # エラーがある時だけ実行
    if ( isset($_SESSION['error']) ) {
      # エラー表示
      echo $_SESSION['error'];
      # セッション削除
      unset($_SESSION['error']);
    }
?>
          </h3>
          <hr class="colorgraph"><br>

          <!-- 今のパスワード入力 -->
          <input type="password" class="form-control" name="Password" placeholder="現在のパスワードを入力" required="" autofocus="" style="width: 100%" /> 
          <!-- 新しいパスワード入力 -->        
          <input type="password" class="form-control" name="NewPassword" placeholder="新しいパスワードを入力（半角英数記号で6字以上10字以内）" required="" style="width: 100%"/> 
          <!-- 新しいパスワード入力（確認） -->
          <input type="password" class="form-control" name="ReNewPassword" placeholder="確認のため再度パスワードを入力" required="" style="width: 100%"/> 
          <center>
                <!-- 変更ボタン -->
                <button class="btn btn-lg btn-primary btn-block" name="Submit" value="Change" type="Submit">変更</button>
          </center>
        </form>
        <?php
        //一つ前のページに戻る
        $uri = $_SERVER['HTTP_REFERER']; 
        echo '<br><br><a href='.$uri.'><center><button class="btn btn-lg btn-primary btn-block" value="Back"　type="button" style="width:40%">戻る</button></center></a>';
         ?>   
      </div>
    </div>
  </body>
</html>