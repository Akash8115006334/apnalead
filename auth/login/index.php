<?php
require '../../acm/SysFileAutoLoader.php';
if (isset($_SESSION['APP_LOGIN_USER_ID'])) {
    LOCATION("info", "Welcome <b>" . AuthAppUser("UserFullName") . "</b>, You are login in successfully!", APP_URL);
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo APP_NAME; ?> | Login</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <?php include "../../assets/HeaderFilesLoader.php"; ?>
</head>

<body>
    <div class="row m-0 ">
        <div class="col-md-4 left-side p-0 signup-box" style="background-image: url('<?php echo LOGIN_BG_IMAGE; ?>');">
            <div class="color col-md-12 p-0 text-center">
                <a href="#" target="_blank"><img src="<?php echo APP_LOGO_2; ?>" class="mt-5" alt=""></a>
                <div class="left-side-content ">
                    <span>
                        <h2 class="text-light fs-50">Sales Automation</h2>
                        <p class="text-light content-justify">Effortless sales, automated success with ApnaLead.</p>
                        <ul class="text-justify mt-3">
                            <li class="text-light bold"><span class="fs0">D</span>ata Encryption</li>
                            <li class="text-light bold">Regular Performance Reviews</li>
                            <li class="text-light bold">Feedback Mechanism</li>
                            <li class="text-light bold">Task Prioritization</li>
                        </ul>
                    </span>

                </div>
                <div class=" col-md-12 carousal mt-4">
                    <h5 class="text-light">Trusted By :</h5>
                    <div class="col-md-12 carousal-box">
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-8 sign-up-box p-0">
            <div class="contact-btn mb-5 d-flex">
                <p class="text-dark">Having Issue Please? <a href="#" class="Apnalead-btn text-primary">Contact-Us</a></p>
            </div>
            <div class="col-md-8 right-side signup-form p-0 mt-5">
                <h3>LOGIN</h3>
                <hr>
                <form action="<?php echo DOMAIN; ?>/handler/AuthController/AuthController.php" method="POST" class="form-group ">
                    <?php FormPrimaryInputs(true); ?>
                    <div class="col-md-12 input-box">
                        <input type="email" name="UserEmailId" required id="" placeholder="Enter Your Email*">
                    </div>
                    <div class="col-md-12 input-box">
                        <input type="password" name="UserPassword" required id="" placeholder="Password">
                    </div>
                    <div class="mb-5px text-dark p-2 pl-4 small"> Forget Password?
                        <a href="<?php echo DOMAIN; ?>/auth/forget/" class="text-primary">Create New Password</a>
                    </div>
                    <div class="col-md-12 input-box">
                        <button type="submit" name="LoginRequest" class="Login-btn"><i class="fa fa-lock text-white"></i> Secured Login</button>
                    </div>
                    <div class="col-md-12 mt-3 text-center">
                        <small>Don't Have An Account Please <a href="./../signup/index.php"> SignUp</a></small>
                    </div>
                </form>
                <div class="footer mt-5 mb-1">
                    <?php include "../../include/login-footer.php"; ?>
                </div>
            </div>
        </div>
    </div>
    <?php include "../../assets/FooterFilesLoader.php"; ?>
</body>

</html>