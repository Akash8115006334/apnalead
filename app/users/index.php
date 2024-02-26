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
                        <div class="form-group ml-2 mb-0">
                          <input ype="text" name="search_value" list="UserId" onchange="form.submit()" class="form-control form-control-sm  mb-0" placeholder="Enter User Full name">
                        </div>
                        <div class="form-group ml-2 mb-0">
                          <input ype="tel" name="PhoneNumber" onchange="form.submit()" class="form-control form-control-sm  mb-0" placeholder="Enter Phone Number">
                        </div>
                        <div class="form-group ml-1 mb-0">
                          <input ype="text" name="UserType" list="UserType" onchange="form.submit()" class="form-control form-control-sm  mb-0" placeholder="User Type">
                          <?php SUGGEST("users", "UserType", "ASC"); ?>
                        </div>

                        <div class="form-group ml-2 mb-0">
                          <select name="UserStatus" onchange="form.submit()" class="form-control form-control-sm mb-0 ">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                          </select>
                        </div>
                        <?php if (isset($_GET['search_value'])) { ?>
                          <a href=" index.php" class="btn btn-xs btn-danger ml-2"><i class="fa fa-times"></i> Clear</a>
                        <?php } ?>
                      </form>
                    </div>
                    <div class="col-md-12">
                      <div class="data-list shadow-sm  bg-info">
                        <p class="flex-s-b">
                          <span class="w-pr-5 text-left">Sno</span>
                          <?php echo AuthAppUser("UserId"); ?>
                          <span class="w-pr-30 text-left">MemberName</span>
                          <span class="w-pr-10 text-left">UserType</span>
                          <span class="w-pr-15 text-left">PhoneNumber</span>
                          <span class="w-pr-30 text-left">Email-Id</span>
                          <span class="w-pr-5 text-right">Status</span>
                        </p>
                      </div>
                    </div>
                    <?php
                    $companyID = CompanyId;
                    if (isset($_GET['search_value'])) {
                      $search_value = $_GET['search_value'];
                      $phone = $_GET['PhoneNumber'];
                      $UserStatus = $_GET['UserStatus'];
                      $UserType = $_GET['UserType'];
                      // die("SELECT * FROM users AS U LEFT JOIN company_users AS CU ON U.UserId=CU.company_alloted_user_id WHERE U.UserType like '%$UserType%'and CU.company_main_id='$companyID' and U.UserStatus='$UserStatus' and U.UserFullName like '%$search_value%' and U.UserPhoneNumber like '%$phone%' ORDER BY UserId Desc");
                      $TotalItems = TOTAL("SELECT * FROM users AS U LEFT JOIN company_users AS CU ON U.UserId=CU.company_alloted_user_id WHERE U.UserType like '%$UserType%'and CU.company_main_id='$companyID' and U.UserStatus='$UserStatus' and U.UserFullName like '%$search_value%' and U.UserPhoneNumber like '%$phone%' ORDER BY UserId Desc");
                    } else {
                      $TotalItems = TOTAL("SELECT * FROM users AS U LEFT JOIN company_users AS CU ON U.UserId=CU.company_alloted_user_id where  CU.company_main_id='$companyID' ORDER BY UserId Desc");
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
                    $companyID = CompanyId;

                    if (isset($_GET['search_value'])) {
                      $search_value = $_GET['search_value'];
                      $UserStatus = $_GET['UserStatus'];
                      $UserType = $_GET['UserType'];
                      $AllCustomers = _DB_COMMAND_("SELECT * FROM users AS U LEFT JOIN company_users AS CU ON U.UserId=CU.company_alloted_user_id  WHERE U.UserType like '%$UserType%'and CU.company_main_id='$companyID' and U.UserStatus='$UserStatus' and U.UserFullName like '%$search_value%' and U.UserPhoneNumber like '%$phone%' ORDER BY UserFullName ASC", true);
                    } else {
                      // die("SELECT * FROM users AS U LEFT JOIN company_users AS CU ON U.UserId=CU.company_alloted_user_id WHERE CU.company_main_id='$companyID' ORDER BY U.UserFullName ASC limit $start, $listcounts");
                      $AllCustomers = _DB_COMMAND_("SELECT * FROM users AS U LEFT JOIN company_users AS CU ON U.UserId=CU.company_alloted_user_id WHERE CU.company_main_id='$companyID' ORDER BY U.UserFullName ASC limit $start, $listcounts", true);
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
                              <span class='w-pr-30 text-left'>
                                <a href="details/?uid=<?php echo SECURE(FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserId"), "e"); ?>" class="text-primary bold">
                                  <span class="">
                                    <img src="<?php echo $LOGIN_UserProfileImage1; ?>" class="img-fluid rounded list-img">
                                    <b><?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserSalutation"); ?>
                                  </span>
                                  <?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserFullName"); ?></b>
                                </a>
                              </span>
                              <span class='w-pr-10 text-left'>
                                <span><i class="fa fa-group text-secondary"></i>
                                  <?php echo $Customers->UserType; ?></span>
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
                              <span class='w-pr-5 text-right'>
                                <?php echo StatusViewWithText(FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserStatus")); ?>
                              </span>
                            </p>
                          </div>
                        </div>
                    <?php
                      }
                    } else {
                      NoData("No User Found!");
                    }
                    ?>
                  </div>
                  <?php PaginationFooter($TotalItems); ?>
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