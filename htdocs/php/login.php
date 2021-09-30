<?php
   ob_start();
   ini_set('session.gc_maxlifetime', 1800);
   session_set_cookie_params(1800);
   session_start();
   $czyZalogowany = isset($_SESSION["loggedIn"]);
   if(!$czyZalogowany){
      header("Location: index.php");
   }
   echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';

?>

<html lang = "en">
   <body>
        <title>Notification system</title>
   <link rel="stylesheet" type="text/css" href="../style/style.css">

    <div class="topDiv">
        <center>Notification system</center>
    </div> 

    <div class = "container form-signin">
        <?php
        $msg = '';
        
        if (!empty($_POST['password'])) {
            $connect = mysqli_connect("localhost", "root", "", "notification");

            if($connect === false){
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }

            $haslo = password_hash($_POST['password'], PASSWORD_DEFAULT);
            echo '<script>console.log("'.$haslo.'")</script>';


            $sql = "SELECT * FROM `users`";

            $result = $connect->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $pass = password_verify($_POST['password'], $row["password"]);
                    $username = $_POST["username"];

                    if ($pass == true && $row["username"] == $username) {
                        $_SESSION["loggedInAdmin"] = "1";

                        header("Location: admin.php");
                    }else {
                        $msg = 'Password or username incorrect';
                    }
                }
            }
        }
        ?>
    </div>
      
      
    <form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
        <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
    
        <div class="loginForm">
            Log in to notification system - admin panel<br>
            <input type = "pext" class = "inputLogin" name = "username" placeholder = "username" required><br>
            <input type = "password" class = "inputLogin" name = "password" placeholder = "password" required><br>
            <button class="Loginbutton" type = "submit" name = "login">Log in</button>
        </div>
    </form>
   </body>
</html>