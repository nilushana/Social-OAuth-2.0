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

<nav class="navbar navbar-inverse">
<div class="container-fluid">
<div class="navbar-header">
  <a class="navbar-brand" href="index.php">Social OAuth</a>
</div>


<ul class="nav navbar-nav">
  <?php
      if(isset($_COOKIE['session_cookie']))
      {
          echo "<li class='nav-item'>
                  <a class='nav-link active' href='user-profile.php'>Profile</a>
              </li>";
      }
  ?>

  
</ul>
<ul class="nav navbar-nav navbar-right">
  <?php
      if(!isset($_COOKIE['session_cookie']))
      {
          echo "<li class='nav-item'>
                  <a class='nav-link' href='user-login.php'>Login</a>
              </li>";
      }
  ?>
  <?php
      if(isset($_COOKIE['session_cookie']))
      {
          echo "<li class='nav-item'>
                  <a class='nav-link active' href='user-logout.php'>Logout</a>
              </li>";
      }
  ?>
</ul>
</div>
</nav>





      </body>
    </html>
