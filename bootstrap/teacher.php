<?php
  session_start();
  #日付取得
  date_default_timezone_set('Asia/Tokyo');
  $week_name = array("日", "月", "火", "水", "木", "金", "土");
  #学生用アカウントはアクセス不可、ログイン画面に遷移する
  if($_SESSION['userid']['admin'] == '0' || empty($_SESSION['userid']['admin'] )){
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
    <title>教員用トップページ</title>
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
          <a class="navbar-brand" href="#">メニュー</a>
        </div>

        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
          <li><a href="ChangePassForm.php">パスワード変更</a></li>
          <li><a href="schoolchange.html">登校日の設定</a></li>
          <li><a href="#">出欠状況の変更</a></li>
          <li><a href="#">新年度登録</a></li>
          <li><a href="#">バックアップ</a></li>
          <li><a href="logout.php">ログアウト</a></li>
          </ul>
        </div>
        </div>
      </nav>
      <br><br>

        <table border="1" rules="none" style="font-size : 20px;" >
        <th  style="width:10%;padding:20px"><a href="lastmonth.php"><<前の月&nbsp;&nbsp;</a><a href="nextmonth.php">次の月>></a></th>

        <th  style="width:10%;padding:20px"><a href="lastweek.php"><&nbsp;前の週</a></th><th  style="width:10%;padding:20px">
        <?php
        $today = date("n月j日");
        echo "<a href='nowday.php'>".$today. '('.$week_name[date("w")].')</a>';
      ?>
        
      <th  style="width:10%;padding:20px"><a href="nextweek.php">次の週&nbsp;></a></th></table>
      <br>
        </center>
        <table class="table table-responsive" border="1">
    <thead>
      <tr>
        <th><div class="text-center">出席番号</th></div>
        <th><div class="text-center">名前</th></div>
        <th><div class="text-center">出席率</th></div>
        <th colspan="5"><div class="text-center">  
        <!--曜日を基準に1週間を月曜日から表示-->
        <?php
        #月曜日
        if (date("w") == 1) {
        $day[0] = strtotime($_SESSION["weekcount"]."week".$_SESSION["monthcount"]."month");
        echo date("n月j日(月)", $day[0])."</th>".date("w");
        }else{
          $day[0]= strtotime('last Monday',strtotime($_SESSION["weekcount"]."week".$_SESSION["monthcount"]."month"));
          echo date("n月j日(月)", $day[0])."</th>";
        }
        #火曜日
        $day[1] = strtotime('+1 day',$day[0]);
      echo "<th colspan='5'><div class='text-center'>".date("n月j日(火)",$day[1])."</th></div>";
      #水曜日
      $day[2] = strtotime('+2 day',$day[0]);
      echo "<th colspan='5'><div class='text-center'>".date("n月j日(水)",$day[2])."</th></div>";
      #木曜日
      $day[3] = strtotime('+3 day',$day[0]);
      echo "<th colspan='5'><div class='text-center'>".date("n月j日(木)",$day[3])."</th></div>";
      #金曜日
      $day[4] = strtotime('+4 day',$day[0]);
      echo "<th colspan='5'><div class='text-center'>".date("n月j日(金)",$day[4])."</th></div>";
      #土曜日
      $day[5] = strtotime('+5 day',$day[0]);
      echo "<th colspan='5'><div class='text-center'>".date("n月j日(土)",$day[5])."</th></div>";
      #日曜日
      $day[6] = strtotime('+6 day',$day[0]);
      echo "<th colspan='5'><div class='text-center'>".date("n月j日(日)",$day[6])."</th></div>";

        ?>
      </tr>
      <tr>
    </thead>
    <tbody>
            <?php
      #DBの接続のための設定
  $dsn = 'mysql: host = localhost;dbname=admin; charset=utf8';
  $user = 'admin';
  $pass = 'admin';

  try{
  $pdo = new PDO($dsn,$user,$pass);

  #学生の出席情報表示
  $stmt = $pdo->prepare("SELECT * FROM attendance WHERE year = ? and month = ? and day= ? and userid = ? ");
  #学生の名前の表示
  $stmt2 = $pdo->prepare("SELECT name FROM user WHERE userid = ?");

  #学生の人数分のループのための計算
  $stmt3 = $pdo->prepare("SELECT COUNT(userid) AS cnt FROM attendance WHERE year = ? and month = ? and day= ?");
  $stmt3 -> bindValue(1,date("Y",$day[0]));
  $stmt3 -> bindValue(2,date("n",$day[0]));
  $stmt3 -> bindValue(3,date("d",$day[0]));
  $stmt3->execute();
        $result3 = $stmt3->fetch();
      if(empty($result3)){

      }else{
        $count = $result3['cnt'];
      }

  #出席番号ループ
   $number = "0K01000";
   for ($num=1; $num <= $result3['cnt']; $num++) { 
    $ns = str_pad($num,3,0,STR_PAD_LEFT);
    $str = str_replace("000", $ns, $number);
        $stmt2 ->bindValue(1,$str);
        $stmt2->execute();
        $result2 = $stmt2->fetch();
      if(empty($result2)){
        #
      }else{
        $uname =  $result2['name'];
      }
  #sql文の1つ目に年を入れる
  $stmt -> bindValue(1,date("Y",$day[0]));
  #sql文の2つ目に月を入れる
  $stmt -> bindValue(2,date("n",$day[0]));
  #sql文の３つ目に日を入れる
  $stmt -> bindValue(3,date("d",$day[0]));
  #sql文の4つ目にuseridを入れる
  $stmt -> bindValue(4,$str);

  #SQL文実行
  $stmt->execute();
  $result = $stmt->fetch();
  if(empty($result['userid'])){
      #DBに出欠状況がない場合は何もしない
     #echo "<td></td><td></td><td></td>";
    }else{
  $userday[] = ['userid'=>$result['userid'], 'attendance1'=>$result['attendance1'], 'attendance2'=>$result['attendance2'], 'attendance3' => $result['attendance3'], 'attendance4' => $result['attendance4'], 'attendance5' => $result['attendance5']];

      #出席番号を表示
       echo "<td><div class='text-center'>".$result['userid']."</div></td>";
      #名前を表示
        echo "<th scope='row'>".$result2['name']."</th>";
      #出席率を表示
        echo "<td></td>";
  }

    #日付ループ
  for($i = 0 ; $i<7 ; $i++){
  #sql文の1つ目に年を入れる
  $stmt -> bindValue(1,date("Y",$day[$i]));
  #sql文の2つ目に月を入れる
  $stmt -> bindValue(2,date("n",$day[$i]));
  #sql文の３つ目に日を入れる
  $stmt -> bindValue(3,date("d",$day[$i]));

  $stmt -> bindValue(4,$str);

  #SQL文実行
  
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
      }

  }
}
  echo"</tr>";
}
  }catch(Exception $e){
    echo 'Error:' . $e->getMessage();
}
      ?>
    </tbody>
  </table>
  </body>
</html>