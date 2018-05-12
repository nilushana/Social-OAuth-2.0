<!doctype html>
<html >
<html lang="en">
<head>
<title>Social Login</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="public/css/bootstrap.min.css">
<script src="public/js/jquery.min.js"></script>
<script src="public/js/bootstrap.min.js"></script>
</head>
</body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">Social Login</a>
    </div>
  </div>
</nav>

<div class="container">
    <div class="row" align="center" style="padding-top: 100px;">
        <div class="col-12">

            <div class="card">
              <h5 class="card-header">Login</h5>
              <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8">


                                <form action='user-login.php' method='POST' enctype='multipart/form-data'>

                                    <div class="form-group row">
                                        <label for="Email" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                          <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                        </div>
                                    </div>
                                  <div class="form-group row">
                                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                                        <div class="col-sm-10">
                                          <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                        </div>
                                  </div>

                                <button type="submit" class="btn btn-primary" id="submit" name="submit">Login</button>


                                </form>
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                    <div class="row" align="center">
                      <div class="col-sm-1"></div>
                      <div class="col-sm-1">
                          <a href="https://graph.facebook.com/oauth/authorize?response_type= token&client_id=187394828554312&redirect_uri=https://localhost:8443/Oauthfb/user-profile.php&scope=email%20public_profile" class="btn btn-primary" style="border-radius: 50%;color: white;width: 70px;height: 70px;font-size: 40px">f
                                </a>
                      </div>

                      <div class="col-sm-1">
                          <a href="https://accounts.google.com/o/oauth2/auth?redirect_uri=https://localhost/oauth-social-login-for-web/user-profile.php&response_type=code&client_id=1022600255948-8r7clhu4so4fk1dvshl1vuj3tcpuqm7j.apps.googleusercontent.com&scope=email profile&approval_prompt=force&access_type=offline" class="btn btn-danger" style="border-radius: 50%;color: white;width: 70px;height: 70px;font-size: 40px;">G
                                </a>
                      </div>





                    </div>
              </div>
            </div>



        </div>
    </div>
</div>


</body>
</html>


<?php
	if(isset($_POST['submit'])){
		login();
	}
?>

<?php

	function login()
	{

		$email='test@gmail.com';
		$password='1234';


		$input_email = $_POST['email'];
		$input_pwd = $_POST['password'];


		if(($input_email == $email)&&($input_pwd == $password))
		{
			session_set_cookie_params(300);
			session_start();
			session_regenerate_id();


			setcookie('session_cookie', session_id(), time() + 300, '/');

			$token = generate_token();

      setcookie('csrf_token', $token, time() + 300, '/','www.assignment03.com',true);

			header("Location:user-profile.php");
   			exit;

		}
		else
		{
			echo "<script>alert('email password are not a match!')</script>";
		}


	}

function generate_token()
	{

	  return sha1(base64_encode(openssl_random_pseudo_bytes(30)));

	}


?>
