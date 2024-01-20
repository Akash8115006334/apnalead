<?php
//initialize files
require "../../acm/SysFileAutoLoader.php";
require "../../acm/SystemReqHandler.php";

//admin login request

if (isset($_POST['LoginRequest'])) {
    $UserPassword = $_POST['UserPassword'];
    $UserEmailId = $_POST['UserEmailId'];
    $CheckUsername = CHECK("SELECT UserEmailId,UserPassword  FROM users where UserEmailId='$UserEmailId' and UserPassword='$UserPassword'");
    if ($CheckUsername == true) {
        //get user details
        $Sql = "SELECT UserId, UserFullName FROM users where UserEmailId='$UserEmailId' and UserStatus='1'";
        $UserId = FETCH($Sql, "UserId");
        $UserFullName = FETCH($Sql, "UserFullName");
        // $UserRole = FETCH($Sql, "UserRole");
        GENERATE_APP_LOGS("CP_SUCCESS", "New Login Received @ User : " . $UserEmailId . ", Pass : " . SECURE($UserPassword, "d",), "LOGIN");
        //open application 
        $_SESSION['APP_LOGIN_USER_ID'] = $UserId;
        LOCATION("success", "Welcome $UserFullName, Login Successful!", DOMAIN . "/app/index.php/");
    } else {
        GENERATE_APP_LOGS("CP_BLOCK", "New Login Received @ User : " . $UserEmailId . ", Pass : " . SECURE($UserPassword, "d"), "LOGIN");
        LOCATION("warning", "Please check your Email-Id and Password. They are incorrect, Please try again with valid Email-ID and Password!", "$access_url");
    }
    //search account for sending password reset link
} elseif (isset($_POST['SearchAccountForPasswordReset'])) {
    $UserEmailId = $_POST['UserEmailId'];
    $UserExits = CHECK("SELECT * FROM users where UserEmailId='$UserEmailId'");
    $CREATED_OTP = rand(111111, 999999);
    if ($UserExits != null) {
        $UserEmailId = FETCH("SELECT * FROM users where UserEmailId='$UserEmailId'", "UserEmailId");
        $PasswordResetRequestAuthToken = rand(111111, 999999) . "- Date - " . date("Y-m-d h:i:s a") . " For" . APP_NAME;
        $PasswordChangeTokenization = SECURE($PasswordResetRequestAuthToken, "e");
        $_SESSION['CREATED_OTP'] = $CREATED_OTP;
        $_SESSION['REQUESTED_EMAIL'] = $UserPhoneNumber;
        $UserId = FETCH("SELECT * from users where UserEmailId='$UserEmailId'", "UserId");

        //create Password reset Token with expire limit
        $PasswordReqData = array(
            "UserIdForPasswordChange" => FETCH("SELECT * from users where UserPhoneNumber='$UserPhoneNumber'", "UserEmailId"),
            "PasswordChangeTokenExpireTime" => date('d-m-Y H:i', strtotime("+10 min")),
            "PasswordChangeDeviceDetails" => SECURE(SYSTEM_INFO, "e"),
            "PasswordChangeToken" => $PasswordChangeTokenization,
            "PasswordChangeRequestStatus" => "Active"
        );
        //mail template data
        $Allowedto = SECURE($UserEmailId, "e");
        $PasswordResetLink = DOMAIN . "/auth/reset/?reset=true&token=$PasswordChangeTokenization&for=$Allowedto";
        $UpdatePreviousLinks = UPDATE("UPDATE user_password_change_requests SET PasswordChangeRequestStatus='Expired' where UserIdForPasswordChange='$UserId'");
        $Save = INSERT("user_password_change_requests", $PasswordReqData, false);

        //sent on mails
        $Mail = SENDMAILS("Password Reset Request Received!", "Verify Your Account!", $UserEmailId, "Your Password Reset Request is Received<br><br> You can change your password by clicking on the below link.<br><br> If this request is not sent by you then you may have to change your password immedietly.<br><br> $PasswordResetLink");

        //check mail status
        if ($Mail == true) {
            $access_url = DOMAIN . "/auth/verify/";
            LOCATION("success", "Password Change Link is sent on <b>$UserEmailId</b> Successfully!", "$access_url");
        } else {
            LOCATION("warning", "Unable to sent password reset link at the moment please try again after some time!", "$access_url");
        }
    } else {
        LOCATION("warning", "No any user is listed with " . $_POST['UserPhoneNumber'] . ". Please check entered email id", "$access_url");
    }

    //check account verification request

} elseif (isset($_POST['RequestForPasswordChange'])) {
    $Password1 = $_POST['Password1'];
    $Password2 = $_POST['Password2'];
    if ($Password1 != $Password2) {
        LOCATION("warning", "Password Mismatch!", "$access_url");
    } else {
        $UserEmailId = $_SESSION['REQUESTED_EMAIL_ID'];
        $PasswordChangeToken = $_SESSION['PASSWORD_RESET_TOKEN'];
        $UserExits = CHECK("SELECT * FROM users where UserEmailId='$UserEmailId'");
        if ($UserExits != null) {
            $update = UPDATE("UPDATE users SET UserPassword='$Password1' where UserEmailId='$UserEmailId'");
            if ($update == true) {
                SENDMAILS("PASSWORD CHANGED", "Your Password has been changed!", $UserEmailId, "Your Password has been changed successfully. <br> <br> Thank You.");
                GENERATE_APP_LOGS("PASSWORD-CHANGED", "Password changed for User : " . $UserEmailId . ", Pass : " . $Password2, "PASSWORD-RESET");
                //token and user email-id
                $_SESSION['REQUESTED_EMAIL_ID'] = null;
                $_SESSION['PASSWORD_RESET_TOKEN'] = null;

                //expired the used session
                $data = array(
                    "PasswordChangeRequestStatus" => "Expired",
                );
                $Update = UPDATE_TABLE("user_password_change_requests", $data, "PasswordChangeToken='$PasswordChangeToken'");

                //redirect to login page
                $access_url = DOMAIN . "/auth/login/";
                LOCATION("success", "Password Changed Successfully!", "$access_url");

                //check in case of incorrect
            } else {
                LOCATION("warning", "Unable to change password!", "$access_url");
            }
        } else {
            LOCATION("warning", "User Not Found at the time of Password Change Request, Please try again...", "$access_url");
        }
    }
}
//======== User signup account =============================================================

