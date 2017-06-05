<?php
  # セッション開始
  session_start();
  # 「登録」ボタンが押されたら
  if (isset($_POST['Submit'])) {
    
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

    # 入力されたcsvファイル取得
    $file = new SplFileObject($_FILES["UserCsv"]["tmp_name"]);
    # 読み込み
    $file->setFlags(SplFileObject::READ_CSV);
 // ファイル内のデータループ
    foreach ($file as $key => $line) { 
      foreach( $line as $str ){
        # エンコーディング
        $work = mb_convert_encoding($str, 'UTF-8', 'sjis-win');
        $records[$key][] = $work;
      }
    }
    # ↑　$recordsに、二次元配列でユーザーのデータが格納されました
          
    # データベース接続
    try {
      # データベース設定
      $dsn = 'mysql:host=localhost;dbname=admin;charset=utf8';
      $user = 'admin';
      $password = 'admin';
      # データベース接続
      $pdo = new PDO($dsn, $user, $password);

      # userテーブルを初期化
      $stmt = $pdo->query("TRUNCATE TABLE user");
      # sql確定
      $stmt-> execute();

      #ユーザー数カウント
      $user_cnt = (count($records)-1);
      # 最後のユーザーまで
      for ( $i = 1 ; $i <= $user_cnt ; $i++ ) {
        # 新userデータを挿入ＳＱＬ
        $stmt = $pdo -> prepare("INSERT INTO user (userid, name, password, rank, class, address, admin) VALUES (?,?,?,?,?,?,?)");

        #カラム数カウント
        $column_cnt = count($records[$i]);
        # そのユーザーの最後のカラムまで
        for ($j = 0 ; $j < $column_cnt ; $j++ ) {
          # 配列内のデータをSQL文の？にいれていく
          $stmt-> bindValue(($j+1), $records[$i][$j]);
        }
        # sql確定
        $stmt-> execute();
      }

      # 次ページで表示する文をセッションに入れる
      $_SESSION['user_text'] = "登録しました";
    
    # データベース接続失敗  
    } catch (PDOException $e) {
      # 次ページで表示する文をセッションに入れる
      $_SESSION['user_text'] = "登録できませんでした";            
    }

    #「読み込み完了しました」ページへ
    header('location: User2Form.php');
  } 
?>
