<?php
  ini_set('display_errors', 0);
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
    <title>出欠状況変更画面</title>
    <!-- BootstrapのCSS読み込み -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/attendanceChange.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">

    <link href="css/navbar.css" rel="stylesheet">

    <!-- jQuery読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- BootstrapのJS読み込み -->
    <script src="js/bootstrap.min.js"></script>
    <!-- 自分で作ったJS読み込み -->
    <script src="js/attendanceChange.js"></script>
  </head>
  <body>
    <form action="attendanceChange.php" method="post" >
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
      


      <h1>出欠状況変更画面</h1> 

      <center>
        <table border="1" rules="none" style="font-size : 20px;" >
          <th  style="width:10%;padding:20px">
            <a href="lastmonthAttendanceChange.php"><<前の月&nbsp;&nbsp;</a>
            <a href="nextmonthAttendanceChange.php">次の月>></a>
          </th>
          <th  style="width:10%;padding:20px">
            <a href="lastweekAttendanceChange.php"><&nbsp;前の週</a>
          </th>
          <th  style="width:10%;padding:20px">
<?php

            $today = date("n月j日");
            echo "<a href='nowdayAttendanceChange.php'>".$today. '('.$week_name[date("w")].')</a>';
?>        
          <th  style="width:10%;padding:20px">
            <a href="nextweekAttendanceChange.php">次の週&nbsp;></a>
          </th>
        </table><br>
      </center>
<?php
  if (isset($_SESSION['attendance_text'])) {
    // DB結果文表示
    echo $_SESSION['attendance_text'];
    // DB結果文削除
    unset($_SESSION['attendance_text']);
  }
