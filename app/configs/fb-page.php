<?php
$Dir = "../../";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Facebook Pages";
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
              <div class="card card-primary">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <?php include "common.php"; ?>
                    </div>
                    <div class="col-md-10">
                      <h4 class="app-heading">
                        <img src='https://img.freepik.com/premium-vector/blue-social-media-logo_197792-1759.jpg' class='w-pr-2 img-fluid'>
                        <?php echo $PageName; ?>
                      </h4>
                    </div>
                    <div class="col-md-2">
                      <a href="#" onclick="Databar('Add-Facebook-Page')" class='btn btn-sm btn-block btn-danger'><i class='fa fa-plus'></i> Add Page</a>
                    </div>
                  </div>

                  <div class="row">
                    <?php
                    $FetchFacebookPages = _DB_COMMAND_("SELECT * FROM config_facebook_accounts where CompanyId='" . APP_COMPANY_ID . "' ORDER BY id DESC", true);
                    if ($FetchFacebookPages != null) {
                      foreach ($FetchFacebookPages as $Facebook) {
                    ?>
                        <div class='col-md-6'>
                          <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST">
                            <?php
                            FormPrimaryInputs(true, [
                              "id" => $Facebook->id,
                            ]); ?>
                            <div class="row">
                              <div class="col-md-12">
                                <h5 class="app-sub-heading">
                                  <img src='https://img.freepik.com/premium-vector/blue-social-media-logo_197792-1759.jpg' class='w-pr-3 img-fluid'>
                                  Update Facebook Page Details
                                </h5>
                                <div class="row mb-5px">
                                  <div class="form-group col-md-5">
                                    <label>Facebook Page Name</label>
                                    <input type="text" name="fb_page_name" value='<?php echo $Facebook->fb_page_name; ?>' class="form-control" required="">

                                  </div>
                                  <div class="form-group col-md-7">
                                    <label>Facebook AdAccount Id</label>
                                    <input type="text" name="fb_adaccounts_id" value="<?php echo $Facebook->fb_adaccounts_id; ?>" class="form-control" required="">

                                  </div>
                                  <div class="form-group col-md-5">
                                    <label>Facebook Campaigns Id</label>
                                    <input type="text" name="fb_campaigns_id" value="<?php echo $Facebook->fb_campaigns_id; ?>" class="form-control" required="">

                                  </div>
                                  <div class="form-group col-md-7">
                                    <label>Facebook Campaigns Name</label>
                                    <input type="text" name="fb_campaigns_name" value="<?php echo $Facebook->fb_campaigns_name; ?>" class="form-control" required="">

                                  </div>
                                  <div class="form-group col-md-5">
                                    <label>Facebook Adsets Id</label>
                                    <input type="text" name="fb_adsets_id" value="<?php echo $Facebook->fb_adsets_id; ?>" class="form-control" required="">

                                  </div>
                                  <div class="form-group col-md-7">
                                    <label>Facebook Adsets Name</label>
                                    <input type="text" name="fb_adsets_name" value="<?php echo $Facebook->fb_adsets_name; ?>" class="form-control" required="">

                                  </div>
                                  <div class="form-group col-md-5">
                                    <label>Facebook AdsId </label>
                                    <input type="text" name="fb_ads_id" value="<?php echo $Facebook->fb_ads_id; ?>" class="form-control" required="">

                                  </div>
                                  <div class="form-group col-md-7">
                                    <label>Facebook Ads Name</label>
                                    <input type="text" name="fb_ads_name" value="<?php echo $Facebook->fb_ads_name; ?>" class="form-control" required="">
                                  </div>
                                  <div class="form-group col-md-5">
                                    <label>Choose Project</label>
                                    <select name="Project_Name" class="form-control form-control-sm">
                                      <option value="">Select Projects</option>
                                      <?php
                                      $companyID = CompanyId;
                                      $FetchProjectName = _DB_COMMAND_("SELECT * FROM projects where CompanyID='$companyID'", true);
                                      if ($FetchProjectName != null) {
                                        foreach ($FetchProjectName as $Project) {
                                          if ($Facebook->fb_project_Id == $Project->ProjectsId) {
                                            $selected = "selected";
                                          } else {
                                            $selected = "";
                                          }
                                      ?>
                                          <option <?php echo $selected; ?> value="<?php echo $Project->ProjectsId; ?>"><?php echo $Project->ProjectName; ?></option>
                                      <?php
                                        }
                                      } ?>
                                    </select>
                                  </div>
                                  <div class="form-group col-md-12">
                                    <label>Facebook API Access Token</label>
                                    <input type="text" name="fb_access_token" list="fb_access_token" class="form-control" value="<?php echo $Facebook->fb_access_token; ?>" required="">
                                  </div>
                                </div>
                                <div class="row mb-5px">
                                  <small class="text-gray ml-2">*Leads Will Auto Fetch In every Hours </small>
                                  <div class="col-md-12 text-right">
                                    <?php
                                    CONFIRM_DELETE_POPUP("fb_pages", [
                                      "remove_facebook_pages" => true,
                                      "control_id" => $Facebook->id
                                    ], "ModuleHandler", "<i class='fa fa-trash'></i> Remove Page", 'text-danger btn btn-sm mt-3 pull-left'); ?>
                                    <button class="btn btn-md mt-0 m-t-0 btn-success" name="UpdateFacebookDetails" TYPE="submit"><i class="fa fa-check"></i> Update Details</button>
                                    <!-- <button class="btn btn-md mt-0 m-t-0 btn-info" name="FetchAllFBLeads" TYPE="submit"><i class="fa fa-check"></i> Fetch New Leads</button> -->
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      <?php
                      }
                    } else {
                      ?>
                      <div class='col-md-6'>
                        <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST">
                          <?php FormPrimaryInputs(true); ?>
                          <div class="row">
                            <div class="col-md-12">
                              <h5 class="app-sub-heading">Add New Facebook Account</h5>
                              <div class="row mb-5px">
                                <div class="form-group col-md-5">
                                  <label>Facebook Page Name</label>
                                  <input type="text" name="fb_page_name" list="fb_page_name" class="form-control" required="">

                                </div>
                                <div class="form-group col-md-7">
                                  <label>Facebook AdAccount Id</label>
                                  <input type="text" name="fb_adaccounts_id" list="fb_adaccounts_id" class="form-control" required="">

                                </div>
                                <div class="form-group col-md-5">
                                  <label>Facebook Campaigns Id</label>
                                  <input type="text" name="fb_campaigns_id" list="fb_campaigns_id" class="form-control" required="">

                                </div>
                                <div class="form-group col-md-7">
                                  <label>Facebook Campaigns Name</label>
                                  <input type="text" name="fb_campaigns_name" list="fb_campaigns_name" class="form-control" required="">

                                </div>
                                <div class="form-group col-md-5">
                                  <label>Facebook Adsets Id</label>
                                  <input type="text" name="fb_adsets_id" list="fb_adsets_id" class="form-control" required="">

                                </div>
                                <div class="form-group col-md-7">
                                  <label>Facebook Adsets Name</label>
                                  <input type="text" name="fb_adsets_name" list="fb_adsets_name" class="form-control" required="">

                                </div>
                                <div class="form-group col-md-5">
                                  <label>Facebook AdsId </label>
                                  <input type="text" name="fb_ads_id" list="fb_ads_id" class="form-control" required="">

                                </div>
                                <div class="form-group col-md-7">
                                  <label>Facebook Ads Name</label>
                                  <input type="text" name="fb_ads_name" list="fb_ads_name" class="form-control" required="">
                                </div>
                                <div class="form-group col-md-5">
                                  <label>Choose Project</label>
                                  <select name="Project_Name" class="form-control form-control-sm">
                                    <option value="">Select Projects</option>
                                    <?php
                                    $companyID = CompanyId;
                                    $FetchProjectName = _DB_COMMAND_("SELECT * FROM projects where CompanyID='$companyID'", true);
                                    if ($FetchProjectName != null) {
                                      foreach ($FetchProjectName as $Project) {

                                    ?>
                                        <option value="<?php echo $Project->ProjectsId; ?>"><?php echo $Project->ProjectName; ?></option>
                                    <?php
                                      }
                                    } ?>
                                  </select>
                                </div>
                                <div class="form-group col-md-12">
                                  <label>Facebook API Access Token</label>
                                  <input type="text" name="fb_access_token" list="fb_access_token" class="form-control" required="">
                                </div>
                              </div>
                              <div class="row mb-5px">
                                <div class="col-md-12">
                                  <button class="btn btn-md btn-dark" name="SavePageDetails" TYPE="submit"><i class="fa fa-check"></i> Save Facebook Details</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    <?php
                    } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <?php
    include $Dir . "/include/forms/Add-Facebook-Page.php";
    include $Dir . "/include/footer.php";
    ?>
  </div>

  <?php include $Dir . "/assets/FooterFilesLoader.php"; ?>

</body>

</html>