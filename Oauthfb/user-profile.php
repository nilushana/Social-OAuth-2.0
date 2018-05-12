<!doctype html>
<html >
<html lang="en">
<head>
<title>CSRF Protection</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="public/css/bootstrap.min.css">
<script src="public/js/jquery.min.js"></script>
<script src="public/js/bootstrap.min.js"></script>
</head>
<body>

  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="index.php">WebSiteName</a>
      </div>




      <ul class="nav navbar-nav">

      </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php if(isset($_COOKIE['session_cookie'])) {
                echo "<li class='nav-item'>
                        <a class='nav-link active' href='user-logout.php'>Logout</a>
                    </li>";
            }
        ?>
        <!--<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> user-logout.php</a></li>-->
      </ul>
    </div>
  </nav>

  <div class="container">
    <div class="row" align="center" style="padding-top: 100px;">
        <div class="col-12">

            <div class="card">
              <h5 class="card-header">Profile</h5>
              <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8">


                <?php

                    if(isset($_COOKIE['session_cookie']))
                    {

                        $string2= $_COOKIE['profile'];

                        $string2=explode('#', $string2);


                        echo"
                        <div class='row'>
                            <div class='col-md-2'>
                                <img src='".$string2[4]."' alt='cover' style='width:100px;height:100px;border-radius: 50%;'>
                            </div>
                            <div class='col-md-10' style='padding-top: 20px;'>
                                <div class='row'>
                            <div class='col-md-4'>
                                <b>Name</b>
                            </div>
                            <div class='col-md-8'>
                                ".$string2[1]." ".$string2[2]."
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-4'>
                                <b>Gender</b>
                            </div>
                            <div class='col-md-8'>
                                ".$string2[3]."
                            </div>
                        </div>


                        <div class='row'>
                            <div class='col-md-4'>
                                <b>E-mail</b>
                            </div>
                            <div class='col-md-8'>
                               ".$string2[0]."
                            </div>
                        </div>
                            </div>
                        </div>";

                    }
                    else
                    {

                            if(isset($_POST["at"]))
                            {
                                if ($_POST["at"] != '' && $_POST["at"] != null)
                                 {
                                        $new=$_POST["at"];

                                        $user_details = "https://graph.facebook.com/me?fields=first_name,last_name,email,gender,picture.type(large)&access_token=".$new;

                                        $response = file_get_contents($user_details);
                                        $response = json_decode($response);


                                    if($response->email != null || $response->email != '')
                                    {
                                        session_set_cookie_params(300);
                                        session_start();
                                        session_regenerate_id();


                                        setcookie('session_cookie', session_id(), time() + 300, '/');

                                        $token = generate_token();

                                        $res=$response->picture;
                                        $res2=$res->data;
                                        $string=$response->email."#".$response->first_name."#".$response->last_name."#".$response->gender."#".$res2->url;

                                        setcookie('csrf_token', $token, time() + 300, '/','www.assignment03.com',true);
                                        setcookie('profile', $string, time() + 300, '/','www.assignment03.com',true);

                                    header("Location:user-profile.php");
                                                exit;

                                    }
                                }

                            }
                            else if(isset($_GET["code"]))
                            {
                                $ur=str_replace("/user-profile.php?code=", "",urldecode($_SERVER['REQUEST_URI']) );

                                $postfields = array('code' => $ur, 'client_id' => '1022600255948-8r7clhu4so4fk1dvshl1vuj3tcpuqm7j.apps.googleusercontent.com',
                                            'client_secret' => 'CyAhrAzlWxAiOOnbyLRb33r-',
                                            'redirect_uri' => 'https://localhost/oauth-social-login-for-web/profile.php',
                                            'grant_type' => 'authorization_code'
                                        );
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                                curl_setopt($ch, CURLOPT_POST, 1);
                                // Edit: prior variable $postFields should be $postfields;
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // On dev server only!
                                $result = curl_exec($ch);
                                $r=json_decode($result);

                                $geturl='https://www.googleapis.com/oauth2/v3/userinfo?access_token='.$r->access_token;


                                $re = file_get_contents($geturl);
                                $array2 = json_decode($re);


                                $res2=$array2->picture;

                                if($array2->email != null || $array2->email != '')
                                    {
                                        session_set_cookie_params(300);
                                        session_start();
                                        session_regenerate_id();


                                        setcookie('session_cookie', session_id(), time() + 300, '/');

                                        $token = generate_token();


                                        $string=$array2->email."#".$array2->given_name."#".$array2->family_name."#".''."#".$res2;

                                        setcookie('csrf_token', $token, time() + 300, '/','www.assignment03.com',true);
                                        setcookie('profile', $string, time() + 300, '/','www.assignment03.com',true);

                                        header("Location:user-profile.php");
                                        exit;

                                    }

                            }
                            else
                            {
                                echo "<form action='user-profile.php'  method='post' id='form'>
                                <input type='hidden' name='at' id='at'>
                                </form>

                                <script >
                                var ur=location.hash.replace('#access_token=', '');
                                var ur=ur.split('&');
                                var u=ur[0];

                                document.getElementById('at').value = u;
                                document.getElementById('form').submit();

                                </script>";
                            }


                    }
                    function generate_token()
                    {

                        return sha1(base64_encode(openssl_random_pseudo_bytes(30)));

                    }

                ?>


                        </div>
                        <div class="col-sm-2"></div>
                    </div>
              </div>
            </div>



        </div>
    </div>
</div>

</body>
</html>
