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

  #DBの接続のための設定
  $dbname = 'admin';
  $host = 'localhost';
  $user = 'admin';
  $pass = 'admin';

  # 「バックアップ」ボタンが押されたら
  if (isset($_POST['backup'])) {
    # ファイル名設定（日付時間.sql）
    $fileName = date('ymd').'_'.(date('H')+7).'h'.date('i').'m'.'.sql';
    # コマンド
    $command = "c:\\xampp\mysql\bin\mysqldump ".$dbname." --host=".$host." --user=".$user." --password=".$pass." > ".$fileName;
    # コマンド実行
    system($command);
    # ダウンロード 
    header('Content-Type: application/force-download');   //ダウンロードの指示
    header('Content-Disposition: attachment; filename="'.$fileName.'"');    //ダウンロードするファイル名
    header('Content-Length: ' . filesize($fileName));
    readfile($fileName);

    #利用者がダウンロードするので、サーバーに作成されたファイルは不要。ということで削除
    unlink($fileName);

  # 「復元」ボタンが押されたら
  } else if (isset($_POST['restore'])) {
    #送られてきたファイルを取得
    $fileName = $_FILES['SqlFile']['tmp_name'];
    # コマンド
    $command = "c:\\xampp\mysql\bin\mysql --default-character-set=utf8 --host=".$host." --user=".$user." --password=".$pass." ".$dbname." < ".$fileName;
    # コマンド実行
    system($command);
  }

  # バックアップフォームに戻る
  header('location: teacher.php');
?>
