<?php
echo "logging out...";
session_start();
session_unset();
session_destroy();
header("Location: login.php");
exit();
?>
