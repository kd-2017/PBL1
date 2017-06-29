<?php
$date = $_POST["form"];
$hoge1=date_parse_from_format("Y-m-d", $date);

$date = $_POST["to"];
$hoge2=date_parse_from_format("Y-m-d", $date);

$dsn = 'mysql:dbname=admin;host=localhost';
$user = 'admin';
$password = 'admin';

//$dbh = new PDO($dsn, $user, $password);

 $pdo = new PDO($dsn, $user, $password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

 if($hoge1["month"]==12){ //範囲指定が12月からスタートしていた場合
   $hoge3=1;

   $stmt = $pdo -> prepare("UPDATE attendance SET schooldays=1-schooldays WHERE ((year = ? and month = ? and day >= ?) or (year = ? and month >= ? and day >= 1) or
                                                                       (year = ? and month <= ? and day <= 31) or (year = ? and month = ? and day <= ?))");
   $stmt -> bindValue(1, $hoge1["year"]);
   $stmt -> bindValue(2, $hoge1["month"]);
   $stmt -> bindValue(3, $hoge1["day"]);
   $stmt -> bindValue(4, $hoge1["year"]+1);
   $stmt -> bindValue(5, $hoge3);
   $stmt -> bindValue(6, $hoge2["year"]);
   $stmt -> bindValue(7, $hoge2["month"]-1);
   $stmt -> bindValue(8, $hoge2["year"]);
   $stmt -> bindValue(9, $hoge2["month"]);
   $stmt -> bindValue(10, $hoge2["day"]);
   $stmt -> execute();

 } elseif ($hoge2["month"]==1) { //範囲指定が1月で終わっている場合
   $hoge4=12;

   $stmt = $pdo -> prepare("UPDATE attendance SET schooldays=1-schooldays WHERE ((year = ? and month = ? and day >= ?) or (year = ? and month >= ? and day >= 1) or
                                                                       (year = ? and month <= ? and day <= 31) or (year = ? and month = ? and day <= ?))");
   $stmt -> bindValue(1, $hoge1["year"]);
   $stmt -> bindValue(2, $hoge1["month"]);
   $stmt -> bindValue(3, $hoge1["day"]);
   $stmt -> bindValue(4, $hoge1["year"]);
   $stmt -> bindValue(5, $hoge1["month"]+1);
   $stmt -> bindValue(6, $hoge2["year"]-1);
   $stmt -> bindValue(7, $hoge4);
   $stmt -> bindValue(8, $hoge2["year"]);
   $stmt -> bindValue(9, $hoge2["month"]);
   $stmt -> bindValue(10, $hoge2["day"]);
   $stmt -> execute();

 } elseif(($hoge1["month"]==12 and $hoge2["month"]==1) or (($hoge1["month"]+1) == $hoge2["month"]) or $hoge1["month"]==$hoge2["month"] ) {//範囲指定の月が連続している場合or範

   $stmt = $pdo -> prepare("UPDATE attendance SET schooldays=1-schooldays WHERE ((year = ? and month = ? and day >= ?) or (year = ? and month = ? and day <= ?))");
   $stmt -> bindValue(1, $hoge1["year"]);
   $stmt -> bindValue(2, $hoge1["month"]);
   $stmt -> bindValue(3, $hoge1["day"]);
   $stmt -> bindValue(4, $hoge2["year"]);
   $stmt -> bindValue(5, $hoge2["month"]);
   $stmt -> bindValue(6, $hoge2["day"]);
   $stmt -> execute();

 } elseif($hoge1["month"]==$hoge2["month"]){//範囲指定の月が同じ
   $stmt = $pdo -> prepare("UPDATE attendance SET schooldays=1-schooldays WHERE ((year = ? and month = ? and day >= ? and day <= ?)");
   $stmt -> bindValue(1, $hoge1["year"]);
   $stmt -> bindValue(2, $hoge1["month"]);
   $stmt -> bindValue(3, $hoge1["day"]);
   $stmt -> bindValue(4, $hoge2["day"]);
   $stmt -> execute();
 } else {//それ以外

 $stmt = $pdo -> prepare("UPDATE attendance SET schooldays=1-schooldays WHERE ((year = ? and month = ? and day >= ?) or (year = ? and month >= ? and day >= 1) or
                                                                     (year = ? and month <= ? and day <= 31) or (year = ? and month = ? and day <= ?))");
 $stmt -> bindValue(1, $hoge1["year"]);
 $stmt -> bindValue(2, $hoge1["month"]);
 $stmt -> bindValue(3, $hoge1["day"]);
 $stmt -> bindValue(4, $hoge1["year"]);
 $stmt -> bindValue(5, $hoge1["month"]+1);
 $stmt -> bindValue(6, $hoge2["year"]);
 $stmt -> bindValue(7, $hoge2["month"]-1);
 $stmt -> bindValue(8, $hoge2["year"]);
 $stmt -> bindValue(9, $hoge2["month"]);
 $stmt -> bindValue(10, $hoge2["day"]);
 $stmt -> execute();
}

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
