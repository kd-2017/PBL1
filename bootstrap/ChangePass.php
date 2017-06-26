<?php
  # セッション開始
  session_start();
  # 変更ボタンが押されたら
  if (isset($_POST['Submit'])) {
    # 新しいパスワード
    $NewPass = $_POST['NewPassword'];
    # 新しいパスワード（確認）
    $ReNewPass = $_POST['ReNewPassword'];
    # 入力された新しいパスワードの文字数カウント
    $len = mb_strlen($NewPass, "UTF-8");
    # 文字数が6文字以上10文字以内のとき
    if ((6 <= $len) && ($len <= 10)) {    
      # 文字数カウント（正し、半角は１カウント、全角は2カウント）
      $wdt = mb_strwidth($NewPass, "UTF-8");
      # 全角が含まれていない
      if($len == $wdt) {
        # 新しいパスワードと新しいパスワード（確認）が一致したとき
        if (strstr($NewPass, $ReNewPass)) {
          # データベース接続
          try {
            # データベース設定
            $dsn = 'mysql:host=localhost;dbname=admin;charset=utf8';
            $user = 'admin';
            $password = 'admin';
            # データベース接続
            $pdo = new PDO($dsn, $user, $password);
            #ユーザーID取得
            $userid = $_SESSION['uid'];      
            # そのユーザーのパスワードと「教員、生徒判定フラグ」を取得 
            $stmt = $pdo -> prepare("SELECT password, admin FROM User WHERE userid = ?");
            $stmt -> bindValue(1, $userid);
            $stmt -> execute();
            if ($rows = $stmt -> fetch()) {
              $pass = $rows["password"];
              $admin = $rows["admin"];
            }
            # パスワードが一致したなら
            if (strcmp($_POST['Password'], $pass) == 0 ) {
              # パスワード変更
              $stmt = $pdo -> prepare("UPDATE user SET password = ? WHERE userid = ?");
              $stmt-> bindValue(1, $NewPass);
              $stmt-> bindValue(2, $userid);
              $stmt-> execute();
              $_SESSION['error1'] = 'パスワードを変更しました';
              # 教員なら
              if ($admin == 1) {
                # 教員ホーム画面に戻る
                header('location: teacher.php');
              } else {
                # 生徒ホーム画面に戻る
                header('location: student.php');
              }
              exit;
            #パスワードが違うとき
            } else {
              $error1 = "パスワードが違います";
              # セッションにエラー文格納
              $_SESSION['error1'] = $error1;
              # 入力フォームに戻る
              header('location: ChangePassForm.php');
              exit;
            }
          # データベース接続失敗  
          } catch (PDOException $e) {
            $error1 = 'データベース接続失敗。'.$e->getMessage();
          # セッションにエラー文格納
          $_SESSION['error1'] = $error1;
            # 入力フォームに戻る
            header('location: ChangePassForm.php');
            exit;
          }
        # 新しいパスワードと新しいパスワード（確認）が一致しなかったとき
        } else {
          $error1 = "新しいパスワードと新しいパスワード（確認）が一致しません";
          # セッションにエラー文格納
          $_SESSION['error1'] = $error1;
          # 入力フォームに戻る
          header('location: ChangePassForm.php');
          exit;
        }
      # 全角が含まれている時
      } else {
        $error1 = "半角で入力して下さい";
        # セッションにエラー文格納
        $_SESSION['error1'] = $error1;
        # 入力フォームに戻る
        header('location: ChangePassForm.php');
        exit;
      }
    # 文字数6文字未満、１1字以上の時
    } else {
      $error1 = "6文字以上10字以内で入力してください";
      # セッションにエラー文格納
      $_SESSION['error1'] = $error1;
      # 入力フォームに戻る
      header('location: ChangePassForm.php');
      exit;
    }
  }
?>