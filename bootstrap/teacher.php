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
    <!-- BootstrapのJS読み込み -->
    <script src="js/bootstrap.min.js"></script>
  </head>
  <body>
      <center>
      <br>
            <a href="ChangePassForm.php" class="btn btn-default" style="width:10%;padding:20px">パスワード変更</a>
            <a href="#" class="btn btn-default" style="width:10%;padding:20px">登校日の設定</a>
            <a href="#" class="btn btn-default" style="width:10%;padding:20px">出欠状況の変更</a>
            <a href="#" class="btn btn-default" style="width:10%;padding:20px">新年度登録</a>
            <a href="#" class="btn btn-default" style="width:10%;padding:20px">バックアップ</a>
            <a href="logout.php" class="btn btn-default" style="width:10%;padding:20px">ログアウト</a>
            </div>
      <br><br>

        <table border="1" rules="none" style="font-size : 20px;" ><th  style="width:10%;padding:20px"><a href="#">月/週</a></th><th  style="width:10%;padding:20px"><&nbsp;前の週</th><th  style="width:10%;padding:20px">
        <?php
        $today = date("n月j日");
        echo $today. '('.$week_name[date("w")].')';
   		?>
   			
   		</th  style="width:10%;padding:20px"><th  style="width:10%;padding:20px">次の週&nbsp;></th></table>
        </center>
        <table class="table table-responsive" border="1">
    <thead>
      <tr>
        <th>出席番号</th>
        <th>名前</th>
        <th>出席率</th>
        <th colspan="5">
        <!--上記に表示されている週の月曜日をから表示-->
        <?php
        #月曜日
        if (date("w") == 1) {
        echo "<div class='text-center'>".date("n月j日(月)", strtotime($_SESSION["weekcount"]."week"))."</div>"."</th>";
        $monday = strtotime($_SESSION["weekcount"]."week");
		"<div class='text-center'>".date("n月j日",$monday)."</div>";
        }else{
        echo "<div class='text-center'>".date("n月j日(月)", strtotime('last Monday',strtotime($_SESSION["weekcount"]."week")))."</div>"."</th>";
        $monday = strtotime('last Monday',strtotime($_SESSION["weekcount"]."week"));
        "<div class='text-center'>".date("n月j日(月)", $monday)."</div>";
        }
        #火曜日
        $tuesday = strtotime('+1 day',$monday);
        #水曜日
   		$wednesday = strtotime('+2 day',$monday);
   		#木曜日
   		$thursday = strtotime('+3 day',$monday);
   		#金曜日
   		$friday = strtotime('+4 day',$monday);
   		#土曜日
   		$saturday = strtotime('+5 day',$monday);
   		#日曜日
   		$sunday = strtotime('+6 day',$monday);

   		echo "<th colspan='5'>"."<div class='text-center'>".date("n月j日(火)",$tuesday)."</div>"."</th>";
   		
   		echo "<th colspan='5'>"."<div class='text-center'>".date("n月j日(水)",$wednesday)."</div>"."</th>";
   		
   		echo "<th colspan='5'>"."<div class='text-center'>".date("n月j日(木)",$thursday)."</div>"."</th>";
   		
   		echo "<th colspan='5'>"."<div class='text-center'>".date("n月j日(金)",$friday)."</div>"."</th>";
   		
   		echo "<th colspan='5'>"."<div class='text-center'>".date("n月j日(土)",$saturday)."</div>"."</th>";
   		
   		echo "<th colspan='5'>"."<div class='text-center'>".date("n月j日(日)",$sunday)."</div>"."</th>";
        ?>
      </tr>
      </th>
      </tr>
    </thead>
    <?php
    

	
    	echo "<tbody>".
      "<tr>".
        "<th>0K01000</th>".
          "<th scope='row'>〇〇　〇〇</th>".
          "<td>100%</td>".
          "<td>1</td>".
          "<td>2</td>".
          "<td>3</td>".
          "<td>4</td>".
          "<td>5</td>".
          "<td>6</td>".
          "<td>7</td>".
          "<td>8</td>".
          "<td>9</td>".
          "<td>10</td>".
          "<td>11</td>".
          "<td>12</td>".
          "<td>13</td>".
          "<td>14</td>".
          "<td>15</td>".
          "<td>16</td>".
          "<td>17</td>".
          "<td>18</td>".
          "<td>19</td>".
          "<td>20</td>".
          "<td>21</td>".
          "<td>22</td>".
          "<td>23</td>".
          "<td>24</td>".
          "<td>25</td>".
          "<td>26</td>".
          "<td>27</td>".
          "<td>28</td>".
          "<td>29</td>".
          "<td>30</td>".
          "<td>31</td>".
          "<td>32</td>".
          "<td>33</td>".
          "<td>34</td>".
          "<td>35</td>".
      "</tr>".
    "</tbody>";

	/* $str = "0K01013" ;

	// 実行
	$result = explode( "K", $str ) ;

	// 結果
	print_r( $result ) ;*/
		
    ?>
  </table>
  </body>
</html>