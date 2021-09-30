<?php
session_start();
setcookie(session_name(), '', 100);
session_unset();
session_destroy();
$_SESSION = array();
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';

echo '
<link rel="stylesheet" href="style.css">
<script>
window.open("../index.php", "_self");
</script>
';
?>