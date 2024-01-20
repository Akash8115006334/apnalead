<?php
require '../../acm/SysFileAutoLoader.php';

if (isset($_SESSION['LOGIN_USER_ID'])) {
    LOCATION("info", "Welcome User, You are login in successfully!", DOMAIN . "/admin/index.php");
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo APP_NAME; ?> | Forget</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <?php include "../../assets/HeaderFilesLoader.php"; ?>
</head>

<body class="hold-transition login-page" style="background-image:url('<?php echo LOGIN_BG_IMAGE; ?>');background-size:cover;background-repeat:no-repeat;">
    <div class="login-box">
        <?php include "../../include/loader.php"; ?>

        <div class="card">
            <div class="card-header text-center">
                <img src="<?php echo APP_LOGO; ?>" class="img-fluid w-25"><br>
                <br>
                <a href="<?php echo DOMAIN; ?>" class="h5">Account verification required!</a>
            </div>
            <div class="card-body text-center">
                <h4><i class="fa fa-check-circle text-success"></i> Password Reset Link Sent!</h4>
                <hr>
                <p class="small"> Password Reset Link is sent successfully on submitted email id <b><?php echo $_SESSION['REQUESTED_EMAIL']; ?></b>. Change your password by following that link.</p>
                <br>
                <a href="<?php echo APP_URL; ?>" class="btn btn-block btn-dark"><i class='fa fa-angle-left'></i> Back to Login</a>
            </div>
            <hr class="bg-gray-600 opacity-2 mt-50px" />
            <?php include "../../include/login-footer.php"; ?>
        </div>

    </div>
    <?php include "../../assets/FooterFilesLoader.php"; ?>
</body>

</html>