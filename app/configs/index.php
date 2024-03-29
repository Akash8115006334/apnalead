<?php
$Dir = "../../";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';
//pagevariables
$PageName = "System Profile";
$PageDescription = "Manage System Profile, address, logo";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
  <meta name="keywords" content="<?php echo APP_NAME; ?>">
  <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
  <?php include $Dir . "/assets/HeaderFilesLoader.php"; ?>
  <script type="text/javascript">
    function SidebarActive() {
      document.getElementById("configs").classList.add("active");
      document.getElementById("system_profile").classList.add("active");
    }
    window.onload = SidebarActive;
  </script>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
  <div class="wrapper">
    <?php include $Dir . "/include/loader.php"; ?>

    <?php
    include $Dir . "/include/header.php";
    include $Dir . "/include/sidebar.php"; ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary new-bg-color">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <?php include "common.php"; ?>
                    </div>
                    <div class="col-md-12">
                      <h4 class="app-heading"><?php echo $PageName; ?></h4>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                      <form class="row" action='<?php echo CONTROLLER; ?>/ModuleHandler.php' method="POST" enctype="multipart/form-data">
                        <?php FormPrimaryInputs(true);
                        $UserID = FETCH("SELECT company_user_created_by FROM company_users WHERE company_alloted_user_id='" . AuthAppUser("UserId") . "' and company_main_id='" . CompanyId . "'", "company_user_created_by");
                        $CompanyTableDetails = "SELECT * FROM config_companies WHERE company_main_user_id='$UserID'";
                        ?>
                        <div class="row m-auto shadow-sm">
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
                                <img src="<?php echo '../../storage/companylogo/' . $ImageEmpty; ?>" id='UploadFile' class='rounded-circle app-border p-3'>
                                <span class="py-3">Upload</span>
                              </label>
                            </div>
                          </div>
                          <div class='col-md-7 row m-auto mt-0'>
                            <div class="col-md-12">
                              <h5 class="app-text">Company Details</h5>
                            </div>
                            <div class="col-md-6 form-group">
                              <label class="text-light">Company Name</label>
                              <input type="text" name='company_name' value="<?php echo FETCH($CompanyTableDetails, "company_name"); ?>" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group">
                              <label class="text-light">Industry Type</label>
                              <select name="Industry" id="Industry" class="form-control" required>
                                <?php InputOptions(Industry, FETCH($CompanyTableDetails, "indusrty_type")); ?>
                              </select>
                            </div>
                            <div class="col-md-12 form-group">
                              <label class="text-light">Company Description</label>
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
                            <label class="text-light">GST Number</label>
                            <input type="text" value="<?php echo $Company_GST_No; ?>" name='Company_GST_No' class="form-control" required>
                          </div>
                          <div class="col-md-6 form-group">
                            <label class="text-light">Company Address</label>
                            <textarea name='Company_Address' class="form-control" rows="1" required><?php echo $Company_Address; ?></textarea>
                          </div>
                          <div class="col-md-6 form-group">
                            <label class="text-light">Company Area/Locality</label>
                            <input type="text" value="<?php echo $Company_Area_Locality; ?>" name='Company_Area_Locality' class="form-control" required>
                          </div>
                          <div class="col-md-6 form-group">
                            <label class="text-light">Company Landmark</label>
                            <input type="text" value="<?php echo $Company_Landmark; ?>" name='Company_Landmark' class="form-control" required>
                          </div>
                          <div class="col-md-6 form-group">
                            <label class="text-light">City</label>
                            <input type="text" value="<?php echo $Company_City; ?>" name='Company_City' class="form-control" required>
                          </div>
                          <div class="col-md-6 form-group">
                            <label class="text-light">State</label>
                            <input type="text" value="<?php echo $Company_State; ?>" name='Company_State' class="form-control" required>
                          </div>
                          <div class="col-md-6 form-group">
                            <label class="text-light">Country</label>
                            <input type="text" value="<?php echo $Company_Country; ?>" name='Company_Country' class="form-control" required>
                          </div>
                          <div class="col-md-6 form-group">
                            <label class="text-light">Pincode</label>
                            <input type="number" value="<?php echo $Company_Pincode; ?>" name='Company_Pincode' class="form-control" required>
                          </div>
                          <div class="col-md-12 text-center my-4 mt-2">
                            <button type='submit' name='UpdateCompanyDetails' class="btn btn-success btn-md">Update</button>
                          </div>
                        </div>
                      </form>
                    </div>

                  </div>

                </div>

              </div>

            </div>
          </div>
        </div>
      </section>
    </div>

    <?php include $Dir . "/include/footer.php"; ?>
  </div>

  <?php include $Dir . "/assets/FooterFilesLoader.php"; ?>
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

</body>

</html>