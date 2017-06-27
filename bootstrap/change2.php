<!DOCTYPE html>
  <html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登校日変更</title>
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

  </head>
  <body>
     <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">登校日変更</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">登校日変更</a>
          </div>

         <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
          <li><a href="teacher.php"><i class="fa fa-home"></i> トップページへ</a></li>
          <li><a href="schooldays.html"><i class="fa fa-info"></i> 登校日登録</a></li>
          <li><a href="attendanceChangeForm.php"><i class="fa fa-home"></i> 出欠状況の変更</a></li>
          <li><a href="User1Form.php"><i class="fa fa-info"></i> 新年度登録</a></li>
          <li><a href="backupForm.php"><i class="fa fa-home"></i> バックアップ</a></li>
          <li><a href="logout.php"><i class="fa fa-info"></i> ログアウト</a></li>
          </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
    <div class = "container">
      <div class="wrapper">
          <h3 class="form-signin-heading">
            登校日を変更しました。
      </div>
      </div>
      </body>
      </html>

<?php

$date = $_POST["modify"];
$hoge1=date_parse_from_format("Y-m-d", $date);

$dsn = 'mysql:dbname=admin;host=localhost';
$user = 'admin';
$password = 'admin';


 $pdo = new PDO($dsn, $user, $password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

 $stmt = $pdo -> prepare("UPDATE attendance SET schooldays=1-schooldays WHERE (year = ? and month = ? and day = ?)");
 $stmt -> bindValue(1, $hoge1["year"]);
 $stmt -> bindValue(2, $hoge1["month"]);
 $stmt -> bindValue(3, $hoge1["day"]);
 $stmt -> execute();
?>

<?php
if (!function_exists('date_parse_from_format')) {

    function date_parse_from_format($format, $date) {
        // reverse engineer date formats
        $keys = array(
            'Y' => array('year', '\d{4}'),
            'y' => array('year', '\d{2}'),
            'm' => array('month', '\d{2}'),
            'n' => array('month', '\d{1,2}'),
            'M' => array('month', '[A-Z][a-z]{3}'),
            'F' => array('month', '[A-Z][a-z]{2,8}'),
            'd' => array('day', '\d{2}'),
            'j' => array('day', '\d{1,2}'),
            'D' => array('day', '[A-Z][a-z]{2}'),
            'l' => array('day', '[A-Z][a-z]{6,9}'),
            'u' => array('hour', '\d{1,6}'),
            'h' => array('hour', '\d{2}'),
            'H' => array('hour', '\d{2}'),
            'g' => array('hour', '\d{1,2}'),
            'G' => array('hour', '\d{1,2}'),
            'i' => array('minute', '\d{2}'),
            's' => array('second', '\d{2}')
        );

        // convert format string to regex
        $regex = '';
        $chars = str_split($format);
        foreach ($chars AS $n => $char) {
            $lastChar = isset($chars[$n - 1]) ? $chars[$n - 1] : '';
            $skipCurrent = '\\' == $lastChar;
            if (!$skipCurrent && isset($keys[$char])) {
                $regex .= '(?P<' . $keys[$char][0] . '>' . $keys[$char][1] . ')';
            } else if ('\\' == $char) {
                $regex .= $char;
            } else {
                $regex .= preg_quote($char);
            }
        }

        $dt = array();
        $dt['error_count'] = 0;
        // now try to match it
        if (preg_match('#^' . $regex . '$#', $date, $dt)) {
            foreach ($dt AS $k => $v) {
                if (is_int($k)) {
                    unset($dt[$k]);
                }
            }
            if (!checkdate($dt['month'], $dt['day'], $dt['year'])) {
                $dt['error_count'] = 1;
            }
        } else {
            $dt['error_count'] = 1;
        }
        $dt['errors'] = array();
        $dt['fraction'] = '';
        $dt['warning_count'] = 0;
        $dt['warnings'] = array();
        $dt['is_localtime'] = 0;
        $dt['zone_type'] = 0;
        $dt['zone'] = 0;
        $dt['is_dst'] = '';
        return $dt;
    }

}
?>
