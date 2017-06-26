<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>学生用トップページ</title>
    <!-- BootstrapのCSS読み込み -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/roguin.css" rel="stylesheet">
    <!-- jQuery読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- BootstrapのJS読み込み -->
    <script src="js/bootstrap.min.js"></script>
   </head>
    <body>
    <br>
     <div class="container-fluid">
        <div class="row">
        <div class="col-xs-12 col-md-6">
        <h1 class="text-center">
	   <?php
		session_start();
    if($_SESSION['userid']['admin'] == '1' || empty($_SESSION['userid'][''] )){
    header('location:login.html');
    exit;
    }
        echo $_SESSION['userid']['name']."さん</h1>";
        $dsn = 'mysql: host = localhost;dbname=admin; charset=utf8';
        $user = 'admin';
        $pass = 'admin';
    try{
        $pdo = new PDO($dsn,$user,$pass);
    
        date_default_timezone_set('Asia/Tokyo');
        $year = (int)date("Y");
        $month = (int)date("m");
        $day = (int)date("d");
        $now = date("His");
        $ontime_flg = 0;
        $offtime_flg = 1;

        if (isset($_POST["sub1"])){
            $stmt= $pdo->prepare("UPDATE attendance SET  ontime = ? WHERE year = ? and month = ? and day = ? and userid = ?");
        $stmt->execute([$now, $year, $month, $day, $_SESSION['userid']['userid']]);
        $offtime_flg = 0;

        if($now <= 092000){
            $stmt= $pdo->prepare("UPDATE attendance SET attendance1 = '0' , attendance2 = '0' , attendance3 = '0' , attendance4 = '0' , attendance5 = '0' WHERE year = ? and month = ? and day = ? and userid = ?");

        }else if($now >= 092001 && $now <= 093500){
            $stmt= $pdo->prepare("UPDATE attendance SET attendance1 = '1' , attendance2 = '0' , attendance3 = '0' , attendance4 = '0' , attendance5 = '0' WHERE year = ? and month = ? and day = ? and userid = ?");
        
        }else if($now >= 093501 && $now <= 102000){
            $stmt= $pdo->prepare("UPDATE attendance SET attendance1 = '2' , attendance2 = '0' , attendance3 = '0' , attendance4 = '0' , attendance5 = '0' WHERE year = ? and month = ? and day = ? and userid = ?");
        
        }else if($now >= 102001 && $now <= 103500){
            $stmt= $pdo->prepare("UPDATE attendance SET attendance1 = '2' , attendance2 = '1' , attendance3 = '0' , attendance4 = '0' , attendance5 = '0' WHERE year = ? and month = ? and day = ? and userid = ?");
        
        }else if($now >= 103501 && $now <= 112000){
            $stmt= $pdo->prepare("UPDATE attendance SET attendance1 = '2' , attendance2 = '2' , attendance3 = '0' , attendance4 = '0' , attendance5 = '0' WHERE year = ? and month = ? and day = ? and userid = ?");
        
        }else if($now >= 112001 && $now <= 113500){
            $stmt= $pdo->prepare("UPDATE attendance SET attendance1 = '2' , attendance2 = '2' , attendance3 = '1' , attendance4 = '0' , attendance5 = '0' WHERE year = ? and month = ? and day = ? and userid = ?");
        
        }else if($now >= 113501 && $now <= 130000){
            $stmt= $pdo->prepare("UPDATE attendance SET attendance1 = '2' , attendance2 = '2' , attendance3 = '2' , attendance4 = '0' , attendance5 = '0' WHERE year = ? and month = ? and day = ? and userid = ?");
        
        }else if($now >= 130001 && $now <= 131500){
            $stmt= $pdo->prepare("UPDATE attendance SET attendance1 = '2' , attendance2 = '2' , attendance3 = '2' , attendance4 = '1' , attendance5 = '0' WHERE year = ? and month = ? and day = ? and userid = ?");
        
        }else if($now >= 131501 && $now <= 140000){
            $stmt= $pdo->prepare("UPDATE attendance SET attendance1 = '2' , attendance2 = '2' , attendance3 = '2' , attendance4 = '2' , attendance5 = '0' WHERE year = ? and month = ? and day = ? and userid = ?");
        
        }else if($now >= 140001 && $now <= 141500){
            $stmt= $pdo->prepare("UPDATE attendance SET attendance1 = '2' , attendance2 = '2' , attendance3 = '2' , attendance4 = '2' , attendance5 = '1' WHERE year = ? and month = ? and day = ? and userid = ?");
        
        }else{
            $stmt= $pdo->prepare("UPDATE attendance SET attendance1 = '2' , attendance2 = '2' , attendance3 = '2' , attendance4 = '2' , attendance5 = '2' WHERE year = ? and month = ? and day = ? and userid = ?");
        }
            $stmt->execute([$year, $month, $day, $_SESSION['userid']['userid']]);
        }

        if (isset($_POST["sub2"])){
            $stmt= $pdo->prepare("UPDATE attendance SET  offtime = ? WHERE year = ? and month = ? and day = ? and userid = ?");
        $stmt->execute([$now, $year, $month, $day, $_SESSION['userid']['userid']]);

        if($now >= 092000 && $now <= 100959 ){
            $stmt= $pdo->prepare("UPDATE attendance SET attendance1 = '2' , attendance2 = '2' , attendance3 = '2' , attendance4 = '2' , attendance5 = '2' WHERE year = ? and month = ? and day = ? and userid = ?");
        
        }else if($now >= 101000 && $now <= 110959){
            $stmt= $pdo->prepare("UPDATE attendance SET attendance2 = '2' , attendance3 = '2' , attendance4 = '2' , attendance5 = '2' WHERE year = ? and month = ? and day = ? and userid = ?");

        }else if($now >= 111000 && $now <= 120959){
            $stmt= $pdo->prepare("UPDATE attendance SET attendance3 = '2' , attendance4 = '2' , attendance5 = '2' WHERE year = ? and month = ? and day = ? and userid = ?");

        }else if($now >= 121000 && $now <= 134959){
            $stmt= $pdo->prepare("UPDATE attendance SET attendance4 = '2' , attendance5 = '2' WHERE year = ? and month = ? and day = ? and userid = ?");

        }else if($now >= 135000 && $now <= 144959){
            $stmt= $pdo->prepare("UPDATE attendance SET attendance5 = '2' WHERE year = ? and month = ? and day = ? and userid = ?");
        }    

         $stmt->execute([$year, $month, $day, $_SESSION['userid']['userid']]);
        
        }

    }catch(Exception $e){
        echo 'Error:' . $e->getMessage();
    }

        $stmt=$pdo->prepare("SELECT * from attendance where userid = ? and year = ? and month = ? and day = ?");
        $stmt->execute([$_SESSION['userid']['userid'], $year, $month, $day]);
        $result = $stmt->fetch();
        
        if($result['ontime'] != null){
            $ontime_flg = 1;
        }
        if($result['offtime'] != null){
            $offtime_flg = 1;
        }

        ?>
        <br>
        <h3 class="text-center">あなたの出席率は現在<br>

        <?php
      #すべての登校日から授業時間を計算
  $sday = $pdo->query("SELECT * FROM calendar WHERE schooldays = 1");
  $allday = $sday->rowCount();
  #全体の出席時間
  $allday *= 5;

  #出欠カウント
  $at1 = $pdo->prepare("SELECT count(attendance1) as at1 FROM `attendance` WHERE userid = ? AND attendance1 = ?");
  $at2 = $pdo->prepare("SELECT count(attendance2) as at2 FROM `attendance` WHERE userid = ? AND attendance2 = ?");
  $at3 = $pdo->prepare("SELECT count(attendance3) as at3 FROM `attendance` WHERE userid = ? AND attendance3 = ?");
  $at4 = $pdo->prepare("SELECT count(attendance4) as at4 FROM `attendance` WHERE userid = ? AND attendance4 = ?");
  $at5 = $pdo->prepare("SELECT count(attendance5) as at5 FROM `attendance` WHERE userid = ? AND attendance5 = ?");

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
      $at1 -> bindValue(1,$_SESSION['userid']['userid']);
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
      $at2 -> bindValue(1,$_SESSION['userid']['userid']);
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
      $at3 -> bindValue(1,$_SESSION['userid']['userid']);
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
      $at4 -> bindValue(1,$_SESSION['userid']['userid']);
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
      $at5 -> bindValue(1,$_SESSION['userid']['userid']);
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
 #出席率を表示
        if(number_format($attenrate,1) >= 80){
            echo "<td class='text-center'><b>".number_format($attenrate,1) ."%</font></b></td>";
        }else{
        echo "<td class='text-center'><b><font color='red'>".number_format($attenrate,1) ."%</font></b></td>";
      }

        ?></h3><br>
    
        <form method="POST" action="">
