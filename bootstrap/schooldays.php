<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登校日登録</title>
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
              <span class="sr-only">登校日登録</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">登校日登録</a>
          </div>

         <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
          <li><a href="teacher.php"><i class="fa fa-home"></i> トップページへ</a></li>
          <li><a href="schoolchange.html"><i class="fa fa-info"></i> 登校日変更</a></li>
          <li><a href="attendanceChangeForm.php"><i class="fa fa-home"></i> 出欠状況の変更</a></li>
          <li><a href="User1Form.php"><i class="fa fa-info"></i> 新年度登録</a></li>
          <li><a href="backupForm.php"><i class="fa fa-home"></i> バックアップ</a></li>
          <li><a href="logout.php"><i class="fa fa-info"></i> ログアウト</a></li>
          </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
    <div style="display:inline-flex">
    <div class="container">
        <div class="row">
            <form action="SET_schooldays.php" method="post" name="date">
            <div class='col-sm-4 col-sm-offset-4'>
                <div class="form-group">
                <label for="first" class="control-label">始業日</label>
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='text' name="first" id="first" placeholder="始業日を入力" class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    </div>
                <div class="form-group">
                <label for="last" class="control-label">終業日</label>
                    <div class='input-group date' id='datetimepicker2'>
                        <input type='text' name="last" id="last" placeholder="終業日を入力" class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
              <input type="submit" value="登録">
            </div>
              </form>
           <script type="text/javascript">
                  $(function () {
                    $('.date').datetimepicker({
                      locale: 'ja',
                      format : 'YYYY-MM-DD'
                    });
                  });
                  </script>
        </div>
    </div>
    </div>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/locale/ja.js"></script>
    <script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/v4.0.0/src/js/bootstrap-datetimepicker.js"></script>

</body>
</html>