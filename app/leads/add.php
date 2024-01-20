<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


$UserID = AuthAppUser("UserId");
$MainCompanyId = FETCH("SELECT * FROM company_users WHERE company_alloted_user_id='$UserID'", "company_main_id");
$CompanyTableDetails = "SELECT * FROM config_companies WHERE company_id='$MainCompanyId'";
$companyID = FETCH($CompanyTableDetails, "company_id");

//pagevariables
$PageName = "ADD New Lead";
$PageDescription = "Manage all leads";
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
      document.getElementById("leads").classList.add("active");
      document.getElementById("leads_add").classList.add("active");
    }
    window.onload = SidebarActive;
  </script>
  <style>
    .form-group {
      margin-bottom: 0px !important;
    }
  </style>
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
          <div class="card">
            <div class="card-body">
              <form action=" <?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST">
                <div class="row mb-5px">
                  <div class="col-md-12 flex-s-b">
                    <a href='index.php' class="btn btn-md btn-default mt-3"><i class="fa fa-angle-left"></i> Back to All Leads</a>
                    <button class="btn btn-md btn-success" name="CreateLeads" TYPE="submit"><i class="fa fa-check"></i> Save Lead Record</button>
                  </div>
                </div>
                <?php FormPrimaryInputs(true); ?>
                <div class="row">
                  <div class="col-md-4">
                    <h4 class="app-heading">New Lead Details</h4>
                    <div class="row mb-5px">
                      <div class="form-group col-md-4">
                        <label>Salutation</label>
                        <select name="LeadSalutations" class="form-control form-control-sm">
                          <option value="Mr." selected>Mr</option>
                          <option value="Mrs.">Mrs</option>
                          <option value="Miss.">Miss</option>
                          <option value="Ms.">Ms</option>
                          <option value="Dr.">Dr</option>
                          <option value="Prof.">Prof</option>
                          <option value="Sir.">Sir</option>
                        </select>
                      </div>
                      <div class="form-group col-md-8">
                        <label>Full Name</label>
                        <input type="text" name="LeadPersonFullname" list="LeadPersonFullname" class="form-control form-control-sm" placeholder="Gaurav Singh" required="">
                      </div>
                      <div class="form-group col-md-5">
                        <label>Phone Number</label>
                        <input type="phone" name="LeadPersonPhoneNumber" list="LeadPersonPhoneNumber" placeholder="without +91" class="form-control form-control-sm" required="">
                        <!-- <?php //SUGGEST("leads", "LeadPersonPhoneNumber", "ASC"); 
                              ?> -->
                      </div>
                      <div class="form-group col-md-7">
                        <label>Email</label>
                        <input type="email" name="LeadPersonEmailId" list="LeadPersonEmailId" class="form-control form-control-sm" placeholder="example@domain.tld">
                      </div>

                    </div>
                    <div class="row mb-5px">
                      <div class="form-group col-md-12">
                        <label>Address</label>
                        <textarea name="LeadPersonAddress" row="3" class="form-control form-control-sm" placeholder="Address"></textarea>
                      </div>
                    </div>


                    <div class="row mb-5px">
                      <div class="form-group col-md-12">
                        <label>Remarks</label>
                        <textarea name="LeadPersonNotes" class="form-control form-control-sm editor" rows="3"></textarea>
                      </div>
                    </div>
                    <div class="row mb-5px">
                      <div class="form-group col-md-6">
                        <label>Lead Assigned To</label>
                        <select class="form-control form-control-sm" name="LeadPersonManagedBy">
                          <?php
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
                        <label>Lead Source </label>
                        <select class="form-control form-control-sm" name="LeadPersonSource">
                          <?php CONFIG_VALUES("LEAD_SOURCES"); ?>
                        </select>
                      </div>
                    </div>

                    <div class="row mb-5px">
                      <div class="col-md-12">
                        <hr>
                      </div>
                    </div>

                  </div>
                  <div class="col-md-4">
                    <h4 class="app-heading">Interested in</h4>
                    <input type="search" name="search" id="search" class="form-control form-control-sm form-control-lg" oninput="SearchData('search', 'records-list')" placeholder="Search Requirements">
                    <div class="height-limit p-1">
                      <ul class="calling-list">
                        <?php
                        $Requirement = _DB_COMMAND_("SELECT * FROM projects where CompanyID='$companyID'", true);
                        // var_dump($Requirement);
                        if ($Requirement != null) {
                          foreach ($Requirement as $List) {
                            $ProjectType = FETCH("SELECT * FROM config_values where CompanyID='$companyID' and ConfigValueId='" . $List->ProjectTypeId . "'", "ConfigValueDetails");
                            echo "
                        <li class='records-list'>
                  <div class='form-check form-check-inline'>
                  <input class='form-check-input radio-list mt-0' type='radio' name='LeadRequirementDetails[]' value='" . $List->ProjectsId  . "'>
                  <h6 class='form-check-label fs-16 mb-0'>" . $List->ProjectName . "</h6>
                  </div>
                  </li>
                 ";
                          }
                        } else {
                          NoData("<b>No Interest Found!</b><br> Please add some Projects");
                        } ?>
                      </ul>
                    </div>
                    <hr>
                    <!-- <h4 class='app-heading mt-5px mt-4'>Add New Details</h4> -->
                    <!-- <div class="row">
                      <div class="col-md-12 form-group">
                        <select class="form-control form-control-sm" name="ProjectTypeId">
                          <option value="0">Select Details Type</option>
                          <?php
                          // $ProjectTypes = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='PROJECT_TYPES'", true);
                          //if ($ProjectTypes != null) {
                          foreach ($ProjectTypes as $Types) {
                          ?> <option value="<?php echo $Types->ConfigValueId; ?>"> <?php echo $Types->ConfigValueDetails; ?></option>
                          <?php }
                          // } else {
                          //   echo "<option value='0'>No Data Available</option>";
                          // }
                          ?>
                        </select>
                      </div>
                      <div class="col-md-12 form-group">
                        <input type="text" class="form-control form-control-sm" name="ProjectName" placeholder="Enter Name">
                      </div>
                      <div class="col-md-12 form-group">
                        <textarea class="form-control form-control-sm" name="ProjectDescriptions" rows="3" placeholder="Enter Description"></textarea>
                      </div>
                    </div> -->
                  </div>
                  <div class="col-md-4">
                    <h4 class="app-heading">Add Feedback</h4>
                    <!-- <input type="text" id="leascurrentstatus" name="LeadFollowCurrentStatus" value=""> -->
                    <div class="row">
                      <div class="col-md-12">

                        <div class="row">
                          <div class="col-md-12">
                            <div class="row text-center">
                              <div class="col-md-12 text-center">
                                <p><b>Was Call Connected?</b></p>
                              </div>
                              <div class="form-group col-md-6 mt-2">
                                <span id="call_not_connected" class="btn btn-default w-100">Not Connected?</span>
                              </div>
                              <div class="form-group col-md-6 mt-2">
                                <span id="call_connected" class="btn btn-default w-100">Yes, Connected?</span>
                              </div>
                              <div class="row w-100 text-left hidden" id="call_not_connected_box">
                                <div class="col-md-12">
                                  <hr>
                                  <p><b>Please specify the reason?</b></p>
                                  <hr>
                                </div>
                                <div class="col-md-6  ml-3">
                                  <input type="Radio" value="Out Of Coverage Area" name="LeadFollowStatus"> Out Of Coverage Area<br>
                                  <input type="Radio" value="Switch Off" name="LeadFollowStatus"> Switch Off <br>
                                  <input type="Radio" value="Number Dose not Exist" name="LeadFollowStatus"> Number Dose not Exist <br>
                                  <input type="Radio" value="Out of Validity" name="LeadFollowStatus"> Out of Validity <br>
                                  <input type="Radio" value="Not Picked" name="LeadFollowStatus"> Not Picked<br>
                                </div>
                                <div id="calldesc" class="col-md-12">
                                  <div class="form-group text-left">
                                    <label>Notes/Remark</label>
                                    <textarea class="form-control" name="LeadFollowUpDescriptions" rows="2"></textarea>
                                  </div>
                                </div>
                              </div>
                              <div class="row w-100 text-left hidden" id="call_connected_box">
                                <div class="col-md-12">
                                  <hr>
                                  <p><b>Please specify the reason?</b></p>
                                  <hr>
                                </div>
                                <div class="col-md-5 ml-3">
                                  <?php
                                  $UserID = AuthAppUser("UserId");
                                  $companyID = FETCH("SELECT * FROM company_users WHERE company_alloted_user_id='$UserID'", "company_main_id");
                                  $CallStatus = _DB_COMMAND_("SELECT * FROM configs, config_values WHERE configs.ConfigsId=config_values.ConfigValueGroupId AND configs.ConfigsId='7' AND config_values.CompanyID='$companyID' ORDER BY ConfigValueId ASC", true);
                                  if ($CallStatus != null) {
                                    foreach ($CallStatus as $Status) {
                                      $configValueDetails = $Status->ConfigValueDetails;
                                      echo '<input type="radio" value="' . $configValueDetails . '" name="LeadFollowStatus" onclick="checkFollowUp(this)"> ' . $configValueDetails . '<br>';
                                    }
                                  } else {
                                    NoData("Add Call Status!!");
                                  }
                                  ?>
                                </div>
                                <!-- <div class="col-md-5 ml-3">
                                  <input type="Radio" value="Call Back" name="LeadFollowStatus"> Call Back<br>
                                  <input type="Radio" value="Ringing " name="LeadFollowStatus"> Ringing <br>
                                  <input type="Radio" value="Not Picked" name="LeadFollowStatus"> Not Picked<br>
                                  <input type="Radio" value="Not Interested" name="LeadFollowStatus"> Not Interested <br>
                                  <input type="Radio" value=" Already Taken" name="LeadFollowStatus"> Already Taken <br>
                                  <input type="Radio" value="Junk Call" name="LeadFollowStatus"> Junk Call<br>
                                </div> -->
                                <div class="col-md-12 m-2">
                                  <label for="set_reminder" id="followup" class="btn btn-info hidden">
                                    <input id="set_reminder" name="mycheckbtn" type="checkbox" style="display: none;">SET REMINDER
                                  </label>
                                  <div class="col-md-12 hidden mt-3" id="reminder_box">
                                    <label class="btn btn-default m-1">
                                      <input type="radio" name="predefinetime" value="15min">
                                      <span>15 min</span>
                                    </label>
                                    <label class=" btn btn-default m-1">
                                      <input type="radio" name="predefinetime" value="Tomorrow">
                                      <span>Tomorrow</span>
                                    </label>
                                    <label class="btn btn-default m-1">
                                      <input type="radio" name="predefinetime" value="NextWeek">
                                      <span>Next Week</span>
                                    </label>
                                    <span class="btn btn-default ml-1" id="Show_Time_Box">Other</span>
                                    <label class=" m-1 hidden" id="Time_Box">
                                      <span class="d-flex feedbackspan">
                                        <input type="date" name="LeadFollowUpDate" class="form-control form-control-sm" value="<?php echo date("Y-m-d"); ?>">
                                        <input type="time" name="LeadFollowUpTime" value="<?php echo DATE("H:i", strtotime("+5 min")); ?>" class="form-control form-control-sm"></span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-12 m-2">
                                  <div class="form-group">
                                    <label>Lead Priority level </label>
                                    <select class="form-control form-control-sm" name="LeadPriorityLevel">
                                      <?php CONFIG_VALUES("LEAD_PERIORITY_LEVEL", 'HIGH'); ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-12 m-2">
                                  <div id="calldesc">
                                    <div class="form-group text-left">
                                      <label>Notes/Remark</label>
                                      <textarea class="form-control" name="LeadFollowUpDescriptions" rows="2"></textarea>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <!-- <div id="call_schedule" style="display:none;">
                          <div class="row">
                            <div class="col-md-6 form-group">
                              <label>Date</label>
                              <input type="date" name="LeadFollowUpDate" class="form-control form-control-sm" value="<?php echo date("Y-m-d"); ?>">
                            </div>
                            <div class="col-md-6 form-group">
                              <label>Time</label>
                              <input type="time" name="LeadFollowUpTime" value="<?php //echo DATE("H:i", strtotime("+5 min")); 
                                                                                ?>" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-12">
                              <label>Remind Note</label>
                              <textarea class="form-control form-control-sm" id='remindnote' name="LeadFollowUpRemindNotes" rows="2"></textarea>
                            </div>
                          </div>
                        </div> -->

                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <script>
            function CheckCallStatus() {
              var call_status = document.getElementById("call_status");
              if (call_status.value == "FollowUp" ||
                call_status.value == "Follow Up" ||
                call_status.value == "follow up" ||
                call_status.value == "Follow up") {
                document.getElementById("call_reminder").classList.remove("hidden");
              } else {
                document.getElementById("call_reminder").classList.add("hidden");
              }
            }
          </script>
        </div>
      </section>
    </div>

    <?php include $Dir . "/include/footer.php"; ?>
    <script>
      function CallStatusFunction() {
        var statustype = document.getElementById("statustype");
        <?php
        $FetchCallStatus = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='CALL_STATUS' ORDER BY ConfigValueId DESC", true);
        if ($FetchCallStatus != null) {
          foreach ($FetchCallStatus as $CallStatus) { ?>
            if (statustype.value == <?php echo $CallStatus->ConfigValueId; ?>) {
              document.getElementById("view_<?php echo $CallStatus->ConfigValueId; ?>").style.display = "block";

            } else {
              document.getElementById("view_<?php echo $CallStatus->ConfigValueId; ?>").style.display = "none";
            }

            if (statustype.value == "50") {
              document.getElementById("call_schedule").style.display = "block";
              document.getElementById("calldesc").style.display = "none";
              document.getElementById("remindnote").setAttribute("required", true);
            } else {
              document.getElementById("call_schedule").style.display = "none";
              document.getElementById("calldesc").style.display = "block";
              document.getElementById("remindnote").removeAttribute("required");
            }
        <?php }
        } ?>
      }
    </script>
    <script>
      var Notconnected = document.getElementById("call_not_connected");
      var Connected = document.getElementById("call_connected");
      var NotconnectedBox = document.getElementById("call_not_connected_box");
      var ConnectedBox = document.getElementById("call_connected_box");
      var Reminder = document.getElementById("set_reminder");
      var ReminderBox = document.getElementById("reminder_box");
      Notconnected.addEventListener("click", function() {
        NotconnectedBox.classList.toggle("hidden");
        Notconnected.classList.remove("btn-default");
        Connected.classList.remove("btn-primary");
        Notconnected.classList.add("btn-primary");
        ConnectedBox.classList.add("hidden");
        Connected.classList.add("btn-default");
      });
      Connected.addEventListener("click", function() {
        // Remove the "hidden" class from ConnectedBox
        ConnectedBox.classList.toggle("hidden");
        Connected.classList.remove("btn-default");
        Notconnected.classList.remove("btn-primary");
        Connected.classList.add("btn-primary");
        NotconnectedBox.classList.add("hidden");
        Notconnected.classList.add("btn-default");
      });

      function checkFollowUp(radio) {
        if (radio.value.toUpperCase() === "FOLLOW-UP" || radio.value.toUpperCase() === "MEETING PLANNED" || radio.value.toUpperCase() === "SITE VISIT PLANNED") {
          var FollowUp = document.getElementById('followup');
          FollowUp.classList.remove("hidden");
        } else {
          var FollowUp = document.getElementById('followup');
          FollowUp.classList.add("hidden");
        }
      }

      Reminder.addEventListener("click", function() {
        ReminderBox.classList.toggle("hidden");

      });
      var ShowTimeBox = document.getElementById("Show_Time_Box");
      var TimeBox = document.getElementById("Time_Box");
      ShowTimeBox.addEventListener("click", function() {
        TimeBox.classList.toggle("hidden");

      });
    </script>
  </div>

  <?php include $Dir . "/assets/FooterFilesLoader.php"; ?>

</body>

</html>