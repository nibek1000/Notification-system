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
<html>
<title>Notification system</title>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<div class="topDiv"><center>
        Notification system<br>
        <button onclick="window.open('login.php','_self')">Log in to admin</button>
        <button onclick="window.open('logout.php','_self')">Lock</button>
</center></div> 

<form class = "form-signin" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post">
    <div class="FilterForm">
        Filters<br>
        <input type = "text" class = "inputLogin" name = "who" placeholder = "Who"><br>
        Notification date:<br>
        <input type = "date" class = "inputLogin" name = "date" placeholder = "Since when"><br>
        <button class="Loginbutton" type = "submit" name = "filter">Filter</button>
    </div>
</form>


<table border="1px">
<tr class="first"><th class="who">Who</th><th class="des">Description</th><th class="since">Since when</th><th class="till">Till when</th></tr>
<?php
$connect = mysqli_connect("localhost", "root", "", "notification");

if($connect === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql = "SELECT * FROM `notifications`";

$where = 0;

if (!empty($_POST['date'])) {
    if($where == 0){
        $sql = $sql. " WHERE `EndingDate` >= '". $_POST["date"] ."' AND `StartingDate` <= '". $_POST["date"] ."'";
        $where = 1;
    }else{
        $sql = $sql. " AND `EndingDate` >= '". $_POST["date"] ."' AND `StartingDate` <= '". $_POST["date"] ."'";
    }
}

if (!empty($_POST['who'])) {
    if($where == 0){
        $sql = $sql. " WHERE `Who` LIKE '%". $_POST["who"]."%'";
        $where = 1;
    }else{
        $sql = $sql. " AND `Who` LIKE '%". $_POST["who"]."%'";
    }
}

$result = $connect->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<tr><th>'. $row["Who"]. '</th><th>'. $row["Description"]. '</th><th>'. $row["StartingDate"]. '</th><th>'. $row["EndingDate"]. '</th></tr>';
    }
}
?>
</table>

</html>