<?php
        if($ontime_flg == 1){
?>
        <p><input type="submit" id="hyouji" value="登校" name="sub1" class="btn btn-primary" onClick="Click_Sub()" style="width:100%;padding:10px;font-size:30px;" disabled></p>
        <h3><div id="div1" style="display: none;">登校が完了しました</div></h3>
<?php
        } else {
?>
        <p><input type="submit" id="hyouji" value="登校" name="sub1" class="btn btn-primary" onClick="Click_Sub()" style="width:100%;padding:10px;font-size:30px;"></p>
        <h3><div id="div1" style="display: none;">登校が完了しました</div></h3>
<?php
        }
?>
        </form><br>
        
        <form method="POST" action="">
<?php
        if($offtime_flg == 1){
?>
        <p><input type="submit" id="hyouji1" value="下校" name="sub2" class="btn btn-primary" onClick="Click_Sub1()" style="width:100%;padding:10px;font-size:30px;" disabled></p>
        <h3><div id="div2" style="display: none;">下校が完了しました</div></h3>
<?php
        } else {
?>
        <p><input type="submit" id="hyouji1" value="下校" name="sub2" class="btn btn-primary" onClick="Click_Sub1()" style="width:100%;padding:10px;font-size:30px;"></p>
        <h3><div id="div2" style="display: none;">下校が完了しました</div></h3>
<?php
        }
?>
        </form><br>
        
        <form method="POST" action="">
        <p><input type="button" value="出欠状況の確認" class="btn btn-primary" onclick="location.href='confirmation.php'" style="width:100%;padding:10px;font-size:30px;"></p>
        <br></form>

        <form method="POST" action="">
        <p><input type="button" value="パスワード変更" class="btn btn-primary" onclick="location.href='ChangePassForm.php'" style="width:100%;padding:10px;font-size:30px;"></p>
        <br></form>

        <form method="POST" action="">
        <p><input type="button" value="ログアウト" class="btn btn-primary" onclick="location.href='logout.php'" style="width:100%;padding:10px;font-size:30px;"></p>
        <br>
        </form>
    </div>
  </div>
</div>
  </body>
</html>