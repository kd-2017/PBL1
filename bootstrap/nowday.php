<?php 
	# セッション開始
    session_start();
    $_SESSION['weekcount'] = 0;
    $_SESSION['monthcount'] = 0;
	header('location:teacher.php')
 ?>