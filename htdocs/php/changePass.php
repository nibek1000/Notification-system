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
</center>
    </div> 

    <div class = "container form-signin">
        <?php
        if (!empty($_POST['Npassword']) && !empty($_POST['Opassword']) && !empty($_POST['user'])) {
            $connect = mysqli_connect("localhost", "root", "", "notification");

            if($connect === false){
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }

            $usr = $_POST["user"];

            $sql = "SELECT * FROM `users` WHERE `username` = '$usr'";

            $result = $connect->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $pass = password_verify($_POST['Opassword'], $row["password"]);

                    if ($pass == true) {
                        $pas1 = password_hash($_POST['Npassword'], PASSWORD_DEFAULT);
                        $sql1 = "UPDATE `users` SET `password` = '$pas1' WHERE `username` = '$usr'";
                        $result1 = $connect->query($sql1);
                        echo '<script>alert("password changed!"); window.open("../admin.php","_self");</script>';
                    }
                }
            }
        }
        ?>
    </div>
      
      
    <form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
        <div class="loginForm">
            Change password for user<br>
            <input type = "text" class = "inputLogin" name="user" placeholder = "login" required><br>
            <input type = "password" class = "inputLogin" name="Opassword" placeholder = "old Password" required><br>
            <input type = "password" class = "inputLogin" name="Npassword" placeholder = "new Password" required><br>
            <button class="Loginbutton" type = "submit" name="login">Change</button>
        </div>
    </form>
   </body>
</html>