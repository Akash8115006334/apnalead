<?php
$Dir = "../../";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Dashboard counters";
$PageDescription = "Manage System Profile, address, logo";
$UserID = AuthAppUser("UserId");
$companyID = FETCH("SELECT * FROM company_users WHERE company_alloted_user_id='$UserID'", "company_main_id");

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
                    <div class="col-md-10">
                      <h4 class="app-heading"><?php echo $PageName; ?></h4>
                    </div>
                    <div class='col-md-2'>
                      <a href="#" onclick="Databar('Add-Counter')" class='btn btn-sm btn-danger btn-block'><i class='fa fa-plus'></i> Add Counter</a>
                    </div>
                  </div>
                  <div class="row">
                    <?php
                    $AllCounters = _DB_COMMAND_("SELECT * FROM config_lead_counters where CompanyID='$companyID' ORDER by config_lead_counter_id ASC", true);
                    if ($AllCounters != null) {
                      foreach ($AllCounters as $Counter) {
                    ?>
                        <div class="col-md-3 ">
                          <div class="card-body box-shadow p-2 bg-light">
                            <h5 class='app-sub-heading'><?php echo $Counter->config_counter_name; ?></h5>
                            <p>
                              <span><span class="text-grey">Primary Status:</span><br> <?php echo $Counter->config_counter_primary_search; ?></span><br><br>
                              <!-- <span><span class="text-grey">Secondary Status:</span><br> <?php //echo $Counter->config_counter_secondary_search; 
                                                                                              ?></span><br> -->
                            </p>
                            <hr class='mb-2'>
                            <?php CONFIRM_DELETE_POPUP('data-counters', [
                              "remove_data_counters" => true,
                              "control_id" => $Counter->config_lead_counter_id
                            ], "ModuleHandler", "<i class='fa fa-trash'></i> Remove Counter", "btn btn-xs btn-danger");
                            ?>
                          </div>
                        </div>
                    <?php
                      }
                    } else {
                      NoData("No Counter Found!");
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
    include $Dir . "/include/forms/Add-Data-Counter.php";
    include $Dir . "/include/footer.php";
    ?>
  </div>
  <?php include $Dir . "/assets/FooterFilesLoader.php"; ?>
</body>
</html>