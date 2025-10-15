<?php
session_start();
session_destroy();
echo "logging you out please wait........";
header("location: /idiscuss/index.php");


?>