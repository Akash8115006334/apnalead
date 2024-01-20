<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "All Team Member";
$PageDescription = "Manage teams";

// Get the company Id
$UserID = AuthAppUser("UserId");
$MainCompanyId = FETCH("SELECT * FROM company_users WHERE company_alloted_user_id='$UserID'", "company_main_id");
$CompanyTableDetails = "SELECT * FROM config_companies WHERE company_id='$MainCompanyId'";
$companyID = FETCH($CompanyTableDetails, "company_id");
if (isset($_GET['view'])) {
  $View = $_GET['view'];
  $PageName = "All $View";
}

$REQ_UserId = AuthAppUser("UserId");
$UserSql = "SELECT * FROM users where UserId='$REQ_UserId'";
$EmpSql = "SELECT * FROM user_employment_details where UserMainUserId='$REQ_UserId'";

if (FETCH($EmpSql, "UserEmpGroupName") == "SM" || FETCH($EmpSql, "UserEmpGroupName") == "Management") {
  header("location: details/?uid=" . SECURE($REQ_UserId, "e"));
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
                      <h3 class="app-heading"><?php echo $PageName; ?></h3>
                    </div>
                    <!-- <div class="col-md-2">
                      <a href="tree.php" class="btn btn-md btn-danger btn-block pull-right"><i class='fa fa-tree'></i> Group Wise View</a>
                    </div> -->
                    <div class="col-md-12">
                      <?php
                      $EmpSql = "SELECT * FROM user_employment_details where UserMainUserId='" . AuthAppUser("UserId") . "'";
                      if (FETCH($EmpSql, "UserEmpGroupName") != "SM" || FETCH($EmpSql, "UserEmpGroupName") != "Management") {
                      ?>
                        <form action="" method="get" style="display:flex;justify-content:start;">
                          <div class="form-group mb-0">
                            <select name="view" class="form-control form-control-sm  mb-0" onchange="form.submit()">
                              <option value="">All Group</option>
                              <?php
                              if (AuthAppUser("UserType") == "Admin") {
                                $leadStages = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId  and configs.ConfigGroupName='WORK_GROUP' and config_values.CompanyID='$companyID'", true);
                              } else {
                                if (FETCH($EmpSql, "UserEmpGroupName") == "BM") {
                                  $leadStages = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='WORK_GROUP' and config_values.CompanyID='$companyID'", true);
                                } elseif (FETCH($EmpSql, "UserEmpGroupName") == "TH") {
                                  $leadStages = _DB_COMMAND_("SELECT * FROM configs, config_values where ConfigValueDetails!='BM' and configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='WORK_GROUP' and config_values.CompanyID='$companyID'", true);
                                } else {
                                  $leadStages = _DB_COMMAND_("SELECT * FROM configs, config_values where ConfigValueDetails!='BM'  and ConfigValueDetails!='TH' and configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='WORK_GROUP' and config_values.CompanyID='$companyID'", true);
                                }
                              }
                              if ($leadStages != null) {
                                foreach ($leadStages as $g) {
                                  if (isset($_GET['view'])) {
                                    if ($_GET['view'] == $g->ConfigValueDetails) {
                                      $selected = "selected";
                                    } else {
                                      $selected = "";
                                    }
                                  } else {
                                    $selected = "";
                                  }
                              ?> <option value="<?php echo $g->ConfigValueDetails; ?>" <?php echo $selected; ?>><?php echo $g->ConfigValueDetails; ?></option>
                              <?php  }
                              } else {
                                echo "<option value='Null'>No Data Found!</option>";
                              }
                              ?>
                            </select>
                          </div>
                          <!-- <div class="form-group ml-2 mb-0">
                            <select name="location" class="form-control form-control-sm mb-0 " onchange="form.submit()">
                              <option value="">All location</option>
                              <?php // InputOptions(["Noida", "Gurgaon"], IfRequested("GET", "location", "", false));
                              ?>
                            </select>
                          </div> -->
                          <div class="form-group ml-2 mb-0">
                            <select name="search_in" class="form-control form-control-sm mb-0 ">
                              <?php InputOptions(["UserFullName", "UserPhoneNumber"], IfRequested("GET", "search_in", "", false));
                              ?>
                            </select>
                          </div>
                          <div class="form-group ml-2 mb-0">
                            <input ype="text" name="search_value" value="<?php echo IfRequested("GET", "search_value", "", false); ?>" list="UserId" onchange="form.submit()" class="form-control form-control-sm  mb-0" placeholder="Enter User Full name">
                            <datalist id="UserId">
                              <?php
                              $Users = _DB_COMMAND_("SELECT * FROM users where UserType!='Admin' ORDER BY UserId", true);

                              if ($Users != null) {
                                foreach ($Users as $User) {
                                  if (isset($_GET['UserId'])) {
                                    if ($_GET['UserId'] == $User->UserId) {
                                      $selected = "selected";
                                    } else {
                                      $selected = "";
                                    }
                                  } else {
                                    $selected  = "";
                                  }
                              ?>
                                  <option value="<?php echo $User->UserFullName;
                                                  ?>"></option>
                                  <option value="<?php echo $User->UserPhoneNumber;
                                                  ?>"></option>
                              <?php }
                              }
                              ?>
                            </datalist>
                          </div>
                          <?php if (isset($_GET['view'])) {
                          ?>
                            <a href=" index.php" class="btn btn-sm btn-danger ml-2"><i class="fa fa-times"></i> Clear Search & View All</a>
                          <?php  }
                          ?>
                        </form>
                      <?php
                      }
                      ?>
                    </div>
                    <div class="col-md-12">

                      <?php

                      if (isset($_GET['view'])) {
                        $UserEmpGroupName = $_GET['view'];

                        $search_value = $_GET['search_value'];
                        $search_in = $_GET['search_in'];
                        if (AuthAppUser("UserType") == "Admin") {
                          $TotalItems = TOTAL("SELECT * FROM users, user_employment_details, company_users where users.UserId=company_users.company_alloted_user_id and  company_users.company_main_id='$companyID' and users.UserId=user_employment_details.UserMainUserId and $search_in like '%$search_value%' and UserEmpLocations  and  UserEmpGroupName like '%$UserEmpGroupName%' ORDER BY UserEmpDetailsId Desc");
                        } else {
                          $UserId = AuthAppUser("UserId");
                          $TotalItems = TOTAL("SELECT * FROM users, user_employment_details, company_users where users.UserId=company_users.company_alloted_user_id and  company_users.company_main_id='$companyID' and user_employment_details.UserEmpReportingMember='$UserId' AND users.UserId=user_employment_details.UserMainUserId and $search_in like '%$search_value%' and UserEmpLocations  and  UserEmpGroupName like '%$UserEmpGroupName%' ORDER BY UserEmpDetailsId Desc");
                        }
                      } else {
                        if (AuthAppUser("UserType") == "Admin") {
                          $TotalItems = TOTAL("SELECT * FROM users, user_employment_details, company_users where users.UserId=company_users.company_alloted_user_id and  company_users.company_main_id='$companyID' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc");
                        } else {
                          $UserId = AuthAppUser("UserId");
                          $TotalItems = TOTAL("SELECT * FROM users, user_employment_details, company_users where users.UserId=company_users.company_alloted_user_id and  company_users.company_main_id='$companyID' and user_employment_details.UserEmpReportingMember='$UserId' AND users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc");
                        }
                      }
                      $TotalItems = 20;
                      $listcounts = 15;

                      // Get current page number
                      if (isset($_GET["view_page"])) {
                        $page = $_GET["view_page"];
                      } else {
                        $page = 1;
                      }
                      $start = ($page - 1) * $listcounts;
                      $next_page = ($page + 1);
                      $previous_page = ($page - 1);
                      $NetPages = round(($TotalItems / $listcounts) + 0.5);

                      //echo $companyID;
                      if (isset($_GET['view'])) {
                        $UserEmpGroupName = $_GET['view'];
                        $search_value = $_GET['search_value'];
                        $search_in = $_GET['search_in'];
                        if (AuthAppUser("UserType") == "Admin") {
                          $AllCustomers = _DB_COMMAND_("SELECT *  FROM users, user_employment_details, company_users where  users.UserId=company_users.company_alloted_user_id and users.UserId=user_employment_details.UserMainUserId and $search_in like '%$search_value%' and  company_users.company_main_id='$companyID'  and UserEmpLocations  and  UserEmpGroupName like '%$UserEmpGroupName%' ORDER BY UserEmpDetailsId Desc limit $start, $listcounts", true);
                        } elseif (AuthAppUser("UserType") == "Digital") {
                          $AllCustomers = _DB_COMMAND_("SELECT *  FROM users, user_employment_details, company_users where  users.UserId=company_users.company_alloted_user_id and users.UserId=user_employment_details.UserMainUserId and  company_users.company_main_id='$companyID'  ORDER BY UserEmpDetailsId Desc limit $start, $listcounts", true);
                        } else {
                          $UserId = AuthAppUser("UserId");
                          $AllCustomers = _DB_COMMAND_("SELECT *  FROM users, user_employment_details, company_users where  users.UserId=company_users.company_alloted_user_id and user_employment_details.UserEmpReportingMember='$UserId' and  company_users.company_main_id='$companyID'  AND users.UserId=user_employment_details.UserMainUserId and $search_in like '%$search_value%' and UserEmpLocations  and  UserEmpGroupName like '%$UserEmpGroupName%' ORDER BY UserEmpDetailsId Desc limit $start, $listcounts", true);
                        }
                      } else {
                        if (AuthAppUser("UserType") == "Admin") {
                          $AllCustomers = _DB_COMMAND_("SELECT *  FROM users, user_employment_details, company_users where  users.UserId=company_users.company_alloted_user_id and users.UserId=user_employment_details.UserMainUserId and  company_users.company_main_id='$companyID'  ORDER BY UserEmpDetailsId Desc limit $start, $listcounts", true);
                        } elseif (AuthAppUser("UserType") == "Digital") {
                          $AllCustomers = _DB_COMMAND_("SELECT *  FROM users, user_employment_details, company_users where  users.UserId=company_users.company_alloted_user_id and users.UserId=user_employment_details.UserMainUserId and  company_users.company_main_id='$companyID'  ORDER BY UserEmpDetailsId Desc limit $start, $listcounts", true);
                        } else {
                          $UserId = AuthAppUser("UserId");
                          $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details, company_users where  users.UserId=company_users.company_alloted_user_id and user_employment_details.UserEmpReportingMember='$UserId'and  company_users.company_main_id='$companyID'  AND users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc limit $start, $listcounts", true);
                        }
                      }

                      if ($AllCustomers != null) {
                        $Sno = 0;
                        if (isset($_GET['view_page'])) {
                          $view_page = $_GET['view_page'];
                          if ($view_page == 1) {
                            $Sno = 0;
                          } else {
                            $Sno = $listcounts * ($view_page - 1);
                          }
                        }
                        foreach ($AllCustomers as $Customers) {
                          $Sno++;
                          $UserMainUserId = $Customers->company_alloted_user_id;
                      ?>
                          <div class="col-md-12">
                            <div class="p-1 mb-1 shadow-sm rounded-2 bg-white data-list">
                              <p class="mb-0 flex-s-b">
                                <span class='w-pr-2'>
                                  <?php echo $Sno; ?>
                                </span>
                                <span class='w-pr-20 text-left'>
                                  <a href="details/?uid=<?php echo SECURE(FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserId"), "e"); ?>" class="text-primary bold">
                                    <span class="">
                                      <img src="<?php echo $LOGIN_UserProfileImage1; ?>" class="img-fluid rounded list-img">
                                      <b><?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserSalutation"); ?>
                                    </span>
                                    <?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserFullName"); ?></b><br>
                                    <span><?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserPhoneNumber"); ?></span>
                                    <span><?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserEmailId"); ?></span><br>
                                  </a>
                                </span>
                                <span class='w-pr-10'>
                                  <span class="text-grey">Total leads :<br></span>
                                  <b class="h3 mb-0"><?php echo TOTAL("SELECT LeadsId FROM leads where CompanyId='$companyID' and  LeadPersonManagedBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                </span>
                                <span class='w-pr-10'>
                                  <span class="text-grey">Fresh Leads :<br></span>
                                  <b class="h3 mb-0"><?php echo TOTAL("SELECT LeadsId FROM leads where LeadPersonStatus like '%Fresh lead%' and CompanyId='$companyID' and  LeadPersonManagedBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                </span>
                                <span class='w-pr-10'>
                                  <span class="text-grey">Follow Ups :<br></span>
                                  <b class="h3 mb-0"><?php echo TOTAL("SELECT LeadsId FROM leads where LeadPersonSubStatus like '%FOLLOW-UP%'  and CompanyId='$companyID' and LeadPersonManagedBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                </span>
                                <span class='w-pr-10'>
                                  <span class="text-grey">Today FollowUps :<br></span>
                                  <b class="h3 mb-0"><?php echo TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowCurrentStatus like '%FOLLOW-UP%'  and DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' and LeadFollowUpHandleBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                </span>
                                <span class='w-pr-10'>
                                  <span class="text-grey">MEETING PLANNED:<br></span>
                                  <b class="h3 mb-0"><?php echo TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowCurrentStatus like '%MEETING PLANNED%'  and LeadFollowUpHandleBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                </span>
                                <span class='w-pr-10'>
                                  <span class="text-grey">Registrations :<br></span>
                                  <b class="h3 mb-0"><?php echo TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowStatus like '%Registration%' and LeadFollowUpHandleBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                </span>
                                <span class='w-pr-10'>
                                  <span class="text-grey">Junk :<br></span>
                                  <b class="h3 mb-0"><?php echo TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowStatus like '%junk%' and LeadFollowUpHandleBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                </span>
                              </p>
                            </div>
                          </div>
                      <?php
                        }
                      }
                      ?>
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

</body>

</html>