if (isset($_POST['SignupRequest'])) {

    $userEmail = $_POST['Email'];
    $userPhone = $_POST['Phone_Number'];
    $CheckEmail = CHECK("SELECT * FROM users where UserEmailId='$userEmail'");
    $error_url = DOMAIN . "/auth/signup/";
    if ($CheckEmail == false) {
        $CheckPhone = CHECK("SELECT * FROM users where UserPhoneNumber='$userPhone'");
        if ($CheckPhone == false) {
            // Data Inserting in Users Table 
            if ($_POST['Company_Name'] == null || $_POST['Industry'] == null) {
                LOCATION("warning", "Fill the Industry And Company Details Currectctly!", "$error_url");
            } else {
                $user = [
                    "UserSalutation" => "Mr./Mrs.",
                    "UserFullName" => $_POST['Full_Name'],
                    "UserPhoneNumber" => $userPhone,
                    "UserEmailId" => $userEmail,
                    "UserPassword" => $_POST['Password'],
                    "UserCreatedAt" => CURRENT_DATE_TIME,
                    "UserUpdatedAt" => CURRENT_DATE_TIME,
                    "UserStatus" => "1",
                    "UserCompanyName" => $_POST['Company_Name'],
                    "UserDepartment" => $_POST['Industry'],
                    "UserType" => "Admin",
                ];

                $USERS = INSERT("users", $user);
            }
            // RESPONSE($USERS, "Account Created Successfully", "Account Not Created");
            // Data Inserting in config_companies Table
            //Fetching the userId
            $User_Main_ID = FETCH("SELECT *  FROM users ORDER BY UserId  DESC LIMIT 1", 'UserId');

            $company = [
                "company_main_user_id" => $User_Main_ID,
                "company_name" => $_POST['Company_Name'],
                "company_created_at" => CURRENT_DATE_TIME,
                "company_created_by" => $User_Main_ID,
                "company_updated_at" => CURRENT_DATE_TIME,
                "company_updated_by" => $User_Main_ID,
                "company_status" => "1",
            ];
            $COMPANIES = INSERT("config_companies", $company);
            //Fetching the Company_ID
            $Company_Main_ID = FETCH("SELECT * FROM config_companies ORDER BY company_id   DESC LIMIT 1", 'company_id');

            // inserting in encripted_companies
            $CId = SECURE($Company_Main_ID, "e");
            $table = [
                "CompanyMainId" => $Company_Main_ID,
                "Enc_CompanyMainId" => $CId,
            ];
            $save = INSERT("encripted_companies", $table);
            // inserting data in company users
            $companyuser = [
                "company_main_id" => $Company_Main_ID,
                "company_alloted_user_id" => $User_Main_ID,
                "company_user_role" => "Admin",
                "company_user_status" => "1",
                "company_user_created_at" => CURRENT_DATE_TIME,
                "company_user_created_by" => $User_Main_ID,
            ];
            $companyUsersSql = INSERT("company_users", $companyuser);
            $emails = [
                "company_main_id" =>  $Company_Main_ID,
                "company_email_name" => $_POST['Company_Name'],
                "company_email_id" => $userEmail,
            ];
            $EMAILS = INSERT("company_emails", $emails);

            //Inserting data in companies_phone_number Table
            // fetching the user name and phone number from users table 

            $UserName = _DB_COMMAND_("SELECT * FROM config_companies INNER JOIN users ON config_companies.company_main_user_id = users.UserId  WHERE company_id ='$Company_Main_ID'", true);
            foreach ($UserName as $Name) {
                $UserFullName = $Name->UserFullName;
                $User_Phone = $Name->UserPhoneNumber;
            }
            $phone_number = [
                "company_main_id" =>  $Company_Main_ID,
                "company_phone_person_name" =>  $UserFullName,
                "company_phone_number" =>  $User_Phone,
            ];
            $Phone = INSERT("company_phone_numbers", $phone_number);
            if ($Phone == true) {
                $access_url = APP_URL . "/UserPlan/";
                //open application 
                $_SESSION['APP_LOGIN_USER_ID'] = $User_Main_ID;
            }

            // Auto Inserson of Required Data start

            $FetchDefault = _DB_COMMAND_("SELECT * FROM configs", true);
            if ($_POST['Industry'] == 'RealEstate') {
                $LeadCall = ["INFORMATION SHARED", "REGISTRATIONS DONE", "SITE VISIT PLANNED", "SITE VISIT DONE", "MEETING PLANNED", "FOLLOW-UP"];
            } else if ($_POST['Industry'] == 'IT Services') {
                $LeadCall = ["INFORMATION SHARED", "MEETING PLANNED", "MEETING DONE", "MEETING CANCEL", "APPROVAL PENDING", "APPROVED", "FOLLOW-UP"];
            } else {
                $LeadCall = ["INFORMATION SHARED", "MEETING PLANNED", "FOLLOW-UP"];
            }

            foreach ($FetchDefault as $DefaultValue) {
                $CinfigID = $DefaultValue->ConfigsId;

                if ($CinfigID == 1) {
                    $group = ["Team A", "Team B", "Team C"];
                    foreach ($group as $team) {
                        $workgroup = [
                            "ConfigValueGroupId" => "1",
                            "ConfigValueDetails" => $team,
                            "ConfigReferenceId" => "",
                            "CompanyID" => $Company_Main_ID,
                        ];

                        $ConfigDefaultSql = INSERT("config_values", $workgroup);
                    }
                } elseif ($CinfigID == 6) {
                    $LeadLevel = ["HIGH", "MEDIUM", "LOW"];
                    foreach ($LeadLevel as $level) {
                        $LeadPriority = [
                            "ConfigValueGroupId" => "6",
                            "ConfigValueDetails" => $level,
                            "ConfigReferenceId" => "",
                            "CompanyID" => $Company_Main_ID,
                        ];

                        $ConfigDefaultSql = INSERT("config_values", $LeadPriority);
                    }
                } elseif ($CinfigID == 7) {
                    foreach ($LeadCall as $call) {
                        $LeadCall = [
                            "ConfigValueGroupId" => "7",
                            "ConfigValueDetails" => $call,
                            "ConfigReferenceId" => "",
                            "CompanyID" => $Company_Main_ID,
                        ];

                        $ConfigDefaultSql = INSERT("config_values", $LeadCall);
                    }
                } elseif ($CinfigID == 9) {
                    $LeadSources = ["Facebook", "Instagram", "Google Ads", "Trade India", "India Mart", "Self", "Other"];
                    foreach ($LeadSources as $Source) {
                        $LeadSourcesArray = [
                            "ConfigValueGroupId" => "9",
                            "ConfigValueDetails" => $Source,
                            "ConfigReferenceId" => "",
                            "CompanyID" => $Company_Main_ID,
                        ];

                        $ConfigDefaultSql = INSERT("config_values", $LeadSourcesArray);
                    }
                } elseif ($CinfigID == 14) {
                    $LeadSources = ["Facebook", "Instagram", "Google Ads", "Trade India", "India Mart", "Self", "Other"];
                    foreach ($LeadSources as $Source) {
                        $LeadSourcesArray = [
                            "ConfigValueGroupId" => "9",
                            "ConfigValueDetails" => $Source,
                            "ConfigReferenceId" => "",
                            "CompanyID" => $Company_Main_ID,
                        ];

                        $ConfigDefaultSql = INSERT("config_values", $LeadSourcesArray);
                    }
                }
            }
            RESPONSE($Phone, "Account Created Successfully", "Account Not Created");
        } else {
            $_SESSION['signup_error2'] = "Phone Number Already Taken!";
            $_SESSION['signup_full_name'] = $_POST['Full_Name'];
            $_SESSION['signup_company_name'] = $_POST['Company_Name'];
            $_SESSION['signup_phone_number'] = $_POST['Phone_Number'];
            $_SESSION['signup_email'] = $_POST['Email'];
            $_SESSION['signup_industry'] = $_POST['Industry'];
            $_SESSION['signup_password'] = $_POST['Password'];
            LOCATION("warning", "Mobile Number Already Taken!", "$error_url");
        }
    } else {
        $_SESSION['signup_error1'] = "Email Already Taken!";
        $_SESSION['signup_full_name'] = $_POST['Full_Name'];
        $_SESSION['signup_company_name'] = $_POST['Company_Name'];
        $_SESSION['signup_phone_number'] = $_POST['Phone_Number'];
        $_SESSION['signup_email'] = $_POST['Email'];
        $_SESSION['signup_industry'] = $_POST['Industry'];
        $_SESSION['signup_password'] = $_POST['Password'];
        LOCATION("warning", "Email Already Taken!", "$error_url");
    }
}
