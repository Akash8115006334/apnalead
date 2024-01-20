<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "All Users";
$PageDescription = "Manage teams";
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
              <div class="card card-primary new-bg-color">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-10">
                      <div class="app-heading">
                        <h4 class="mb-0 text-white"><?php echo $PageName; ?>
                        </h4>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <a href="add.php" class="btn btn-sm btn-danger btn-block"><i class="fa fa-plus"></i> Add
                        User</a>
                    </div>
                    <div class="col-md-12 mb-2">
                      <form action="" method="get" style="display:flex;justify-content:start;">
                        <div class="form-group mb-0">
                          <select name="view" class="form-control form-control-sm  mb-0" onchange="form.submit()">
                            <option value="">All</option>
                            <?php
                            $companyID = APP_COMPANY_ID;
                            $leadStages = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='WORK_GROUP' and config_values.CompanyID='$companyID'", true);
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
                                } ?> <option value="<?php echo $g->ConfigValueDetails; ?>" <?php echo $selected; ?>>
                                  <?php echo $g->ConfigValueDetails; ?></option>
                            <?php }
                            } else {
                              echo "<option value='Null'>No Data Found!</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <!-- <div class="form-group ml-2 mb-0">
                          <select name="location" class="form-control form-control-sm mb-0 " onchange="form.submit()">
                            <option value="">All location</option>
                            <?php //InputOptions(["Noida", "Gurgaon"], IfRequested("GET", "location", false)); 
                            ?>
                          </select>
                        </div> -->
                        <div class="form-group ml-2 mb-0">
                          <select name="search_in" class="form-control form-control-sm mb-0 ">
                            <option value="UserFullName">User Full Name</option>
                            <option value="UserPhoneNumber">Phone Number</option>
                            <option value="UserEmailId">EmailId</option>
                          </select>
                        </div>
                        <div class="form-group ml-2 mb-0">
                          <input ype="text" name="search_value" list="UserId" onchange="form.submit()" class="form-control form-control-sm  mb-0" placeholder="Enter User Full name">
                          <datalist id="UserId">
                            <?php
                            $Users = _DB_COMMAND_("SELECT * FROM users ORDER BY UserId", true);
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
                                } ?>
                                <option value="<?php echo $User->UserFullName; ?>" <?php echo $selected; ?>></option>
                            <?php }
                            } ?>
                          </datalist>
                        </div>
                        <div class="form-group ml-1 mb-0">
                          <input ype="text" name="UserType" list="UserType" onchange="form.submit()" class="form-control form-control-sm  mb-0" placeholder="User Type">
                          <?php SUGGEST("users", "UserType", "ASC"); ?>
                        </div>
                        <div class="form-group ml-2 mb-0">
                          <input ype="text" name="UserEmpBloodGroup" list="UserEmpBloodGroup" onchange="form.submit()" class="form-control form-control-sm  mb-0" placeholder="Enter Blood Group Name">
                          <datalist id="UserEmpBloodGroup">
                            <?php
                            $Users = _DB_COMMAND_("SELECT * FROM user_employment_details GROUP BY UserEmpBloodGroup", true);
                            if ($Users != null) {
                              foreach ($Users as $User) {
                                if (isset($_GET['UserEmpBloodGroup'])) {
                                  if ($_GET['UserEmpBloodGroup'] == $User->UserEmpBloodGroup) {
                                    $selected = "selected";
                                  } else {
                                    $selected = "";
                                  }
                                } else {
                                  $selected  = "";
                                } ?>
                                <option value="<?php echo $User->UserEmpBloodGroup; ?>" <?php echo $selected; ?>>
                                  <?php echo $User->UserEmpBloodGroup; ?></option>
                            <?php }
                            } ?>
                          </datalist>
                        </div>
                        <div class="form-group ml-2 mb-0">
                          <select name="UserStatus" onchange="form.submit()" class="form-control form-control-sm mb-0 ">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                          </select>
                        </div>
                        <?php if (isset($_GET['view'])) { ?>
                          <a href=" index.php" class="btn btn-xs btn-danger ml-2"><i class="fa fa-times"></i> Clear</a>
                        <?php } ?>
                      </form>
                    </div>
                    <div class="col-md-12">
                      <div class="data-list shadow-sm  bg-info">
                        <p class="flex-s-b">
                          <span class="w-pr-5 text-left">Sno</span>
                          <span class="w-pr-25 text-left">MemberName</span>
                          <span class="w-pr-10 text-left">UserType</span>
                          <span class="w-pr-15 text-left">PhoneNumber</span>
                          <span class="w-pr-30 text-left">EmailId</span>
                          <!-- <span class="w-pr-10 text-left">Blood</span> -->
                          <span class="w-pr-5 text-right">Status</span>
                        </p>
                      </div>
                    </div>
                    <?php
                    $companyID = APP_COMPANY_ID;
                    if (isset($_GET['view'])) {
                      $UserEmpGroupName = $_GET['view'];
                      // $location = $_GET['location'];
                      $search_value = $_GET['search_value'];
                      $search_in = $_GET['search_in'];
                      // $UserEmpBloodGroup = $_GET['UserEmpBloodGroup'];
                      $UserStatus = $_GET['UserStatus'];
                      $UserType = $_GET['UserType'];
                      $TotalItems = TOTAL("SELECT * FROM users, user_employment_details, company_users where users.UserType like '%$UserType%'and company_users.company_main_id='$companyID' and users.UserStatus='$UserStatus' and users.UserId=company_users.company_alloted_user_id  and users.UserId=user_employment_details.UserMainUserId and $search_in like '%$search_value%'  and  UserEmpGroupName like '%$UserEmpGroupName%' ORDER BY UserEmpDetailsId Desc");
                    } elseif (isset($_GET['UserStatus'])) {
                      $UserStatus = $_GET['UserStatus'];
                      $TotalItems = TOTAL("SELECT * FROM users, user_employment_details, company_users where UserStatus='$UserStatus' and company_users.company_main_id='$companyID' and users.UserId=company_users.company_alloted_user_id and users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc");
                    } else {
                      $TotalItems = TOTAL("SELECT * FROM users, user_employment_details, company_users where users.UserId=user_employment_details.UserMainUserId and users.UserId=company_users.company_alloted_user_id and company_users.company_main_id='$companyID' ORDER BY UserEmpDetailsId Desc");
                    }
                    // $TotalItems = 20;
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
                    $companyID = APP_COMPANY_ID;

                    if (isset($_GET['view'])) {
                      $UserEmpGroupName = $_GET['view'];
                      // $location = $_GET['location'];
                      $search_value = $_GET['search_value'];
                      $search_in = $_GET['search_in'];
                      // $UserEmpBloodGroup = $_GET['UserEmpBloodGroup'];
                      $UserStatus = $_GET['UserStatus'];
                      $UserType = $_GET['UserType'];
                      // echo $companyID;
                      $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details, company_users where users.UserType like '%$UserType%' and company_users.company_main_id='$companyID' and users.UserStatus='$UserStatus'  and users.UserId=user_employment_details.UserMainUserId  and users.UserId=company_users.company_alloted_user_id and $search_in like '%$search_value%'  and  UserEmpGroupName like '%$UserEmpGroupName%' ORDER BY UserFullName ASC", true);
                    } elseif (isset($_GET['UserStatus'])) {
                      $UserStatus = $_GET['UserStatus'];
                      $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details, company_users where UserStatus='$UserStatus' and company_users.company_main_id='$companyID' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
                    } else {
                      $AllCustomers = _DB_COMMAND_("SELECT * FROM users,  company_users where users.UserId=company_users.company_alloted_user_id and  company_users.company_main_id='$companyID' ORDER BY UserFullName ASC limit $start, $listcounts", true);
                      // echo $companyID;
                    }
                    if ($AllCustomers != null) {
                      $Sno = SERIAL_NO;
                      foreach ($AllCustomers as $Customers) {
                        $Sno++;
                        $UserMainUserId = $Customers->company_alloted_user_id;
                        $REQ_UserId = $Customers->UserId;
                        $LOGIN_UserProfileImage1 = GetUserImage($REQ_UserId);
                    ?>
                        <div class="col-md-12">
                          <div class="p-1 mb-1 shadow-sm rounded-2 bg-white data-list">
                            <p class="mb-0 flex-s-b">
                              <span class='w-pr-5 text-left'>
                                <?php echo $Sno; ?>
                              </span>
                              <span class='w-pr-25 text-left'>
                                <a href="details/?uid=<?php echo SECURE(FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserId"), "e"); ?>" class="text-primary bold">
                                  <span class="">
                                    <img src="<?php echo $LOGIN_UserProfileImage1; ?>" class="img-fluid rounded list-img">
                                    <b><?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserSalutation"); ?>
                                  </span>
                                  <?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserFullName"); ?></b>
                                </a>
                              </span>
                              <span class='w-pr-10 text-left'>
                                <span><?php echo $Customers->UserType; ?></span>
                              </span>
                              <span class='w-pr-15 text-left'>
                                <a href="tel:<?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserPhoneNumber"); ?>">
                                  <i class="fa fa-phone-square text-primary"></i>
                                  <?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserPhoneNumber"); ?>
                                </a>
                              </span>
                              <span class='w-pr-30 text-left'>
                                <a href="mailto:<?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserEmailId"); ?>">
                                  <i class="fa fa-envelope text-warning"></i>
                                  <?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserEmailId"); ?>
                                </a>
                              </span>
                              <!-- <span class='w-pr-10 text-left'>
                                <i class="bi bi-droplet-fill text-danger"></i> <?php //echo $Customers->UserEmpBloodGroup; ?>
                              </span> -->
                              <span class='w-pr-5 text-right'>
                                <?php echo StatusViewWithText(FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserStatus")); ?>
                              </span>
                            </p>
                          </div>
                        </div>
                    <?php
                      }
                    }
                    ?>
                  </div>
                  <div class="col-md-12 flex-s-b mt-2 mb-1">
                    <div class="">
                      <h6 class="mb-0" style="font-size:0.75rem;color:white !important;">Page
                        <b class="text-success fs-12"><?php echo IfRequested("GET", "view_page", $page, false); ?></b> from
                        <b class="text-success fs-12"><?php echo $NetPages; ?> </b> pages <br>Total <b class="text-success fs-12"><?php echo $TotalItems; ?></b> Entries
                      </h6>
                    </div>
                    <div class="flex">
                      <span class="mr-1">
                        <?php
                        if (isset($_GET['view'])) {
                          $viewcheck = "&view=" . $_GET['view'];
                        } else {
                          $viewcheck = "";
                        }
                        ?>
                        <a href="?view_page=<?php echo $previous_page; ?>" class="btn btn-sm btn-default"><i class="fa fa-angle-double-left"></i></a>
                      </span>
                      <form style="padding:0.3rem !important;">
                        <input type="number" name="view_page" onchange="form.submit()" class="form-control form-control-sm  mb-0" min="1" max="<?php echo $NetPages; ?>" value="<?php echo IfRequested("GET", "view_page", 1, false); ?>">
                      </form>
                      <span class="ml-1">
                        <a href="?view_page=<?php echo $next_page; ?>" class="btn btn-sm btn-default"><i class="fa fa-angle-double-right"></i></a>
                      </span>
                      <?php if (isset($_GET['view_page'])) { ?>
                        <span class="ml-1">
                          <a href="index.php" class="btn btn-sm btn-danger mb-0"><i class="fa fa-times m-1"></i></a>
                        </span>
                      <?php } ?>
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