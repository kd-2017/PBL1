<?php 
	# セッション開始
    session_start();
    $_SESSION['weekcount'] += 1;
	header('location:attendanceChangeForm.php')
 ?>