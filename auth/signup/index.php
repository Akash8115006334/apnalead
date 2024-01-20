<?php
require '../../acm/SysFileAutoLoader.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo APP_NAME; ?> | SignUp</title>
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
            </div>
        </div>
        <div class="col-md-8 sign-up-box p-0">
            <div class="contact-btn mt-3 d-flex">
                <p class="text-dark">Discover more with a demo <a href="https://demo.apnalead.com/auth/login/" class="Apnalead-btn text-primary">Get Started</a></p>
            </div>
            <div class=" col-md-12 col-sm-12 signup-form ">
                <h3>SIGN-UP</h3>
                <hr>

                <form action="<?php echo CONTROLLER; ?>/AuthController/AuthController.php" method="POST" class="form-group ">
                    <?php FormPrimaryInputs(true); ?>
                    <div class="row">
                        <div class="col-md-6 input-box">
                            <input type="text" name="Full_Name" id="Full_Name" placeholder="Your Name*" value="<?php echo isset($_SESSION['signup_full_name']) ? $_SESSION['signup_full_name'] : ''; ?>" required>
                        </div>
                        <div class=" col-md-6 input-box">
                            <input type="text" name="Company_Name" id="Company_Name" placeholder="Company Name*" value="<?php echo isset($_SESSION['signup_company_name']) ? $_SESSION['signup_company_name'] : ''; ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-md-6 input-box">
                            <input type="tel" name="Phone_Number" id="Phone_Number" placeholder="Mobile Number*" value="<?php echo isset($_SESSION['signup_phone_number']) ? $_SESSION['signup_phone_number'] : ''; ?>" required><br>
                            <span> <?php echo "" . isset($_SESSION['signup_error2']) ? $_SESSION['signup_error2'] : '' . ""; ?></span>
                        </div>
                        <div class="col-md-6 input-box">
                            <select name="Industry" id="Industry" class="form-select" value="<?php echo isset($_SESSION['signup_industry']) ? $_SESSION['signup_industry'] : ''; ?>" required>
                                <?php
                                echo '<option disabled selected>Industry Type*</option>';
                                InputOptions(Industry, "");  APP_URL?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 input-box">
                            <input type="email" name="Email" id="Email" placeholder="Your Email*" value="<?php echo isset($_SESSION['signup_email']) ? $_SESSION['signup_email'] : ''; ?>" required><br>
                            <span> <?php echo "" . isset($_SESSION['signup_error1']) ? $_SESSION['signup_error1'] : '' . ""; ?></span>

                        </div>
                        <div class=" col-md-6 input-box">
                            <div class="pass" id="pass">
                                <input type="password" name="Password" id="Password" class="Password" placeholder=" Password" value="<?php echo isset($_SESSION['signup_password']) ? $_SESSION['signup_password'] : ''; ?>" required>
                                <img src="./../../storage/image/eye-close.png" alt="eyelogo" id="eyeicon-1">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 checkbox my-3 ">
                        <input type="checkbox" name="agree" value="yes" id="agreeCheckbox">
                        I agree to the <a href="https://apnalead.com/" target="_blank" class="text-info">Privacy Policy </a> , <a href="https://apnalead.com/" target="_blank" class="text-info">Refund Policy</a> and <a href="https://apnalead.com/" target="_blank" class="text-info">Terms and Conditions</a>
                        of Navix Consultancy Services
                    </div>
                    <div class="col-md-12 input-box">
                        <button type="submit" disabled name="SignupRequest" class="Login-btn disabled-button" id="submitButton"> Secured SignUp</button>
                    </div>

                    <div class="col-md-12  text-center">
                        <small>Have An Account Please <a href="./../login/index.php"> Login</a></small>
                    </div>
                </form>
                <div class="footer">
                    <?php include "../../include/login-footer.php"; ?>
                </div>
            </div>
        </div>
    </div>


    <?php include "../../assets/FooterFilesLoader.php";
    unset($_SESSION['signup_error1']);
    unset($_SESSION['signup_error2']);
    unset($_SESSION['signup_full_name']);
    unset($_SESSION['signup_company_name']);
    unset($_SESSION['signup_email']);
    unset($_SESSION['signup_phone_number']);
    unset($_SESSION['signup_industry']);
    unset($_SESSION['signup_password']);
    ?>
    <script>
        const agreeCheckbox = document.getElementById("agreeCheckbox");
        const submitButton = document.getElementById("submitButton");

        agreeCheckbox.addEventListener("change", function() {
            if (agreeCheckbox.checked) {
                submitButton.disabled = false;
                submitButton.classList.remove("disabled-button");
                submitButton.type = "submit";
            } else {
                submitButton.disabled = true;
                submitButton.classList.add("disabled-button");
                submitButton.type = "button";
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const eyeicon = document.getElementById("eyeicon-1");
            const password = document.querySelector("#Password");

            eyeicon.addEventListener('click', function() {
                if (password.type === "password") {
                    password.type = "text";
                    eyeicon.src = "./../../storage/image/eye-open.png";
                } else {
                    password.type = "password";
                    eyeicon.src = "./../../storage/image/eye-close.png";
                }
            });
        });
    </script>
</body>

</html>