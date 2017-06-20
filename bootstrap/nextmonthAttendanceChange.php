<?php 
	# セッション開始
    session_start();
    $_SESSION['monthcount'] += 1;
	header('location:attendanceChangeForm.php')
 ?>