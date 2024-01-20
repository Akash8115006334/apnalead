<?php
$Dir = "../../";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "External Integrations";
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
                    <div class='col-md-3'>
                      <div class="card p-2 bg-light">
                        <center class="p-3">
                          <img src='https://img.freepik.com/premium-vector/blue-social-media-logo_197792-1759.jpg' class='w-50 img-fluid'>
                        </center>
                        <h6 class="text-center">Facebook</h6>
                        <p class="text-grey small text-justify">Add facebook page/account and get leads direct into applications, leads will be automaically distributed to respective users.</p>
                        <hr>
                        <p class="flex-s-b small">
                          <span class='bold'>Active Pages</span>
                          <span>
                            <?php
                            $companyId = APP_COMPANY_ID;
                            $FacebookAccountSql = "SELECT * FROM config_facebook_accounts where fd_adaccounts_status='Active' and fb_campaigns_status='Active' and fd_adsets_status='Active' and fd_ads_status='Active' and CompanyID='$companyId'";
                            $CheckFBAccounts = CHECK($FacebookAccountSql);
                            if ($CheckFBAccounts != null) {
                              echo "<span class='text-success'>" . TOTAL($FacebookAccountSql) . " pages </span>";
                            } else {
                              echo "<span class='text-danger'>" . TOTAL($FacebookAccountSql) . " pages </span>";
                            } ?>
                          </span>
                        </p>
                        <hr>
                        <a href="fb-page.php" class="btn btn-sm btn-success mx-auto d-flex">View & Add Page</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <?php
    include $Dir . "/include/forms/Add-Data-Counter.php";
    include $Dir . "/include/footer.php";
    ?>
  </div>

  <?php include $Dir . "/assets/FooterFilesLoader.php"; ?>

</body>

</html>