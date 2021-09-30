<?php
   ob_start();
   ini_set('session.gc_maxlifetime', 1800);
   session_set_cookie_params(1800);
   session_start();
   $czyZalogowany = isset($_SESSION["loggedInAdmin"]);
   if(!$czyZalogowany){
      header("Location: notification.php");
   }
   echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';

?>

<html lang = "en">
   <body>
        <title>Notification system</title>
   <link rel="stylesheet" type="text/css" href="../style/style.css">

    <div class="topDiv"><center>
        Notification system<br>
        <button onclick="window.open('admin.php','_self')">Go back</button>
</center></div> 

    <div class = "container form-signin">
        <?php
        if(isset($_POST["pass"])){
            $connect = mysqli_connect("localhost", "root", "", "notification");

            if($connect === false){
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }

            $pas = password_hash($_POST['pass'], PASSWORD_DEFAULT);

            $sql = "UPDATE `mainpassword` SET `password` = '$pas' WHERE 1";

            $result = $connect->query($sql);

            echo '<script>alert("password changed"); 
            window.open("../admin.php","_self");
            </script>';
        }
        ?>
    </div>
      
      
    <form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
        <div class="loginForm">
            Change master password<br>
            <input type = "password" class = "inputLogin" name = "pass" placeholder = "New master password" required><br>
            <button class="Loginbutton" type = "submit" name = "send">Change</button>
        </div>
    </form>
   </body>
</html>