<?php
require './common.php';
session_start();
setcookie('user_auth', '', time() -1);
session_destroy();
header("Location:./userlist.php");
