<?php
$Dir = "./../../../";
require $Dir . "acm/SysFileAutoLoader.php";
require $Dir . "handler/AuthController/AuthAccessController.php";
?>
<!-- SetUp Page Started Herer-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SetupPage | <?php echo APP_NAME; ?></title>
    <?php include $Dir . "assets/HeaderFilesLoader.php"; ?>
</head>
<body>
    <section class="company-details mt-4">
        <div class="container">
            <?php include $Dir . 'include/SetupPageHeader.php'; ?>
            <div class="row">
                <div class="col-md-12 my-3">
                    <p class="text-dark ">
                        Please Enter Your Company's Details and Other Required Information
                    </p>
                </div>
            </div>
            <form class="row" action='<?php echo CONTROLLER; ?>/ModuleHandler.php' method="POST" enctype="multipart/form-data">
                <?php FormPrimaryInputs(true);
                $UserID = $_SESSION['APP_LOGIN_USER_ID'];
                $CompanyTableDetails = "SELECT * FROM config_companies WHERE company_main_user_id='$UserID'";
                $CompanyIndustryDetails = "SELECT * FROM users WHERE UserId='$UserID'";
                ?>
                <div class="row m-auto">

                    <div class="col-md-5 row m-auto">
                        <div class="col-md-12">
                            <h5 class="app-text">Upload Company Logo</h5>
                        </div>
                        <?php
                        $ImageEmpty = FETCH($CompanyTableDetails, "company_logo");
                        if (empty($ImageEmpty)) {
                            $ImageEmpty = "userlogo.jpg";
                        }
                        ?>
                        <div class="col-md-12 text-center mb-4 upload-logo">
                            <input hidden type='file' name='company_logo' id='customer_profile_image' accept="image/*">
                            <label for='customer_profile_image' class="image-container">
                                <img src="<?php echo STORAGE_URL . '/companylogo/' . $ImageEmpty; ?>" id='UploadFile' class='rounded-circle app-border p-3'>
                                <span class="py-3">Upload</span>
                            </label>

                        </div>
                    </div>
                    <div class='col-md-7 row m-auto mt-0'>
                        <div class="col-md-12">
                            <h5 class="app-text">Company Details</h5>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Company Name</label>
                            <input type="text" name='company_name' value="<?php echo FETCH($CompanyTableDetails, "company_name"); ?>" class="form-control" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Industry Type</label>
                            <select name="Industry" id="Industry" class="form-control" required>
                                <?php
                                echo '<option disabled selected>Industry Type*</option>';
                                InputOptions(Industry, FETCH($CompanyIndustryDetails, "UserDepartment")); ?>
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Company Description</label>
                            <textarea name='company_descriptions' class="form-control" rows="3" required><?php echo FETCH($CompanyTableDetails, "company_descriptions");  ?></textarea>
                        </div>
                    </div>
                </div>
                <?php
                $CompanyMainId = FETCH($CompanyTableDetails, "company_id");
                $fechData = _DB_COMMAND_("SELECT * FROM company_address WHERE  Company_Main_Id='$CompanyMainId'", true);
                if (!empty($fechData)) {
                    foreach ($fechData as $data) {
                        $Company_GST_No =  $data->Company_GST_No;
                        $Company_Address = $data->Company_Address;
                        $Company_Area_Locality = $data->Company_Area_Locality;
                        $Company_Landmark = $data->Company_Landmark;
                        $Company_City = $data->Company_City;
                        $Company_State = $data->Company_State;
                        $Company_Country = $data->Company_Country;
                        $Company_Pincode = $data->Company_Pincode;
                    }
                } else {
                    $Company_GST_No =  "";
                    $Company_Address = "";
                    $Company_Area_Locality = "";
                    $Company_Landmark = "";
                    $Company_City = "";
                    $Company_State = "";
                    $Company_Country = "";
                    $Company_Pincode = "";
                }
                // $GetCompanyBillingDeatils = "SELECT * FROM company_address WHERE Company_Main_Id=' $CompanyMainId'"; 
                ?>
                <div class="col-md-12 row m-auto">
                    <div class="col-md-12">
                        <h5 class="app-text mt-5">Billing Address</h5>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>GST Number</label>
                        <input type="text" value="<?php echo $Company_GST_No; ?>" name='Company_GST_No' class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Company Address</label>
                        <textarea name='Company_Address' class="form-control" rows="1"><?php echo $Company_Address; ?></textarea>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Company Area/Locality</label>
                        <input type="text" value="<?php echo $Company_Area_Locality; ?>" name='Company_Area_Locality' class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Company Landmark</label>
                        <input type="text" value="<?php echo $Company_Landmark; ?>" name='Company_Landmark' class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>City</label>
                        <input type="text" value="<?php echo $Company_City; ?>" name='Company_City' class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>State</label>
                        <input type="text" value="<?php echo $Company_State; ?>" name='Company_State' class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Country</label>
                        <input type="text" value="<?php echo $Company_Country; ?>" name='Company_Country' class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Pincode</label>
                        <input type="number" value="<?php echo $Company_Pincode; ?>" name='Company_Pincode' class="form-control">
                    </div>
                    <div class="col-md-12 text-center my-4 mt-2">
                        <button type='submit' name='UpdateCompany' class="btn btn-primary btn-lg">Save & Continue</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <?php include $Dir . "assets/FooterFilesLoader.php"; ?>
    <script>
        const customer_profile_image = document.getElementById('customer_profile_image');
        const UploadFile = document.getElementById('UploadFile');
        customer_profile_image.onchange = evt => {
            const [file] = customer_profile_image.files;
            if (file) {
                UploadFile.src = URL.createObjectURL(file);
            } else {
                // UploadFile.src = "../../../storage/companylogo/userlogo.jpg";
            }
        }
    </script>
    <script>
        window.onload = function() {
            document.getElementById('link1').classList.add('green');
        }
    </script>
</body>

</html>