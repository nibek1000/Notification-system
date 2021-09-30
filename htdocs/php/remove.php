<?php
$connect = mysqli_connect("localhost", "root", "", "notification");

if($connect === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$urlPath = $_SERVER["REQUEST_URI"];

$id = array_slice(explode('/', rtrim($urlPath, '/')), -1)[0];

$sql = "DELETE FROM `notifications` WHERE `notifications`.`id` = $id";

$result = $connect->query($sql);

echo '<script>alert("notification removed"); 
window.open("../admin.php","_self");
</script>';
?>