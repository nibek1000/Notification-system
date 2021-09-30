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
        if(isset($_POST["who"])){
            $connect = mysqli_connect("localhost", "root", "", "notification");

            if($connect === false){
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }

            $s = $_POST["Sdate"];
            $e = $_POST["Edate"];
            $w = $_POST["who"];
            $d = $_POST["des"];

            $sql = "INSERT INTO `notifications` (`id`, `StartingDate`, `EndingDate`, `Who`, `Description`) 
                    VALUES (NULL, '$s', '$e', '$w', '$d');";

            $result = $connect->query($sql);

            echo '<script>alert("notification added"); 
            window.open("admin.php","_self");
            </script>';
        }
        ?>
    </div>
      
      
    <form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
        <div class="loginForm">
            Add new notification<br><br>
            <input type = "date" class = "inputSpecialDate" name = "Sdate"required>
            To <input type = "date" class = "inputSpecialDate" name = "Edate"required><br>
            <input type = "who" class = "inputLogin" name = "who" placeholder = "Who" required><br>
            <input type = "description" class = "inputLogin" name = "des" placeholder = "Description" required><br>
            <button class="Loginbutton" type = "submit" name = "send">Add</button>
        </div>
    </form>
   </body>
</html>