<?php
if (isset($_POST['UpdateCompany'])) {
    $UserId = $_SESSION['APP_LOGIN_USER_ID'];
    $ComapnyLogo = $_FILES['company_logo'];
    $logo = UPLOAD_FILES("./../storage/companylogo", "Null", "$ComapnyLogo", "company_logo");
    // Update the config_config table with this deatils
    $UpdateCompany = [
        "company_name" => $_POST['company_name'],
        "indusrty_type" => $_POST['Industry'],
        "company_logo" => $logo,
        "company_descriptions" => $_POST['company_descriptions'],
    ];
    $CompanyUpdateSql = UPDATE_TABLE("config_companies", $UpdateCompany, "company_main_user_id='$UserId'");
    //update user table's comapny name and departmanet
    $UpdateUserCompany = [
        "UserCompanyName" => $_POST['company_name'],
        "UserDepartment" => $_POST['Industry'],
    ];
    $UserTableUpdate = UPDATE_TABLE("users", $UpdateUserCompany, "UserId='$UserId'");

    // get the comapny id 
    $CSql = "SELECT * FROM config_companies WHERE company_main_user_id='$UserId'";
    $CompanyID = FETCH($CSql, "company_id");
    // insert into billing address

    $BillingAddress = [
        "Company_Main_Id" => $CompanyID,
        "Company_GST_No" => $_POST['Company_GST_No'],
        "Company_Address" => $_POST['Company_Address'],
        "Company_Area_Locality" => $_POST['Company_Area_Locality'],
        "Company_Landmark" => $_POST['Company_Landmark'],
        "Company_City" => $_POST['Company_City'],
        "Company_State" => $_POST['Company_State'],
        "Company_Country" => $_POST['Company_Country'],
        "Company_Pincode" => $_POST['Company_Pincode'],
    ];
    $CompanyAddress = INSERT("company_address", $BillingAddress);
    $access_url = "../app/Setup/2/";
    RESPONSE($CompanyAddress, "Company Updated Successfully", "Company not Updated!!");
} elseif (isset($_POST['UpdateCompanyDetails'])) {
    $UserId = $_SESSION['APP_LOGIN_USER_ID'];
    $ComapnyLogo = $_FILES['company_logo'];
    $logo = UPLOAD_FILES("./../storage/companylogo", "Null", "$ComapnyLogo", "company_logo");
    // Update the config_config table with this deatils
    $UpdateCompany = [
        "company_name" => $_POST['company_name'],
        "indusrty_type" => $_POST['Industry'],
        "company_logo" => $logo,
        "company_descriptions" => $_POST['company_descriptions'],
    ];
    $CompanyUpdateSql = UPDATE_TABLE("config_companies", $UpdateCompany, "company_main_user_id='$UserId'");
    //update user table's comapny name and departmanet
    $UpdateUserCompany = [
        "UserCompanyName" => $_POST['company_name'],
        "UserDepartment" => $_POST['Industry'],
    ];
    $UserTableUpdate = UPDATE_TABLE("users", $UpdateUserCompany, "UserId='$UserId'");

    // get the comapny id 
    $CSql = "SELECT * FROM config_companies WHERE company_main_user_id='$UserId'";
    $CompanyID = FETCH($CSql, "company_id");
    // insert into billing address

    $BillingAddress = [
        "Company_Main_Id" => $CompanyID,
        "Company_GST_No" => $_POST['Company_GST_No'],
        "Company_Address" => $_POST['Company_Address'],
        "Company_Area_Locality" => $_POST['Company_Area_Locality'],
        "Company_Landmark" => $_POST['Company_Landmark'],
        "Company_City" => $_POST['Company_City'],
        "Company_State" => $_POST['Company_State'],
        "Company_Country" => $_POST['Company_Country'],
        "Company_Pincode" => $_POST['Company_Pincode'],
    ];
    $CompanyAddress = INSERT("company_address", $BillingAddress);
    RESPONSE($CompanyAddress, "Company Updated Successfully", "Company not Updated!!");
}
