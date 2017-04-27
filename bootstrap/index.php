<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Sample</title>
    <!-- BootstrapのCSS読み込み -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/roguin.css" rel="stylesheet">
    <!-- jQuery読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- BootstrapのJS読み込み -->
    <script src="js/bootstrap.min.js"></script>
  </head>
  <body>
  <div class = "container">
  <div class="wrapper">
    <form action="" method="post" name="Login_Form" class="form-signin">       
        <h3 class="form-signin-heading">IDとパスワードを入力してください</h3>
        <hr class="colorgraph"><br>

        <input type="text" class="form-control" name="id" placeholder="ID" required="" autofocus="" />

        <input type="password" class="form-control" name="Password" placeholder="Password" required=""/> 

        <button class="btn btn-lg btn-primary btn-block"  name="Submit" value="Login" type="Submit">Login</button>        
    </form>     
  </div>
</div>
  </body>
</html>