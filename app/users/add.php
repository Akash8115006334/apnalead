<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "ADD New team Member";
$PageDescription = "Manage all team";
$AdminId = $_SESSION["APP_LOGIN_USER_ID"];
$TotalUserCount = FETCH("SELECT * FROM user_billings WHERE user_main_id='$AdminId'", "user_billing_net_users");
$AdminPlanid = FETCH("SELECT * FROM user_billings WHERE user_main_id='$AdminId'", "user_billing_plan_main_id");
$AdminPlanAmount = FETCH("SELECT * FROM config_plans WHERE plan_id='$AdminPlanid'", "plan_amount_per_user");
$error = "";
// Check if there are no Digital users
$CheckDigitalUsers = CHECK("SELECT * FROM company_users WHERE company_user_role='Digital' AND company_user_created_by='$AdminId'");
if (!$CheckDigitalUsers) {
  $error = "Please add Digital User First!!";
}
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
      document.getElementById("teams").classList.add("active");
    }
    window.onload = SidebarActive;
  </script>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
  <div class="wrapper mb-5">
    <?php include $Dir . "/include/loader.php"; ?>
    <?php
    include $Dir . "/include/header.php";
    include $Dir . "/include/sidebar.php"; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row" id="disabled-form">
            <div class="col-md-12">
              <h4 class="app-heading"><?php echo $PageName; ?></h4>
              <a href="index.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> Back to ALL Users</a>
            </div>
            <div class="col-md-6">
              <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST" class="form-group">
                <?php FormPrimaryInputs(true); ?>
                <div class="row">
                  <div class="col-md-12">
                    <h5 class="app-text">Add Users</h5>
                  </div>
                  <div class="col-md-12">
                    <?php if (!empty($error)) { ?>
                      <span class="text-danger my-2"> <?php echo $error; ?></span>
                    <?php } ?>
                  </div>
                  <div class="col-md-6">
                    <label for="userFullName">User FullName* </label>
                    <input type="text" name="user_full_name" id="userFullName" class="form-control" placeholder="Enter User Name" required>
                  </div>
                  <div class="col-md-6">
                    <label for="userPhoneNumber">Primary Contact Number*</label>
                    <input type="tel" name="UserPhoneNumber" id="userPhoneNumber" class="form-control" placeholder="Enter User Name" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <label for="userEmail">Primary Contact Email-ID*</label>
                    <input type="email" name="UserEmailId" id="userEmail" class="form-control" placeholder="Enter User Name" required>
                  </div>
                  <div class="col-md-6">
                    <label for="userType">User Type*</label>
                    <select name="UserType" id="userType" class="form-control form-control-sm">
                      <option value="Admin" selected>Admin</option>
                      <option value="TeamMember">Team Member</option>
                      <option value="Digital">Digital</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="">Reporting Member*</label>
                    <select class="form-control form-control-sm" name="UserEmpReportingMember">
                      <?php
                      $companyID = APP_COMPANY_ID;
                      $Users = _DB_COMMAND_("SELECT * FROM users, company_users where users.UserId=company_users.company_alloted_user_id and company_users.company_main_id='$companyID' ORDER BY UserFullName ASC", true);
                      foreach ($Users as $User) {
                        if ($User->UserId == AuthAppUser("UserId")) {
                          $selected = "selected";
                        } else {
                          $selected = "";
                        }
                        echo "<option value='" . $User->UserId . "' $selected>" . $User->UserFullName . " @ " . $User->UserPhoneNumber . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Work Group </label>
                    <select class="form-control form-control-sm" name="UserEmpGroupName">
                      <?php CONFIG_VALUES("WORK_GROUP"); ?>
                    </select>
                  </div>
                  <div class="form-group col-md-6">

                    <label>Choose Project</label>
                    <select name="Project_Name" class="form-control form-control-sm">
                      <option value="" disabled>Select Projects</option>
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
                  <div class="col-md-12 text-center">
                    <input type="submit" name="SaveCustomer" value="ADD USER" class="btn btn-success my-4" id="addUserButton">
                    <button class="btn btn-default mt-0" type="reset"><i class="fa fa-refresh"></i> Reset</button>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-md-6" id="TotalCountUser">
              <div class="row">
                <div class="col-md-12">
                  <h5 class="app-text">Your Added Users</h5>
                </div>
              </div>
              <?php
              $companyID = APP_COMPANY_ID;
              $UsersSql = _DB_COMMAND_("SELECT * FROM company_users WHERE company_user_created_by='$AdminId' and company_main_id='$companyID'", true);
              if ($UsersSql != null) {
                $SerialNo = 0;
                foreach ($UsersSql as $UserData) {
                  $SerialNo++;
                  $CompanyUserAllotedID = $UserData->company_alloted_user_id;
                  $UserDetailsSql = "SELECT * FROM users WHERE UserId='$CompanyUserAllotedID'";
                  $GetGroupName = "SELECT * FROM user_employment_details WHERE UserMainUserId='$CompanyUserAllotedID'";

              ?>
                  <div class="data-list flex-s-b">
                    <span>
                      <span class="count"><?php echo $SerialNo; ?></span>
                      <?php echo FETCH($UserDetailsSql, "UserFullName"); ?> - <i class='text-grey'><?php echo FETCH($UserDetailsSql, "UserType"); ?></i>
                    </span>
                    <span class="menu">
                      <span class="text-grey"><i class="fa fa-calendar"></i>
                        <?php echo DATE_FORMATES("d M, Y", $UserData->company_user_created_at); ?></span>
                      <a href="#" onclick="Databar('update_<?php echo $UserData->company_users_id; ?>')" class="text-info">Update</a>
                    </span>
                  </div>
                  <div id="update_<?php echo $UserData->company_users_id; ?>" class="hidden">
                    <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST">
                      <?php FormPrimaryInputs(true, [
                        "userid" => FETCH($UserDetailsSql, "UserId")
                      ]); ?>
                      <div class="row">
                        <div class="col-md-6 form-group">
                          <input type="text" class="form-control form-control-sm" name="UserNewName" value="<?php echo  FETCH($UserDetailsSql, "UserFullName"); ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="email" class="form-control form-control-sm" name="UserNewEmail" value="<?php echo  FETCH($UserDetailsSql, "UserEmailId"); ?>">
                        </div>
                        <div class="col-md-6 form-group">
                          <input type="tel" class="form-control form-control-sm" name="UserNewPhone" value="<?php echo  FETCH($UserDetailsSql, "UserPhoneNumber"); ?>">
                        </div>
                        <div class="col-md-6 form-group">
                          <select class="form-control form-control-sm" name="UserType" required>
                            <?php InputOptions(['Select user type', 'Digital', 'Admin', 'TeamMember'], FETCH($UserDetailsSql, "UserType")); ?>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <label for="">Reporting Member*</label>
                          <select class="form-control form-control-sm" name="UserEmpReportingMember">
                            <?php
                            $Users = _DB_COMMAND_("SELECT * FROM users, company_users where users.UserId=company_users.company_alloted_user_id and company_users.company_main_id='$companyID' ORDER BY UserFullName ASC", true);
                            $ReportingMember = FETCH($GetGroupName, "UserEmpReportingMember");

                            if ($CompanyUserAllotedID  == AuthAppUser("UserId")) {
                              echo "<option>" . FETCH($UserDetailsSql, "UserFullName") . "</option>";
                            } else {
                              foreach ($Users as $User) {
                                if ($User->UserId == $ReportingMember) {
                                  $selected = "selected";
                                } else {
                                  $selected = "";
                                }
                                echo "<option value='" . $User->UserId . "' $selected>" . $User->UserFullName . " @ " . $User->UserPhoneNumber . "</option>";
                              }
                            }
                            ?>
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <label> Work Group </label>
                          <select class="form-control form-control-sm" name="UserEmpGroupName">
                            <?php
                            $GetGroupName = FETCH($GetGroupName, "UserEmpGroupName");
                            // echo '<option selected>' . $GetGroupName . '</option>';
                            CONFIG_VALUES("WORK_GROUP", $GetGroupName);
                            ?>
                          </select>
                        </div>
                        <div class="form-group col-md-12">

                          <label> User Project Type </label>

                          <select name="Project_Name" class="form-control form-control-sm">
                            <option value="">Select Projects Type</option>

                            <?php
                            $companyID = CompanyId;
                            $FetchProjectName = _DB_COMMAND_("SELECT * FROM projects where CompanyID='$companyID'", true);
                            $GetProjectId = FETCH("SELECT * FROM user_project_type where User_main_Id='$CompanyUserAllotedID'", "User_project_main_Id");

                            if ($FetchProjectName != null) {
                              foreach ($FetchProjectName as $Project) {
                                if ($Project->ProjectsId == $GetProjectId) {
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
                        <div class="col-md-6">
                          <button type="submit" name="UpdateUserDetails" class="btn btn-md btn-success mt-0 mb-0" style="margin-top: 0 !important;">Save</button>
                          <a href="#" onclick="Databar('update_<?php echo $UserData->company_users_id; ?>')" class="btn btn-md btn-default">Cancel</a>
                          <hr>
                        </div>
                      </div>
                    </form>
                  </div>
                <?php }
                ?>
                <div class="app-sub-heading text-right mt-2">
                  <span class="text-danger "><?php echo $SerialNo . "/" . $TotalUserCount; ?> Users Left</span>
                </div>
              <?php
              } else {
                NoData("<b>No details Found!</b><br> Please add some details");
              }
              ?>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
  <?php include $Dir . "/include/footer.php"; ?>

  <?php include $Dir . "/assets/FooterFilesLoader.php"; ?>
  <script>
    var totalUserCount = <?php echo $TotalUserCount; ?>;
    var serialNumber = <?php echo $SerialNo; ?>;
    var mimuser = 3;
    // Disable the "ADD USER" button if total user count equals serial number
    if (totalUserCount === serialNumber) {
      document.getElementById('addUserButton').disabled = true;
    }

    var blurForm = document.getElementById('disabled-form');
    if (<?php echo $AdminPlanAmount; ?> == 0) {
      document.getElementById('disabled-form').classList.add('form-blur');
    }
    if (<?php echo $AdminPlanAmount; ?> > 0) {
      document.getElementById('disabled-form').classList.remove('form-blur');
    }
  </script>

</body>

</html>