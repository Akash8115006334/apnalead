<?php
//update profile image 
if (isset($_POST['updateprofileimage'])) {
    $UserId  = $_POST['updateprofileimage'];
    $UserProfileImage = UPLOAD_FILES("../storage/users/$UserId/img", "null", "Profile_Photo_" . "_UID_" . $UserId, "UserProfileImage");
    $Update = UPDATE("UPDATE users SET UserProfileImage='$UserProfileImage' where UserId='$UserId'");
    RESPONSE($Update, "Profile Image Updated!", "Unable to update profile image!");

    //remove employee
} else if (isset($_GET['remove_team_member'])) {
    $access_url = SECURE($_GET['access_url'], "d");
    $remove_team_member = SECURE($_GET['remove_team_member'], "d");

    if ($remove_team_member == true) {
        $control_id = SECURE($_GET['control_id'], "d");
        $delete = DELETE_FROM("users", "UserId='$control_id'");
        $delete = DELETE_FROM("user_addresses", "UserAddressUserId='$control_id'");
        $delete = DELETE_FROM("user_bank_details", "UserMainId='$control_id'");
        $delete = DELETE_FROM("user_documents", "UserMainId='$control_id'");
        $delete = DELETE_FROM("user_employment_details", "UserMainUserId='$control_id'");
    } else {
        $delete = false;
    }

    RESPONSE($delete, "Team member is removed successfully!", "Unable to remove team member!");

    //update primary data
} elseif (isset($_POST['UpdatePrimaryData'])) {
    $UserId = SECURE($_POST['UserId'], "d");

    $primarydata = array(
        "UserSalutation" => $_POST['UserSalutation'],
        "UserFullName" => $_POST['UserFullName'],
        "UserPhoneNumber" => $_POST['UserPhoneNumber'],
        "UserEmailId" => $_POST['UserEmailId'],
        "UserUpdatedAt" => CURRENT_DATE_TIME,
        "UserStatus" => $_POST['UserStatus'],
        "UserNotes" => POST("UserNotes"),
        "UserType" => $_POST['UserType'],
        "UserDateOfBirth" => $_POST['UserDateOfBirth'],
    );

    $Update = UPDATE_TABLE("users", $primarydata, "UserId='$UserId'");
    RESPONSE($Update, $_POST['UserFullName'] . " profile is updated successfully!", "Unable to update profile at the moment!");

    //update address
} elseif (isset($_POST['UpdateAddress'])) {
    $UserId = SECURE($_POST['UserId'], "d");

    $Address = array(
        "UserAddressUserId" => $UserId,
        "UserStreetAddress" => POST("UserStreetAddress"),
        "UserLocality" => $_POST['UserLocality'],
        "UserCity" => $_POST['UserCity'],
        "UserState" => $_POST['UserState'],
        "UserCountry" => $_POST['UserCountry'],
        "UserPincode" => $_POST['UserPincode'],
        "UserAddressType" => $_POST['UserAddressType'],
        "UserAddressContactPerson" => $_POST['UserAddressContactPerson'],
    );

    $CheckAddress = CHECK("SELECT * FROM user_addresses where UserAddressUserId='$UserId'");
    if ($CheckAddress == null) {
        $Update = INSERT("user_addresses", $Address);
    } else {
        $Update = UPDATE_TABLE("user_addresses", $Address, "UserAddressUserId='$UserId'");
    }
    RESPONSE($Update, "Address details are updated successfully!", "Unable to update address details at the moment!");

    //update employment details
} elseif (isset($_POST['UpdateEmployement'])) {
    $UserId = SECURE($_POST['UserId'], "d");

    $EmpDetails = array(
        "UserMainUserId" => $UserId,
        "UserEmpBackGround" => $_POST['UserEmpBackGround'],
        "UserEmpTotalWorkExperience" => $_POST['UserEmpTotalWorkExperience'],
        "UserEmpPreviousOrg" => $_POST['UserEmpPreviousOrg'],
        "UserEmpBloodGroup" => '',
        "UserEmpReraId" => $_POST['UserEmpReraId'],
        "UserEmpReportingMember" => $_POST['UserEmpReportingMember'],
        "UserEmpJoinedId" => $_POST['UserEmpJoinedId'],
        "UserEmpCRMStatus" => $_POST['UserEmpCRMStatus'],
        "UserEmpVisitingCard" => $_POST['UserEmpVisitingCard'],
        "UserEmpWorkEmailId" => $_POST['UserEmpWorkEmailId'],
        "UserEmpGroupName" => $_POST['UserEmpGroupName'],
        "UserEmpType" => $_POST['UserEmpType'],
        "UserEmpLocations" => '',
        "UserEmpRoleStatus" => $_POST['UserEmpRoleStatus'],
    );

    $CheckEMp = CHECK("SELECT * FROM user_employment_details where UserMainUserId='$UserId'");
    if ($CheckEMp == null) {
        $Update = INSERT("user_employment_details", $EmpDetails);
    } else {
        $Update = UPDATE_TABLE("user_employment_details", $EmpDetails, "UserMainUserId='$UserId'");
    }
    $UserProjectType = [
        "User_main_id" =>  $UserId,
        "User_project_main_Id" => $_POST["Project_Name"],
        "User_project_updated_at" => CURRENT_DATE_TIME,
        "CompanyId" => CompanyId,
    ];
    $CheckUserProject = CHECK("SELECT * FROM user_project_type where User_main_Id='$UserId'");
    if ($CheckUserProject == null) {
        $UpdateUserProject = INSERT("user_project_type", $UserProjectType);
    } else {
        $UpdateUserProject = UPDATE_TABLE("user_project_type", $UserProjectType, "User_main_Id='$UserId'");
    }
    RESPONSE($Update, "Employement details are updated successfully!", "Unable to update Employement details at the moment!");

    //update bank details
} else if (isset($_POST['UpdateBankDetails'])) {
    $UserId = SECURE($_POST['UserId'], "d");
    $BANKDETAILS = array(
        "UserMainId" => $UserId,
        "UserBankName" => $_POST['UserBankName'],
        "UserBankAccountNo" => $_POST['UserBankAccountNo'],
        "UserBankIFSC" => $_POST['UserBankIFSC'],
        "UserBankAccoundHolderName" => $_POST['UserBankAccoundHolderName'],
    );
    $CheckEMp = CHECK("SELECT * FROM user_bank_details where UserMainId='$UserId'");
    if ($CheckEMp == null) {
        $Update = INSERT("user_bank_details", $BANKDETAILS);
    } else {
        $Update = UPDATE_TABLE("user_bank_details", $BANKDETAILS, "UserMainId='$UserId'");
    }
    RESPONSE($Update, "Bank Account details are updated successfully!", "Unable to update Bank Account details at the moment!");
    //upload documents
} elseif (isset($_POST['UploadDocuments'])) {
    $UserId = SECURE($_POST['UserId'], "d");
    $documents = array(
        "UserMainId" => $UserId,
        "UserDocumentNo" => $_POST['UserDocumentNo'],
        "UserDocumentName" => $_POST['UserDocumentName'],
        "UserDocumentFile" => UPLOAD_FILES("../storage/teams/documents/$UserId", "null", "PanCard", "UserDocumentFile"),
    );
    $Update = INSERT("user_documents", $documents);
    RESPONSE($Update, "Documents are uploaded successfully!", "Unable to upload documents at the moment!");
    //remove documents
} elseif (isset($_GET['remove_user_documents'])) {
    $access_url = SECURE($_GET['access_url'], "d");
    $remove_user_documents = SECURE($_GET['remove_user_documents'], "d");
    if ($remove_user_documents == true) {
        $control_id = SECURE($_GET['control_id'], "d");
        $delete = DELETE_FROM("user_documents", "UserDocsId='$control_id'");
    } else {
        $delete = false;
    }
    RESPONSE($delete, "Document is removed successfully!", "Unable to remove documents at the moment!");
    //update password
} elseif (isset($_POST['UpdatePassword'])) {
    $UserId = SECURE($_POST['UserId'], "d");
    $data = array(
        "UserPassword" => $_POST['UserPassword'],
    );
    $Update = UPDATE_TABLE("users", $data, "UserId='$UserId'");
    RESPONSE($Update, "Password is updated successfully!", "Unable to update password at the moment!");

    //create users

} elseif (isset($_POST['SaveCustomer'])) {
    // checking email and phone numbers
    $CheckifPhone = CHECK("SELECT * FROM users where UserPhoneNumber='" . $_POST['UserPhoneNumber'] . "'");
    $CheckifMail = CHECK("SELECT * FROM users where UserEmailId='" . $_POST['UserEmailId'] . "'");
    if ($CheckifPhone != null) {;
        LOCATION("warning", "Phone Number is already registered!", $access_url);
    } elseif ($CheckifMail != null) {
        LOCATION("warning", "Email-id is already registered", $access_url);
    } else {

        $CompanyAdmin = $_SESSION['APP_LOGIN_USER_ID']; //Admin who creates the users
        $FetchCompanySql = "SELECT * FROM users WHERE UserId='$CompanyAdmin'";
        $CompanyName = FETCH($FetchCompanySql, "UserCompanyName");
        $UserDepartment = FETCH($FetchCompanySql, "UserDepartment");
        $users = [
            "UserSalutation" => "Mr/Mrs.",
            "UserFullName" => $_POST["user_full_name"],
            "UserPhoneNumber" => $_POST['UserPhoneNumber'],
            "UserEmailId" => $_POST['UserEmailId'],
            "UserCreatedAt" => CURRENT_DATE_TIME,
            "UserUpdatedAt" => CURRENT_DATE_TIME,
            //"UserNotes" => SECURE($_POST['UserNotes'], "e"),
            "UserStatus" => "1",
            "UserCompanyName" =>  $CompanyName,
            "UserDepartment" => $UserDepartment,
            "UserCreatedAt" => date("d-m-Y h:m"),
            "UserPassword" => rand(11111, 999999),
            "UserType" => $_POST["UserType"],
            //"UserDateOfBirth" => $_POST['UserDateOfBirth'],
        ];
        $CountDigitalUser = TOTAL("SELECT * FROM company_users WHERE company_user_created_by='$CompanyAdmin' and company_user_role='digital' and company_user_status='1'");
        if ($_POST["UserType"] == "Digital" && $CountDigitalUser >= MAXIMUM_DIGITAL_USER) {
            LOCATION("warning", "Maximum Two Digital Allowed!", $access_url);
        } else {
            $Save = INSERT("users", $users);
        }
    }

    //GET registered customer id 
    $number = $_POST['UserPhoneNumber'];
    $email = $_POST['UserEmailId'];
    $UserAddressUserId = FETCH("SELECT * FROM users where UserPhoneNumber='$number' AND UserEmailId='$email' ORDER BY UserId DESC limit 1", "UserId");
    $UserAddressUserPass = FETCH("SELECT * FROM users where UserPhoneNumber='$number' AND UserEmailId='$email' ORDER BY UserId DESC limit 1", "UserPassword");
    //save other details
    $UserId = $UserAddressUserId;
    $UserPassword =  $UserAddressUserPass;
    $EmpDetails = array(
        "UserMainUserId" => $UserId,
        "UserEmpReportingMember" => $_POST['UserEmpReportingMember'],
        "UserEmpGroupName" => $_POST['UserEmpGroupName'],
    );
    $CheckEMp = CHECK("SELECT * FROM user_employment_details where UserMainUserId='$UserId'");
    if ($CheckEMp == null) {
        $Update = INSERT("user_employment_details", $EmpDetails);
    } else {
        $Update = UPDATE_TABLE("user_employment_details", $EmpDetails, "UserMainUserId='$UserId'");
    }
    // GET comapny id from config_companies
    $GetComapnyID = FETCH("SELECT * FROM config_companies where company_main_user_id='$CompanyAdmin'", "company_id");
    $CompanyUsers = [
        "company_main_id" => $GetComapnyID,
        "company_alloted_user_id" => $UserId,
        "company_user_role" => $_POST["UserType"],
        "company_user_status" => "1",
        "company_user_created_at" => CURRENT_DATE_TIME,
        "company_user_created_by" => $CompanyAdmin,
    ];
    $CountDigitalUser = TOTAL("SELECT * FROM company_users WHERE company_user_created_by='$CompanyAdmin' and company_user_role='digital' and company_user_status='1'");
    if ($_POST["UserType"] == "Digital" && $CountDigitalUser >= MAXIMUM_DIGITAL_USER) {
        LOCATION("warning", "Maximum Two Digital Allowed!", $access_url);
    } else {
        $companyUser = INSERT("company_users", $CompanyUsers);
    }
    //Add User Project Type

    $UserProjectType = [
        "User_main_Id" => $UserId,
        "User_project_main_Id" => $_POST["Project_Name"],
        "User_project_created_at" => CURRENT_DATE_TIME,
        "User_project_updated_at" => CURRENT_DATE_TIME,
        "User_project_type_id" => "",
        "CompanyId" => $GetComapnyID,
    ];
    $UserProject = INSERT("user_project_type", $UserProjectType);

    // $EmpDetails = array(
    //     "UserMainUserId" => $UserId,
    //     "UserEmpBackGround" => $_POST['UserEmpBackGround'],
    //     "UserEmpTotalWorkExperience" => $_POST['UserEmpTotalWorkExperience'],
    //     "UserEmpPreviousOrg" => $_POST['UserEmpPreviousOrg'],
    //     "UserEmpBloodGroup" => $_POST['UserEmpBloodGroup'],
    //     "UserEmpReportingMember" => $_POST['UserEmpReportingMember'],
    //     "UserEmpJoinedId" => $_POST['UserEmpJoinedId'],
    //     "UserEmpWorkEmailId" => $_POST['UserEmpWorkEmailId'],
    // );
    // $Check = CHECK("SELECT * FROM user_employment_details where UserMainUserId='$UserId'");
    // if ($Check == null) {
    //     $SaveEmp = INSERT("user_employment_details", $EmpDetails);
    // }
    // $PanCard = array(
    //     "UserMainId" => $UserId,
    //     "UserDocumentNo" => $_POST['PancardNo'],
    //     "UserDocumentName" => "PAN CARD",
    //     "UserDocumentFile" => UPLOAD_FILES("../storage/teams/documents/$UserId", "null", "PanCard", "PancardFile"),
    // );
    // $SAVEPAN = INSERT("user_documents", $PanCard);
    // $ADHAAR = array(
    //     "UserMainId" => $UserId,
    //     "UserDocumentNo" => $_POST['AdhaarNo'],
    //     "UserDocumentName" => "ADHAAR CARD",
    //     "UserDocumentFile" => UPLOAD_FILES("../storage/teams/documents/$UserId", "null", "AdhaarCard", "AdhaarFile"),
    // );
    // $SAVEADDAHR = INSERT("user_documents", $ADHAAR);


    //send mail to created account
    SENDMAILS("Welcome to " . APP_NAME, "Dear " . $_POST['UserFullName'] . ",", $_POST['UserEmailId'], "<br>
 <p>
 Welcome to " . APP_NAME . "!<br> Your personal Lead management system offered by " . APP_NAME . ".<br>
 Your Login details are as follows:<br>
 <br>
 <b>Username:</b> " . $_POST['UserEmailId'] . "<br>
 <b>Password:</b> " .  $UserPassword . "<br>
 <b>Login URL: </b> " . DOMAIN . "<br>
 <br>
 <b>Note:</b> Please change your password after login.<br>
 </p>");
    //generate response
    RESPONSE($Save, "New User Details saved successfully!", "Unable to save User details at the moment!");
    //update profile
} elseif (isset($_POST['UpdateProfile'])) {
    $UserId = SECURE($_POST['UserId'], "d");
    $users = [
        "UserFullName" => $_POST['UserFullName'],
        "UserPhoneNumber" => $_POST['UserPhoneNumber'],
        "UserEmailId" => $_POST['UserEmailId']
    ];
    $Update = UPDATE_TABLE("users", $users, "UserId='$UserId'");
    RESPONSE($Update, "Profile updated successfully!", "Unable to update profile at the moment!");
}

//update user details
elseif (isset($_POST['UpdateUserDetails'])) {

    $CompanyUserId = SECURE($_POST['userid'], "d");
    $CompanyAdminId = FETCH("SELECT * FROM company_users WHERE company_alloted_user_id='$CompanyUserId'", "company_user_created_by");
    $UserRole = $_POST["UserType"];
    $DATA = [
        "UserFullName" => $_POST['UserNewName'],
        "UserEmailId" => $_POST['UserNewEmail'],
        "UserPhoneNumber" => $_POST['UserNewPhone'],
        "UserType" => $UserRole,
        "UserUpdatedAt" => CURRENT_DATE_TIME,
    ];
    $CountDigitalUser = TOTAL("SELECT * FROM company_users WHERE company_user_created_by='$CompanyAdminId' and company_user_role='digital' and company_user_status='1'");
    if ($_POST["UserType"] == "Digital" && $CountDigitalUser >= MAXIMUM_DIGITAL_USER) {
        LOCATION("warning", "Maximum Two Digital Allowed!", $access_url);
    } else {

        $Update = UPDATE_TABLE("users", $DATA, "UserID='$CompanyUserId'");
        $CompanyRoleUpdate = UPDATE("UPDATE company_users SET company_user_role='$UserRole' WHERE company_alloted_user_id='$CompanyUserId'");
        $EmpDetails = array(
            "UserEmpReportingMember" => $_POST['UserEmpReportingMember'],
            "UserEmpGroupName" => $_POST['UserEmpGroupName'],
        );
        $CheckEMp = CHECK("SELECT * FROM user_employment_details where UserMainUserId='$CompanyUserId'");
        if ($CheckEMp == null) {
            $Update = INSERT("user_employment_details", $EmpDetails);
        } else {
            $Update = UPDATE_TABLE("user_employment_details", $EmpDetails, "UserMainUserId='$CompanyUserId'");
        }
        $UserProjectType = [
            "User_main_id" => $CompanyUserId,
            "User_project_main_Id" => $_POST["Project_Name"],
            "User_project_updated_at" => CURRENT_DATE_TIME,
            "CompanyId" => CompanyId,
        ];
        $CheckUserProject = CHECK("SELECT * FROM user_project_type where User_main_Id='$CompanyUserId'");
        if ($CheckUserProject == null) {
            $UpdateUserProject = INSERT("user_project_type", $UserProjectType);
        } else {
            $UpdateUserProject = UPDATE_TABLE("user_project_type", $UserProjectType, "User_main_Id='$CompanyUserId'");
        }
        RESPONSE($Update, "User Details Updated successfully!", "Unable to Update Project Details at the moment!");
    }
}
