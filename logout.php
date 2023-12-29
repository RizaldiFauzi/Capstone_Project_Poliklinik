<?php
include_once("koneksi.php");
session_start();
session_destroy();
header("location: login.php");
exit();
?>