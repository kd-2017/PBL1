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

$dsn = 'mysql: host = localhost;dbname=admin; charset=utf8';
$user = 'admin';
$pass = 'admin';
try{
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
      $userdata = ['userid'=>$result['userid'], 'name'=>$result['name'], 'admin'=>$result['admin']];
      $_SESSION['userid'] = $userdata;
      if($result['admin'] == 0){
        header('location: student.php');
        exit;
      }else{
        header('location:teacher.php');
      }exit;
    }
}catch(Exception $e){
    echo 'Error:' . $e->getMessage();
}
?>