<?php
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

  # 「TOPへ」ボタンが押されたら
  if (isset($_POST['Back'])) {
      # TOPへ戻る
      header('location: teacher.php' );
      exit;


  # 変更　ボタンが押されたとき
  } else if (isset($_POST['Submit'])) {
    // DB接続のための変数set
    $dsn = 'mysql: host = localhost;dbname=admin; charset=utf8';
    $user = 'admin';
    $pass = 'admin';
    try{
      // DB接続
      $pdo = new PDO($dsn,$user,$pass);

      // 変更まえの出欠状況保存配列
      $attendance1 = array();
      // 変更まえの出欠状況保存する
      $attendance1 = $_SESSION['attendance1'];

      // 変更あとの出欠状況保存配列
      $attendance2 = array();
      // 変更あとの出欠状況保存する
      $attendance2 = $_POST["atd"];
      // カウント用
      $i = 0;
      // 変更したかどうか
      $foo = True; 
      // 出欠状況　変更　繰返しループ
      foreach ($attendance1 as $key => $value ) {
        // 出欠を比較　変更されているとき
        if ( strcmp($value, $attendance2[$i]) != 0 ) {
          // 1回でも変更しました
          $foo = false;
          try {
            $colums = explode(":", $key, 5);

            // 時間目に合わせて分岐
            switch ($colums[4]) {
              // 1時間目の場合
              case 'attendance1':
                // 変更SQL文
                $stmt = $pdo -> prepare("UPDATE attendance SET attendance1 = ? WHERE userid = ? AND year = ? AND month = ? AND day = ?");
                // 変更後の出欠コード代入
                $stmt-> bindValue(1, $attendance2[$i]);
                // 出席番号　代入
                $stmt-> bindValue(2, $colums[0]);
                // 年　代入
                $stmt-> bindValue(3, $colums[1],PDO::PARAM_INT);
                // 月　代入
                $stmt-> bindValue(4, $colums[2],PDO::PARAM_INT);
                // 日　代入
                $stmt-> bindValue(5, $colums[3],PDO::PARAM_INT);
                $stmt-> execute();
                break;
              case 'attendance2':
                // 変更SQL文
                $stmt = $pdo -> prepare("UPDATE attendance SET attendance2 = ? WHERE userid = ? AND year = ? AND month = ? AND day = ?");
                // 変更後の出欠コード代入
                $stmt-> bindValue(1, $attendance2[$i]);
                // 出席番号　代入
                $stmt-> bindValue(2, $colums[0]);
                // 年　代入
                $stmt-> bindValue(3, $colums[1],PDO::PARAM_INT);
                // 月　代入
                $stmt-> bindValue(4, $colums[2],PDO::PARAM_INT);
                // 日　代入
                $stmt-> bindValue(5, $colums[3],PDO::PARAM_INT);
                $stmt-> execute();
                break;
              case 'attendance3':
                // 変更SQL文
                $stmt = $pdo -> prepare("UPDATE attendance SET attendance3 = ? WHERE userid = ? AND year = ? AND month = ? AND day = ?");
                // 変更後の出欠コード代入
                $stmt-> bindValue(1, $attendance2[$i]);
                // 出席番号　代入
                $stmt-> bindValue(2, $colums[0]);
                // 年　代入
                $stmt-> bindValue(3, $colums[1],PDO::PARAM_INT);
                // 月　代入
                $stmt-> bindValue(4, $colums[2],PDO::PARAM_INT);
                // 日　代入
                $stmt-> bindValue(5, $colums[3],PDO::PARAM_INT);
                $stmt-> execute();
                break;
              // 4時間目の場合
              case 'attendance4':
                // 変更SQL文
                $stmt = $pdo -> prepare("UPDATE attendance SET attendance4 = ? WHERE userid = ? AND year = ? AND month = ? AND day = ?");
                // 変更後の出欠コード代入
                $stmt-> bindValue(1, $attendance2[$i]);
                // 出席番号　代入
                $stmt-> bindValue(2, $colums[0]);
                // 年　代入
                $stmt-> bindValue(3, $colums[1],PDO::PARAM_INT);
                // 月　代入
                $stmt-> bindValue(4, $colums[2],PDO::PARAM_INT);
                // 日　代入
                $stmt-> bindValue(5, $colums[3],PDO::PARAM_INT);
                $stmt-> execute();
                break;
              // 5時間目の場合
              case 'attendance5':
                // 変更SQL文
                $stmt = $pdo -> prepare("UPDATE attendance SET attendance5 = ? WHERE userid = ? AND year = ? AND month = ? AND day = ?");
                // 変更後の出欠コード代入
                $stmt-> bindValue(1, $attendance2[$i]);
                // 出席番号　代入
                $stmt-> bindValue(2, $colums[0]);
                // 年　代入
                $stmt-> bindValue(3, $colums[1],PDO::PARAM_INT);
                // 月　代入
                $stmt-> bindValue(4, $colums[2],PDO::PARAM_INT);
                // 日　代入
                $stmt-> bindValue(5, $colums[3],PDO::PARAM_INT);
                $stmt-> execute();
                break;
            }
          } catch(Exception $e) {
            // 失敗文
            $_SESSION['attendance_text'] = "変更できませんでした";  
            exit;
          } 
        }
        $i++;
      }
      // 1回でも変更しました
      if ($foo == false) {
        // 成功文
        $_SESSION['attendance_text'] = "変更しました";
      // 1回も変更しませんでした。
      } else {
        // 成功文
        $_SESSION['attendance_text'] = "変更がありませんでした";

      }
      # 確認フォームへ
      header('location: attendanceChangeForm.php' );

    }catch(Exception $e){
    // 失敗文
    $_SESSION['attendance_text'] = "DBに接続できませんでした";
    }
  }
?>