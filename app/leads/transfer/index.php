<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Transfer Leads";
$PageDescription = "Manage all customers";

$UserId = AuthAppUser("UserId");
$companyID = CompanyId;
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
      document.getElementById("customers").classList.add("active");
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
                      <h3 class="app-heading mb-1">Transfer Leads</h3>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <form action="" method="GET">
                        <input type="text" name="GetLeadsFrom" value="true" hidden>
                        <h5 class="app-sub-heading">Fetch Leads From</h5>
                        <div class="row">
                          <div class="form-group col-md-12 mb-2">
                            <label>Fetch Leads From</label>
                            <select onchange="form.submit()" class="form-control form-control-sm " name="From">
                              <option value="">Select User</option>
                              <?php
                              $Users = _DB_COMMAND_("SELECT * FROM users, company_users where users.UserId=company_users.company_alloted_user_id and users.UserStatus='1' and company_users.company_user_created_by='" . AuthAppUser("UserId") . "' ORDER BY UserFullName ASC", true);
                              foreach ($Users as $User) {
                                if (isset($_GET['From'])) {
                                  if ($User->UserId == $_GET['From']) {
                                    $selected = "selected";
                                  } else {
                                    $selected = "";
                                  }
                                } else {
                                  $selected = "";
                                }
                                echo "<option value='" . $User->UserId . "' $selected>" . $User->UserFullName . " @ " . $User->UserPhoneNumber . " - " . FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $User->UserId . "'", "UserEmpGroupName") . "</option>";
                              }
                              ?>
                            </select>
                          </div>
                          <!-- <input type="text" hidden id="leasstatus" name="LeadPersonStatus" value=""> -->
                          <!-- <input type="text" value='<?php echo IfRequested("GET", "LeadPersonFullName", "", false); ?>' name="LeadPersonFullName" value=""> -->

                          <div class="col-md-12 col-6 mb-1">
                            <label>Lead Status</label>
                            <select class="form-control form-control-sm" name='LeadPersonStatus'>
                              <option value="">Select Lead Status</option>
                              <?php
                              $FetchCallStatus = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='CALL_STATUS' and config_values.CompanyID='$companyID' ORDER BY ConfigValueId DESC", true);
                              if ($FetchCallStatus != null) {
                                foreach ($FetchCallStatus as $CallStatus) {
                                  if (isset($_GET['LeadPersonStatus'])) {
                                    if ($CallStatus->ConfigValueDetails == $_GET['LeadPersonStatus']) {
                                      $selected = "selected";
                                    } else {
                                      $selected = "";
                                    }
                                  } else {
                                    $selected = "";
                                  }
                              ?>
                                  <option value="<?php echo $CallStatus->ConfigValueDetails; ?>" <?php echo $selected; ?>><?php echo $CallStatus->ConfigValueDetails; ?></option>
                              <?php
                                }
                              } ?>
                              <?php InputOptions(["FRESH LEAD", "Call Back", "Ringing", "Not Picked", "Not Interested", "Already Taken"], IfRequested("GET", "LeadPersonStatus", "",  false));
                              ?>
                            </select>
                          </div>

                          <div class="col-md-12 col-6">
                            <label>Priority Level</label>
                            <input type="text" name="LeadPriorityLevel" value="<?php echo IfRequested("GET", "LeadPriorityLevel", "", false); ?>" list="LeadPriorityLevel" class="form-control form-control-sm " placeholder="Priority Level">
                            <?php SUGGEST("leads", "LeadPriorityLevel", "ASC"); ?>
                          </div>
                          <div class="col-md-12 col-6">
                            <label>Lead Source</label>
                            <input type="text" name="LeadPersonSource" list="LeadPersonSource" value="<?php echo IfRequested("GET", "LeadPersonSource", "", false); ?>" class="form-control form-control-sm " placeholder="Lead Source">
                            <?php SUGGEST("leads", "LeadPersonSource", "ASC"); ?>
                          </div>
                        </div>
                        <div class="mt-2">
                          <button type="submit" name="GetLeadsFrom" value="true" class="btn btn-md btn-dark"><i class="fa fa-refresh"></i> Fetch leads</button>
                        </div>
                      </form>
                    </div>
                    <div class="col-md-6 ">

                      <h5 class="app-sub-heading">Available Leads</h5>
                      <?php

                      if (isset($_GET['GetLeadsFrom'])) {
                        $GetLeadsFrom = $_GET['GetLeadsFrom'];
                        $From = $_GET['From'];
                        $LeadPersonStatus = $_GET['LeadPersonStatus'];
                        $LeadPriorityLevel = $_GET['LeadPriorityLevel'];
                        $LeadPersonSource = $_GET['LeadPersonSource'];

                        //store request parameters into session 
                        $_SESSION['GetLeadsFrom'] = $GetLeadsFrom;
                        $_SESSION['From'] = $From;
                        $_SESSION['LeadPersonStatus'] = $LeadPersonStatus;
                        $_SESSION['LeadPriorityLevel'] = $LeadPriorityLevel;
                        $_SESSION['LeadPersonSource'] = $LeadPersonSource;

                        //run last requested parameters and get data accordingly
                      } elseif (isset($_SESSION['GetLeadsFrom'])) {
                        $GetLeadsFrom = $_SESSION['GetLeadsFrom'];
                        $From = $_SESSION['From'];
                        $LeadPersonStatus = $_SESSION['LeadPersonStatus'];
                        $LeadPriorityLevel = $_SESSION['LeadPriorityLevel'];
                        $LeadPersonSource = $_SESSION['LeadPersonSource'];

                        //make null for request parameters in case of no selection
                      } else {
                        $GetLeadsFrom = '';
                        $From = '';
                        $LeadPersonStatus = '';
                        $LeadPriorityLevel = '';
                        $LeadPersonSource = '';
                      }
                      ?>
                      <form>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="flex-s-b">
                              <div class="form-group w-100">
                                <label>Search Person</label>
                                <input type="search" oninput="SearchData('searching_leads', 'lead-lists')" id='searching_leads' placeholder="Enter Full Name" value='<?php echo IfRequested("GET", "search_leads", "", false); ?>' class="form-control " list="LeadPersonFullname" name="search_leads">
                                <?php SQL_SUGGEST("SELECT * FROM leads where LeadPersonManagedBy='$From' ORDER BY LeadPersonFullname ASC", "LeadPersonFullname"); ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                      <?php
                      //get lead data
                      if (isset($_GET['search_leads'])) {
                        $search_leads = $_GET['search_leads'];
                        $CountTotalLeads = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonFullname like '%$search_leads%' and LeadPersonManagedBy='$From' and LeadPersonSource like '%$LeadPersonSource%' and LeadPriorityLevel like '%$LeadPriorityLevel%' and LeadPersonStatus LIKE '%$LeadPersonStatus%' GROUP BY LeadsId ORDER by LeadsId DESC");
                      } else {
                        $CountTotalLeads = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$From' and LeadPersonSource like '%$LeadPersonSource%' and LeadPriorityLevel like '%$LeadPriorityLevel%' and LeadPersonStatus LIKE '%$LeadPersonStatus%' GROUP BY LeadsId ORDER by LeadsId DESC");
                      }
                      $TotalItems = $CountTotalLeads;

                      $start = START_FROM;
                      $listcounts = DEFAULT_RECORD_LISTING;

                      if (isset($_GET['search_leads'])) {
                        $search_leads = $_GET['search_leads'];
                        $GetLeads = _DB_COMMAND_("SELECT LeadPersonPhoneNumber, LeadPriorityLevel, LeadPersonSource, LeadPersonManagedBy, LeadSalutations, LeadPersonFullname, LeadPersonStatus, LeadsId, LeadPersonCreatedBy  FROM leads WHERE LeadPersonFullname like '%$search_leads%' and LeadPersonManagedBy='$From' and LeadPersonSource like '%$LeadPersonSource%' and LeadPriorityLevel like '%$LeadPriorityLevel%'  and LeadPersonStatus LIKE '%$LeadPersonStatus%' GROUP BY LeadsId ORDER by LeadsId DESC", true);
                      } else {
                        $GetLeads = _DB_COMMAND_("SELECT LeadPersonPhoneNumber, LeadPriorityLevel, LeadPersonSource, LeadPersonManagedBy, LeadSalutations, LeadPersonFullname, LeadPersonStatus, LeadsId, LeadPersonCreatedBy  FROM leads WHERE LeadPersonManagedBy='$From' and LeadPersonSource like '%$LeadPersonSource%' and LeadPriorityLevel like '%$LeadPriorityLevel%'  and LeadPersonStatus LIKE '%$LeadPersonStatus%' GROUP BY LeadsId ORDER by LeadsId DESC", true);
                      }
                      $Count = SERIAL_NO;
                      ?>
                      <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST">
                        <?php FormPrimaryInputs(true, [
                          "From" => IfRequested("GET", "From", "", false),
                          "LeadPersonSubStatus" => IfRequested("GET", "LeadPersonSubStatus", "", false),
                          "LeadPersonStatus" => IfRequested("GET", "LeadPersonStatus", "", false),
                          "LeadPriorityLevel" => IfRequested("GET", "LeadPriorityLevel", "", false),
                          "LeadPersonSource" => IfRequested("GET", "LeadPersonSource", "", false)
                        ]); ?>
                        <?php
                        if ($GetLeads != null && isset($_GET['GetLeadsFrom'])) {


                          echo "
                                  <h6 class='mb-2 mt-0 ml-2 bold'>
                                  Select leads for move : <b class='text-danger'>Total <b>$CountTotalLeads</b> leads found!</b>
                                  </h6>
                                  <div class='data-display'>
                                  <div class='data-calling'>
                                  <ul loading='lazy'>";
                          foreach ($GetLeads as $leads) {
                            $Count++;
                            $LeadPersonCreatedBy = $leads->LeadPersonCreatedBy;
                            $LeadsId = $leads->LeadsId;
                            $FollowUpsSQL = "SELECT LeadFollowUpDate, LeadFollowUpTime FROM lead_followups where LeadFollowMainId='$LeadsId'";
                            $LeadFollowUpDate = FETCH($FollowUpsSQL, "LeadFollowUpDate");
                            $LeadFollowUpTime = FETCH($FollowUpsSQL, "LeadFollowUpTime");
                            $lead_requirements = CHECK("SELECT * FROM lead_requirements where leadMainId='$LeadsId'");
                            include "../../../include/common/send-lead-list.php";
                          }
                          echo "</ul></div></div>";
                        } else {
                          NoData("No Leads Found!");
                        }
                        ?>
                    </div>
                    <div class="col-md-3">
                      <h5 class="app-sub-heading">Move Leads In</h5>
                      <?php if (isset($_GET['GetLeadsFrom'])) { ?>
                        <div class="form-group">
                          <label>Move Leads From</label>
                          <?php echo GetUserDetails($From); ?>
                        </div>
                        <div class="form-group">
                          <label>Move Leads In</label>
                          <select class="form-control form-control-sm " name="LeadPersonManagedBy" required="">
                            <option value="" disabled>Select User</option>
                            <?php  ?>
                            <?php
                            $Users = _DB_COMMAND_("SELECT * FROM users, company_users where users.UserId=company_users.company_alloted_user_id and users.UserStatus='1' and company_users.company_user_created_by='" . AuthAppUser("UserId") . "' ORDER BY UserFullName ASC", true);
                            foreach ($Users as $User) {

                              if ($User->UserId == AuthAppUser('UserId')) {
                                $selected = "selected";
                              } else {
                                $selected = "";
                              }
                              echo "<option value='" . $User->UserId . "' " . $selected . ">" . $User->UserFullName . " @ " . $User->UserPhoneNumber . " - " . FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $User->UserId . "'", "UserEmpGroupName") . "</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>Bulk Number of leads</label>
                          <input type='number' name='NumberOfLeads' value='0' class='form-control form-control-sm' min='0' max='<?php echo $TotalItems + 1; ?>'>
                        </div>
                        <div class="form-group">
                          <label>Order Of Selection</label>
                          <select name='OrderOfSelection' class='form-control form-control-sm'>
                            <option value='ASC'>DESC</option>
                            <option value='DESC' selected>ASC</option>
                          </select>
                        </div>
                        <div class="mt-2">
                          <button type="submit" onclick="form.submit()" name="MoveLeads" class="btn btn-md btn-success"> Move leads <i class="fa fa-exchange"></i></button>
                        </div>
                      <?php } else { ?>
                        <p>Please fetch some leads firsts..</p>
                      <?php } ?>

                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </section>
    </div>
    <?php
    include $Dir . "/include/footer.php"; ?>
  </div>
  <script>
    function CallStatusFunction() {
      var statustype = document.getElementById("statustype");
      var leasstatus = document.getElementById("leasstatus");
      leasstatus.value = statustype.value;
      console.log("Selected value: " + leasstatus.value);
    }
  </script>
  <?php include $Dir . "/assets/FooterFilesLoader.php"; ?>
</body>

</html>