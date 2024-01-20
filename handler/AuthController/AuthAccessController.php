<?php
if (!isset($_SESSION['APP_LOGIN_USER_ID'])) {
    header("location:" . DOMAIN . "/auth/");
} else {
    define("LOGIN_USER_ID", $_SESSION['APP_LOGIN_USER_ID']);
}


// fetch Company Id
$UserId = $_SESSION['APP_LOGIN_USER_ID'];
$companyid = FETCH("SELECT * FROM  config_companies WHERE company_main_user_id='$UserId'", "company_id");
define("APP_COMPANY_ID", $companyid);
$CompanyId = FETCH("SELECT * FROM company_users where company_alloted_user_id='$UserId'", "company_main_id");
define("CompanyId", $CompanyId);
