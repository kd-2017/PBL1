<?php
  # セッション開始
  session_start();
  # 
  # 「Top」ボタンが押されたら
  if (isset($_POST['Submit'])) {
    # 教員、生徒判定フラグ取得
    $admin = $_SESSION['userid']['admin'];
    # 教員なら
    if ($admin == 1) {
      #もう使わないセッション削除
      unset($_SESSION["user_text"]);
      # 教員ホーム画面に戻る
      header('location: teacher.php');
      exit;
    } else {
      #セッション削除
      session_destroy();
      # 強制ログアウト&ログイン画面に戻る
      header('location: login.html');
      exit;
    }
  }
?>
