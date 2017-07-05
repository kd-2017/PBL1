<?php
  session_start();
  #日付取得
  date_default_timezone_set('Asia/Tokyo');
  $week_name = array("日", "月", "火", "水", "木", "金", "土");
  #学生用アカウントはアクセス不可、ログイン画面に遷移する
  if($_SESSION['userid']['admin'] == '1' || empty($_SESSION['userid'] )){
  header('location:login.html');
  exit;
  }
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>出欠状況確認画面</title>
    <!-- BootstrapのCSS読み込み -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Baloo" rel="stylesheet">
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
          <a class="navbar-brand" href="student.php">メニュー</a>
        </div>
        <div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="confirmation.php">出欠状況確認</a></li> 
            <li><a href="ChangePassForm.php">パスワード変更</a></li>
            <li><a href="logout.php">ログアウト</a></li>
          </ul>
        </div>
        </div>
      </nav>

  <h1>出席状況確認画面</h1>
    <center>
    <table class="table table-responsive" border="1" style="width:70%">
    <tr>
    <td class="text-center">0</td><td class="text-center">出席</td><td class="text-center" bgcolor =#ffff00>1</td><td class="text-center">遅刻</td>
    </tr>
    <tr>
    <td class="text-center" bgcolor =#ff0000>2</td><td class="text-center">欠課</td><td class="text-center" bgcolor =#00ffff >3</td><td class="text-center">就活</td>
    </tr>
    <tr>
    <td class="text-center" bgcolor =#00ff00>4</td><td class="text-center">病欠</td><td class="text-center" bgcolor =#1c90eb>5</td><td class="text-center">公欠</td>
    </tr>
    </table>
    </center>
    <br>

      <center>日付変更<br>

    <form action="daychange.php" method="post"> 
      <input type="date" name="daychange" required
   />
      &nbsp;&nbsp;<input type="submit" value="変更">
    </form>
    <br><br>

      <table class="table table-responsive" border="1">
  <thead>
    <tr>
      <th colspan="5" class="text-center">

      <?php
      
      echo date("n月j日",$_SESSION['nowdate']);
      echo "(".$week_name[date("w", $_SESSION['nowdate'])].")";
      
      ?>


      </th>
    </tr>
  </thead>
  <tbody>
    <?php

 $dsn = 'mysql: host = localhost;dbname=admin; charset=utf8';
  $user = 'admin';
  $pass = 'admin';

  try{
  $pdo = new PDO($dsn,$user,$pass);

  #学生の出席情報表示
  $stmt = $pdo->prepare("SELECT * FROM attendance WHERE year = ? and month = ? and day= ? and userid = ? ");

  $stmt -> bindValue(1,date("Y",$_SESSION['nowdate']));
  $stmt -> bindValue(2,date("n",$_SESSION['nowdate']));
  $stmt -> bindValue(3,date("d",$_SESSION['nowdate']));
 
       

	$stmt -> bindValue(4,$_SESSION['userid']['userid']);
    $stmt->execute();
  $result = $stmt->fetch();
  if(empty($result['userid'])){
      #DBに出欠状況がない場合は何もしない
    }else{
  $userday = ['userid'=>$result['userid'], 'attendance1'=>$result['attendance1'], 'attendance2'=>$result['attendance2'], 'attendance3' => $result['attendance3'], 'attendance4' => $result['attendance4'], 'attendance5' => $result['attendance5']];
    #出欠状況を表示
    #1限
      #出席は白
      if($userday['attendance1'] == 0){
        echo "<td><div class='text-center'>".$userday['attendance1']."</div></td>";
        #遅刻は黄色
      }elseif($userday['attendance1'] == 1){
        echo "<td bgcolor =#ffff00><div class='text-center'>".$userday['attendance1']."</div></td>";
        #欠課は赤
      }elseif($userday['attendance1'] == 2) {
        echo "<td bgcolor =#ff0000><div class='text-center'>".$userday['attendance1']."</div></td>";
        #就活は水色
      }elseif($userday['attendance1'] == 3) {
        echo "<td bgcolor =#00ffff><div class='text-center'>".$userday['attendance1']."</div></td>";
        #病欠は緑
      }elseif($userday['attendance1'] == 4) {
        echo "<td bgcolor =#00ff00><div class='text-center'>".$userday['attendance1']."</div></td>";
        #公欠は青
      }elseif($userday['attendance1'] == 5) {
        echo "<td bgcolor =#1c90eb><div class='text-center'>".$userday['attendance1']."</div></td>";
      }elseif($userday['attendance1'] == 9) {
        echo "<td></div></td>";
      }
      #2限
      if($userday['attendance2'] == 0){
        echo "<td><div class='text-center'>".$userday['attendance2']."</div></td>";
      }elseif($userday['attendance2'] == 1){
        echo "<td bgcolor =#ffff00><div class='text-center'>".$userday['attendance2']."</div></td>";
      }elseif($userday['attendance2'] == 2) {
        echo "<td bgcolor =#ff0000><div class='text-center'>".$userday['attendance2']."</div></td>";
      }elseif($userday['attendance2'] == 3) {
        echo "<td bgcolor =#00ffff><div class='text-center'>".$userday['attendance2']."</div></td>";
      }elseif($userday['attendance2'] == 4) {
        echo "<td bgcolor =#00ff00><div class='text-center'>".$userday['attendance2']."</div></td>";
      }elseif($userday['attendance2'] == 5) {
        echo "<td bgcolor =#1c90eb><div class='text-center'>".$userday['attendance2']."</div></td>";
      }elseif($userday['attendance1'] == 9) {
        echo "<td></div></td>";
      }
      #3限
            if($userday['attendance3'] == 0){
        echo "<td><div class='text-center'>".$userday['attendance3']."</div></td>";
      }elseif($userday['attendance3'] == 1){
        echo "<td bgcolor =#ffff00><div class='text-center'>".$userday['attendance3']."</div></td>";
      }elseif($userday['attendance3'] == 2) {
        echo "<td bgcolor =#ff0000><div class='text-center'>".$userday['attendance3']."</div></td>";
      }elseif($userday['attendance3'] == 3) {
        echo "<td bgcolor =#00ffff><div class='text-center'>".$userday['attendance3']."</div></td>";
      }elseif($userday['attendance3'] == 4) {
        echo "<td bgcolor =#00ff00><div class='text-center'>".$userday['attendance3']."</div></td>";
      }elseif($userday['attendance3'] == 5) {
        echo "<td bgcolor =#1c90eb><div class='text-center'>".$userday['attendance3']."</div></td>";
      }elseif($userday['attendance1'] == 9) {
        echo "<td></div></td>";
      }
      #4限
            if($userday['attendance4'] == 0){
        echo "<td><div class='text-center'>".$userday['attendance4']."</div></td>";
      }elseif($userday['attendance4'] == 1){
        echo "<td bgcolor =#ffff00><div class='text-center'>".$userday['attendance4']."</div></td>";
      }elseif($userday['attendance4'] == 2) {
        echo "<td bgcolor =#ff0000><div class='text-center'>".$userday['attendance4']."</div></td>";
      }elseif($userday['attendance4'] == 3) {
        echo "<td bgcolor =#00ffff><div class='text-center'>".$userday['attendance4']."</div></td>";
      }elseif($userday['attendance4'] == 4) {
        echo "<td bgcolor =#00ff00><div class='text-center'>".$userday['attendance4']."</div></td>";
      }elseif($userday['attendance4'] == 5) {
        echo "<td bgcolor =#1c90eb><div class='text-center'>".$userday['attendance4']."</div></td>";
      }elseif($userday['attendance1'] == 9) {
        echo "<td></div></td>";
      }
      #5限
        if($userday['attendance5'] == 0){
        echo "<td><div class='text-center'>".$userday['attendance5']."</div></td>";
      }elseif($userday['attendance5'] == 1){
        echo "<td bgcolor =#ffff00><div class='text-center'>".$userday['attendance5']."</div></td>";
      }elseif($userday['attendance5'] == 2) {
        echo "<td bgcolor =#ff0000><div class='text-center'>".$userday['attendance5']."</div></td>";
      }elseif($userday['attendance5'] == 3) {
        echo "<td bgcolor =#00ffff><div class='text-center'>".$userday['attendance5']."</div></td>";
      }elseif($userday['attendance5'] == 4) {
        echo "<td bgcolor =#00ff00><div class='text-center'>".$userday['attendance5']."</div></td>";
      }elseif($userday['attendance5'] == 5) {
        echo "<td bgcolor =#1c90eb><div class='text-center'>".$userday['attendance5']."</div></td>";
      }elseif($userday['attendance1'] == 9) {
        echo "<td></div></td>";
      }

  }

  echo"</tr>";

}catch(Exception $e){
    echo 'Error:' . $e->getMessage();
}

      ?>
    </tr>
    </tbody>
    </table>   
<br><br><br>
  <?php  
  if(empty($_POST["return"])){
    $_SESSION['nowdate'] = strtotime('+0 day');
  }
      ?>
  <form action="student.php" method="post">
    <input type="submit" class="btn btn-lg btn-primary btn-block" style="width:40%" name="return" value="トップページに戻る" />
  </form>
    </center>




</body>
</html>