<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: index.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatiable" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="loginstyle.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        .notification {
            display: none;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 30%;
            background-color: #f44336;
            color: white;
            text-align: center;
            padding: 10px;
            font-size: 18px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        }
        
        .close-btn {
            color: white;
            float: right;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        
        .close-btn:hover {
            color: black;
        }
    </style>

</head>
<body>

<div class="upperbox">
  <header>
    <h3 style="color: white; height: 20px; font-size: 40px;padding-top: 30px; position: absolute; top: 0; text-align: left; left: 150px;">BHARATHIDASAN UNIVERSITY</h3>
    <!--<h4 style="color: white; height: 20px; font-size: 30px; padding-top: 50px; position: absolute; top: 0; text-align: left; left: 200px;">TECHNOLOGY PARK</h4>-->
    <h5 style="color: white; height: 20px; font-size: 25px; padding-top: 20px; position: absolute; top: 0; right: 0; text-align: right; right:50px"><i class='bx bxs-location-plus'></i> KHAJAMALAI CAMPUS </h5>
    <h5 style=" color: white; height: 20px; font-size: 25px; padding-top: 50px; position: absolute; top: 0; right: 0; text-align: right; right: 40px;">TIRUCHIRAPALLI-620023</h5>
    <!--<h5 style="color: white; height: 20px; font-size: 20px; padding-top: 60px; position: absolute; top: 0; right: 0; text-align: right; right: 80px;"><i class='bx bxs-phone-call' ></i> 0431 240 7092</h5>-->
    <img src="download1.png" alt="BHARATHIDASAN UNIVERSITY" title="BHARATHIDASAN UNIVERSITY" style="height: 100px; width: 120px; position: absolute; top: 0; left: 0;object-fit: cover; width: 120px; height: 100px; left: 20px; float: right;">
  </header>
  </div>

    <div class="Department">
    <h2 style="color: #fff; text-decoration: underline; text-align: right; margin-right: 20px;">School of Computer Science, Engineering & Applications</h2>
    </div>
   <div class="wrapper">

   <form action="#" method="post">

      <h1>Login</h1>
      <div class="input-box">
        <input type="email" name="email" id="email" placeholder="Email" required
               value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
        <i class='bx bxs-user-circle'></i>
      </div>

      <div class="input-box">
        <input type="password" name="password" id="password" placeholder="Password" required>
        <i class='bx bxs-lock-alt'></i>
      </div>

      <div class="remember-forgot">
        <label><input type="checkbox">Remember me</label>
        <a href="forgot-password.php">Forgot Password?</a>
      </div>
      <button type="submit" class="btn" >Login</button>

      <div class="register-link">
        <p>Don't Have an Account?  <a href="Signup.html">Register</a></p>
      </div>
    </form>    
  </div>

<div id="notification" class="notification">
    <span class="close-btn" onclick="closeNotification()">&times;</span>
    Invalid login. Please try again.
</div>

<!-- JavaScript to display the notification and handle close -->
<script>
    // Function to show notification for invalid login
    window.onload = function() {
        var isInvalidLogin = <?php echo $is_invalid ? 'true' : 'false'; ?>;
        
        if (isInvalidLogin && !<?php echo isset($_SESSION["logged_in"]) ? 'true' : 'false'; ?>) {
            document.getElementById('notification').style.display = "block";
        }
    };
    
    // Function to close the notification
    function closeNotification() {
        document.getElementById('notification').style.display = "none";
    }
</script>

</body>
</html>