?>
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
        echo date("n月j日(月)", $day[0])."</th>";
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
    </thead>
    <tbody id="selectable">
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

  #すべての登校日から授業時間を計算
  $sday = $pdo->query("SELECT * FROM attendance WHERE schooldays = 1 AND userid = '0K01001'");
  $allday = $sday->rowCount();
  #全体の出席時間
  $allday *= 5;

  #出欠カウント
  $at1 = $pdo->prepare("SELECT count(attendance1) as at1 FROM `attendance` WHERE userid = ? AND attendance1 = ?");
  $at2 = $pdo->prepare("SELECT count(attendance2) as at2 FROM `attendance` WHERE userid = ? AND attendance2 = ?");
  $at3 = $pdo->prepare("SELECT count(attendance3) as at3 FROM `attendance` WHERE userid = ? AND attendance3 = ?");
  $at4 = $pdo->prepare("SELECT count(attendance4) as at4 FROM `attendance` WHERE userid = ? AND attendance4 = ?");
  $at5 = $pdo->prepare("SELECT count(attendance5) as at5 FROM `attendance` WHERE userid = ? AND attendance5 = ?");

  $stmt3 -> bindValue(1,date("Y",$day[0]));
  $stmt3 -> bindValue(2,date("n",$day[0]));
  $stmt3 -> bindValue(3,date("d",$day[0]));
  $stmt3->execute();
        $result3 = $stmt3->fetch();
      if(empty($result3)){

      }else{
        $count = $result3['cnt'];
      }
      $session_stack = array();
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

  #遅刻合計
  $a1 = 0;
  #欠課合計
  $a2 = 0;
  #病欠合計
  $a4 =0;

    #出席率の計算
    #遅刻、欠席、病欠のカウント
      #1限
      #遅刻
      $at1 -> bindValue(1,$str);
      $at1 -> bindValue(2,1);
      $at1->execute();
      $aten1=$at1->fetch();
      $a1 = $a1 + $aten1['at1'];
      #欠課
      $at1 -> bindValue(2,2);
      $at1->execute();
      $aten1=$at1->fetch();
      $a2 = $a2 + $aten1['at1'];
      #病欠
      $at1 -> bindValue(2,4);
      $at1->execute();
      $aten1=$at1->fetch();
      $a4 = $a4 + $aten1['at1'];
      #2限
      #遅刻
      $at2 -> bindValue(1,$str);
      $at2 -> bindValue(2,1);
      $at2->execute();
      $aten2=$at2->fetch();
      $a1 = $a1 + $aten2['at2'];
      #欠課
      $at2-> bindValue(2,2);
      $at2->execute();
      $aten2=$at2->fetch();
      $a2 = $a2 + $aten2['at2'];
      #病欠
      $at2 -> bindValue(2,4);
      $at2->execute();
      $aten2=$at2->fetch();
      $a4 = $a4 + $aten2['at2'];
      #3限
      #遅刻
      $at3 -> bindValue(1,$str);
      $at3 -> bindValue(2,1);
      $at3->execute();
      $aten3=$at3->fetch();
      $a1 = $a1 + $aten3['at3'];
      #欠課
      $at3-> bindValue(2,2);
      $at3->execute();
      $aten3=$at3->fetch();
      $a2 = $a2 + $aten3['at3'];
      #病欠
      $at3 -> bindValue(2,4);
      $at3->execute();
      $aten3=$at3->fetch();
      $a4 = $a4 + $aten3['at3'];
      #4限
      #遅刻
      $at4 -> bindValue(1,$str);
      $at4 -> bindValue(2,1);
      $at4->execute();
      $aten4=$at4->fetch();
      $a1 = $a1 + $aten4['at4'];
      #欠課
      $at4-> bindValue(2,2);
      $at4->execute();
      $aten4=$at4->fetch();
      $a2 = $a2 + $aten4['at4'];
      #病欠
      $at4 -> bindValue(2,4);
      $at4->execute();
      $aten4=$at4->fetch();
      $a4 = $a4 + $aten4['at4'];
      #5限
      #遅刻
      $at5 -> bindValue(1,$str);
      $at5 -> bindValue(2,1);
      $at5->execute();
      $aten5=$at5->fetch();
      $a1 = $a1 + $aten5['at5'];
      #欠課
      $at5-> bindValue(2,2);
      $at5->execute();
      $aten5=$at5->fetch();
      $a2 = $a2 + $aten5['at5'];
      #病欠
      $at5 -> bindValue(2,4);
      $at5->execute();
      $aten5=$at5->fetch();
      $a4 = $a4 + $aten5['at5'];
    

  #欠席時間合計
  $aa1 = floor($a1 / 3);
  $absence = $aa1 + $a2 + $a4;
  #出席率計算
  $attenrate = floor((1 - ($absence / $allday)) * 1000)/10;


      #出席番号を表示
       echo "<tr><th class='ui-state-default ui-widget-content'><div class='text-center disable'>".$result['userid']."</div></th>";
      #名前を表示
        echo "<th class='disable ui-state-default ui-widget-content' scope='row'>".$result2['name']."</th>";
      #出席率を表示
        if(number_format($attenrate,1) >= 80){
            echo "<td class='disable ui-state-default ui-widget-content text-center'><b>".number_format($attenrate,1) ."%</font></b></td>";
        }else{
        echo "<td class='disable ui-state-default ui-widget-content text-center'><b><font color='red'>".number_format($attenrate,1) ."%</font></b></td>";
      }
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
      
      $key = $userday['userid'].":".date('Y',$day[$i]).":".date('n',$day[$i]).":".date('d',$day[$i]).":attendance";
      $session_stack = array_merge($session_stack,array($key.'1'=>$userday['attendance1'], $key.'2'=>$userday['attendance2'], $key.'3'=>$userday['attendance3'], $key.'4'=>$userday['attendance4'], $key.'5'=>$userday['attendance5']));

      echo "<input type='hidden' id='".(1+($i*5)+(($num-1)*35))."' name='atd[]' value='".$userday['attendance1']."'>";
      echo "<input type='hidden' id='".(2+($i*5)+(($num-1)*35))."' name='atd[]' value='".$userday['attendance2']."'>";
      echo "<input type='hidden' id='".(3+($i*5)+(($num-1)*35))."' name='atd[]' value='".$userday['attendance3']."'>";
      echo "<input type='hidden' id='".(4+($i*5)+(($num-1)*35))."' name='atd[]' value='".$userday['attendance4']."'>";
      echo "<input type='hidden' id='".(5+($i*5)+(($num-1)*35))."' name='atd[]' value='".$userday['attendance5']."'>";
    #出欠状況を表示
    #1限
      if ($userday['attendance1'] == "") {
        echo "<th class='text-center  ui-state-default ui-widget-content ".(1+($i*5)+(($num-1)*35))."' ></th>";        
      #出席は白
      }elseif($userday['attendance1'] == 0){
        echo "<td id='contentu'  class='text-center  ui-state-default ui-widget-content ".(1+($i*5)+(($num-1)*35))."' style='background-color:#ffffff'>".$userday['attendance1']."</td>";
        #遅刻は黄色
      }elseif($userday['attendance1'] == 1){
        echo "<td id='contentu'   class='text-center  ui-state-default ui-widget-content ".(1+($i*5)+(($num-1)*35))."' style ='background-color:#ffff00 ' >".$userday['attendance1']."</td>";
        #欠課は赤
      }elseif($userday['attendance1'] == 2) {
        echo "<td id='contentu'   class='text-center  ui-state-default ui-widget-content ".(1+($i*5)+(($num-1)*35))."' style ='background-color:#ff0000'>".$userday['attendance1']."</td>";
        #就活は水色
      }elseif($userday['attendance1'] == 3) {
        echo "<td id='contentu'   class='text-center  ui-state-default ui-widget-content ".(1+($i*5)+(($num-1)*35))."' style ='background-color:#00ffff'>".$userday['attendance1']."</td>";
        #病欠は緑
      }elseif($userday['attendance1'] == 4) {
        echo "<td id='contentu'   class='text-center  ui-state-default ui-widget-content ".(1+($i*5)+(($num-1)*35))."' style ='background-color:#00ff00'>".$userday['attendance1']."</td>";
        #公欠は青
      }elseif($userday['attendance1'] == 5) {
        echo "<td id='contentu'   class='text-center  ui-state-default ui-widget-content ".(1+($i*5)+(($num-1)*35))."' style ='background-color:#1c90eb'>".$userday['attendance1']."</td>";
      }
      #2限
      if ($userday['attendance1'] == "") {
        echo "<th class='text-center  ui-state-default ui-widget-content ".(2+($i*5)+(($num-1)*35))."'></th>";        
      }elseif($userday['attendance2'] == 0){
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(2+($i*5)+(($num-1)*35))."' style='background-color:#ffffff'>".$userday['attendance2']."</td>";
      }elseif($userday['attendance2'] == 1){
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(2+($i*5)+(($num-1)*35))."' style ='background-color:#ffff00'>".$userday['attendance2']."</td>";
      }elseif($userday['attendance2'] == 2) {
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(2+($i*5)+(($num-1)*35))."' style ='background-color:#ff0000'>".$userday['attendance2']."</td>";
      }elseif($userday['attendance2'] == 3) {
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(2+($i*5)+(($num-1)*35))."' style ='background-color:#00ffff'>".$userday['attendance2']."</td>";
      }elseif($userday['attendance2'] == 4) {
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(2+($i*5)+(($num-1)*35))."' style ='background-color:#00ff00'>".$userday['attendance2']."</td>";
      }elseif($userday['attendance2'] == 5) {
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(2+($i*5)+(($num-1)*35))."' style ='background-color:#1c90eb'>".$userday['attendance2']."</td>";
      }
      #3限
      if ($userday['attendance1'] == "") {
        echo "<th  class='text-center  ui-state-default ui-widget-content ".(3+($i*5)+(($num-1)*35))."'></th>";        
      }elseif($userday['attendance3'] == 0){
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(3+($i*5)+(($num-1)*35))."' style='background-color:#ffffff' >".$userday['attendance3']."</td>";
      }elseif($userday['attendance3'] == 1){
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(3+($i*5)+(($num-1)*35))."'   style ='background-color:#ffff00'>".$userday['attendance3']."</td>";
      }elseif($userday['attendance3'] == 2) {
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(3+($i*5)+(($num-1)*35))."'   style ='background-color:#ff0000'>".$userday['attendance3']."</td>";
      }elseif($userday['attendance3'] == 3) {
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(3+($i*5)+(($num-1)*35))."'   style ='background-color:#00ffff'>".$userday['attendance3']."</td>";
      }elseif($userday['attendance3'] == 4) {
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(3+($i*5)+(($num-1)*35))."'   style ='background-color:#00ff00'>".$userday['attendance3']."</td>";
      }elseif($userday['attendance3'] == 5) {
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(3+($i*5)+(($num-1)*35))."'   style ='background-color:#1c90eb'>".$userday['attendance3']."</td>";
      }
      #4限
      if ($userday['attendance1'] == "") {
        echo "<th class='text-center  ui-state-default ui-widget-content ".(4+($i*5)+(($num-1)*35))."'></th>";        
      }elseif($userday['attendance4'] == 0){
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(4+($i*5)+(($num-1)*35))."' style='background-color:#ffffff'>".$userday['attendance4']."</td>";
      }elseif($userday['attendance4'] == 1){
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(4+($i*5)+(($num-1)*35))."'   style ='background-color:#ffff00'>".$userday['attendance4']."</td>";
      }elseif($userday['attendance4'] == 2) {
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(4+($i*5)+(($num-1)*35))."'   style ='background-color:#ff0000'>".$userday['attendance4']."</td>";
      }elseif($userday['attendance4'] == 3) {
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(4+($i*5)+(($num-1)*35))."'   style ='background-color:#00ffff'>".$userday['attendance4']."</td>";
      }elseif($userday['attendance4'] == 4) {
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(4+($i*5)+(($num-1)*35))."'   style ='background-color:#00ff00'>".$userday['attendance4']."</td>";
      }elseif($userday['attendance4'] == 5) {
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(4+($i*5)+(($num-1)*35))."'   style ='background-color:#1c90eb'>".$userday['attendance4']."</td>";
      }
      #5限
      if ($userday['attendance1'] == "") {
        echo "<th  class='text-center  ui-state-default ui-widget-content ".(5+($i*5)+(($num-1)*35))."'></th>";        
      }elseif($userday['attendance5'] == 0){
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(5+($i*5)+(($num-1)*35))."' style='background-color:#ffffff'>".$userday['attendance5']."</td>";
      }elseif($userday['attendance5'] == 1){
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(5+($i*5)+(($num-1)*35))."'   style ='background-color:#ffff00'>".$userday['attendance5']."</td>";
      }elseif($userday['attendance5'] == 2) {
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(5+($i*5)+(($num-1)*35))."'   style ='background-color:#ff0000'>".$userday['attendance5']."</td>";
      }elseif($userday['attendance5'] == 3) {
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(5+($i*5)+(($num-1)*35))."'   style ='background-color:#00ffff'>".$userday['attendance5']."</td>";
      }elseif($userday['attendance5'] == 4) {
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(5+($i*5)+(($num-1)*35))."'   style ='background-color:#00ff00'>".$userday['attendance5']."</td>";
      }elseif($userday['attendance5'] == 5) {
        echo "<td id='contentu' class='text-center  ui-state-default ui-widget-content ".(5+($i*5)+(($num-1)*35))."'   style ='background-color:#1c90eb'>".$userday['attendance5']."</td>";
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
      <center>
        <fieldset style="border: 1px solid #ababab">
          <div class="form-group">
            <p class="control-label"><b>一括変更用パネル</b></p>
            <div class="radio-inline">
              <input type="radio" value="0" name="attendance" id="atbtn">
                <label for="man">0出席</label>
            </div>
            <div class="radio-inline">
              <input type="radio" value="1" name="attendance" id="atbtn">
              <label for="woman">1遅刻</label>
            </div>
            <div class="radio-inline">
              <input type="radio" value="2" name="attendance" id="atbtn">
                <label for="man">2欠課</label>
            </div>
            <div class="radio-inline">
              <input type="radio" value="3" name="attendance" id="atbtn">
                <label for="man">3就活</label>
            </div>
            <div class="radio-inline">
              <input type="radio" value="4" name="attendance" id="atbtn">
                <label for="man">4病欠</label>
            </div>
            <div class="radio-inline">
              <input type="radio" value="5" name="attendance" id="atbtn">
                <label for="man">5公欠</label>
            </div>
          </div>
        </fieldset>
      </center>
        <div class="col-xs-1" style="margin-left: 40%;">
          <!-- TOPへ戻るボタン -->
          <button class="btn btn-lg btn-primary btn-block" id="Back" name="Back" type="Submit">TOPへ</button>
        </div>
        <div class="col-xs-1"style="margin-right: 40%;">
          <!-- 変更ボタン -->
          <button class="btn btn-lg btn-primary btn-block" id="Submit" name="Submit" value="Registration" type="Submit" >変更</button>          
        </div>
    </form>
  </body>
</html>
<?php
  $_SESSION["attendance1"] = $session_stack;
?>