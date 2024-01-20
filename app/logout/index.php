<?php
session_destroy();

unset($_COOKIE['remember_user']);
setcookie("APP_LOGIN_USER_ID", null, -1, "/");

//require files
require '../../acm/SysFileAutoLoader.php';

header("location: " . DOMAIN);
