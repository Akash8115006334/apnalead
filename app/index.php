<?php
$Dir = "..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';
//pagevariables
$PageName = "Dashboard";
$PageDescription = "Main Dashboard of " . APP_NAME . " for Highlighted and latest checkups about available data";
// checking User Has A Plan Or Not
$UserID = $_SESSION['APP_LOGIN_USER_ID'];
$checkPlan = FETCH("SELECT company_user_created_by FROM company_users WHERE company_alloted_user_id='$UserID'", "company_user_created_by");
$UserBillingSql = CHECK("SELECT * FROM user_billings WHERE user_main_id='$checkPlan' and user_billing_status='1'");
if (isset($_GET['skip_plan'])) {
  $_SESSION['skip_plan'] = true;
}
if (!isset($_SESSION['skip_plan'])) {
  if ($UserBillingSql == null) {
    LOCATION("success", "Welcome $UserFullName, Login Successful!", DOMAIN . "/app/UserPlan/");
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<style>
  .canvasjs-chart-credit {
    display: none !important;
  }
</style>

<head>
  <meta charset="utf-8" />
  <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
  <meta name="keywords" content="<?php echo APP_NAME; ?>">
  <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
  <?php include $Dir . "/assets/HeaderFilesLoader.php"; ?>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <style>
    .card {
      box-shadow: 0px 0px 1px black !important;
      background-color: white !important;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">

  <div class="wrapper">
    <?php include $Dir . "/include/loader.php"; ?>
    <?php
    include $Dir . "/include/header.php";
    include $Dir . "/include/sidebar.php";

    if (isset($_SESSION['SetupComplete'])) {
      echo ' <script>
    swal({
      title: "Success!",
      text: "WELCOME To APNA-LEAD",
      icon: "success",
    });
  </script>';
    }
    unset($_SESSION['SetupComplete']);
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary new-bg-color">
                <div class="card-body">
                  <?php
                  if (AuthAppUser("UserType") == "Admin") {
                    $ViewDash = $AllViews;
                    if ($ViewDash == 'Digital Dashboard') {
                      include 'lead-dash.php';
                    } elseif ($ViewDash == 'Lead Dashboard') {
                      include 'lead-dash.php';
                    } else {
                      include 'lead-dash.php';
                    }
                  } elseif (AuthAppUser("UserType") == "Digital") {
                    include "lead-dash.php";
                  } elseif (AuthAppUser("UserType") == "TeamMember") {
                    include "lead-dash.php";
                  } else {
                    include "lead-dash.php";
                  } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php
    include $Dir . "/include/footer.php";
    ?>
  </div>
  <?php include $Dir . "/assets/FooterFilesLoader.php"; ?>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <!-- <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script> -->
  <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
  <script>
    $(document).ready(function() {
      var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        theme: "light2",
        title: {
          text: ""
        },
        axisY: {
          title: "Number of Calls"
        },
        data: [{
          lineColor: "red",
          markerColor: "#06088E",
          markerSize: 15,
          type: "line",
          yValueFormatString: "#,##0 Calls",
          dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
      });
      chart.render();
    });
  </script>
</body>

</html>