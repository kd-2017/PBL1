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
    <title>バックアップ</title>
    <!-- BootstrapのCSS読み込み -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">
    <link href="css/roguin.css" rel="stylesheet">
    <!-- jQuery読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/User1.js"></script>
    <script>
      $(function(){
        // ユーザー登録画面にてファイルアップロードする
        $('#fileUpload').change(function() {
          $('#FileUpTextBox').val($(this).val());
        });
      })
    </script>

    <!-- BootstrapのJS読み込み -->
    <script src="js/bootstrap.min.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">メニュー</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="teacher.php">メニュー</a>
        </div>

        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
          <li><a href="ChangePassForm.php">パスワード変更</a></li>
          <li><a href="schoolchange.html">登校日の設定</a></li>
          <li><a href="attendanceChangeForm.php">出欠状況の変更</a></li>
          <li><a href="User1Form.php">新年度登録</a></li>
          <li><a href="backupForm.php">バックアップ</a></li>
          <li><a href="logout.php">ログアウト</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab1" data-toggle="tab">バックアップ</a></li>
      <li><a href="#tab2" data-toggle="tab">復元</a></li>
    </ul>

    <div class = "container">
      <div class="wrapper">
        <form action="backup.php" method="post" name="Login_Form" class="form-signin" enctype="multipart/form-data" novalidate>
          <div class="tab-content">
            <!-- バックアップフォーム @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
            <div class="tab-pane active" id="tab1">
              <h3 class="form-signin-heading">
                バックアップしますか？
              </h3>
              <hr class="colorgraph"><br>
              <center>
                <!-- 登録ボタン -->
                <button class="btn btn-lg btn-primary btn-block" id="backup" name="backup" value="backup" type="Submit" style="width: 20%">実行</button>
              </center>
            </div>

            <!-- 復元フォーム @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
            <div class="tab-pane" id="tab2">
              <h3 class="form-signin-heading">
                復元しますか？
              </h3>
              <hr class="colorgraph"><br>
              <!-- ファイル選択(非表示)（見栄えのため） -->
              <input type="file" accept=".sql" id="fileUpload" name="SqlFile" style="display: none;" />   
              <center>
                <!-- ファイル名表示テキストボックス -->
                <div class="input-group">
                  <input type="text" id="FileUpTextBox" class="form-control" placeholder="ファイルを選択してください" required="" autofocus="" style="width: 90%">
                  <!-- ファイル選択ボタン -->
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-default" onclick="$('#fileUpload').click();">参照</button>
                  </span>
                </div>
                <br>
                <!-- 登録ボタン -->
                <button class="btn btn-lg btn-primary btn-block" id="restore" name="restore" value="restore" type="Submit" style="width: 20%">実行</button>
              </center>
            </div>
          </div>
        </form>
      </div>  
    </div>  
  </body>
</html>