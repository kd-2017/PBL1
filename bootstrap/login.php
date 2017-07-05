<?php
  session_start();
  if(empty($_REQUEST['loginId']) || empty($_REQUEST['Password'])){
    $_SESSION['error'] = 100;
    header('location: error.php');
    exit;
  }
$userid = $_REQUEST['loginId'];
$password = $_REQUEST['Password'];
//echo 'userid:' .userid . ', pass:' . $password;

#DBの接続のための設定
$dsn = 'mysql: host = localhost;dbname=admin; charset=utf8';
$user = 'admin';
$pass = 'admin';

try{
    #入力したIDとパスワードをチェック
    $pdo = new PDO($dsn, $user, $pass);
    $sql = 'select * from user where userid = ? and password = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userid, $password]);
    $result = $stmt->fetch();
    if(empty($result['userid'])){
      $_SESSION['error'] = 200;
      header('location: error.php');
      exit;
    }else{
      #セッションにユーザーデータを保存
      $userdata = ['userid'=>$result['userid'], 'name'=>$result['name'], 'admin'=>$result['admin']];
      $uid = $result['userid'];
      $_SESSION['uid'] = $uid;
      $_SESSION['userid'] = $userdata;
      #ログインした日付を保存
      date_default_timezone_set('Asia/Tokyo');
      $_SESSION['nowdate'] = strtotime('+0 day');
      $_SESSION['weekcount'] = 0;
      $_SESSION['monthcount'] = 0;
    //  $_SESSSION['id'] = $result['userid'];
      #パスワードが初期値ならパスワード変更画面に遷移
          if(strstr($_REQUEST['loginId'], $_REQUEST['Password'])){
            # セッション削除
        $_SESSION['error'] = 'パスワードが初期値なのでパスワードを変更してください。';
          header('location:ChangePassForm.php');
          exit;
        }else{
          #IDが「teacher」の場合、教員用画面に遷移
      if($result['admin'] == 0){
        header('location: student.php');
        exit;
      }else{
        #IDが学生の場合、学生用画面に遷移
        header('location:teacher.php');
      }exit;
    }
  }
}catch(Exception $e){
    echo 'Error:' . $e->getMessage();
}
?>