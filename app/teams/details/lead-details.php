<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "lead Details";
$PageDescription = "Manage all customers";


$REQ_UserId = $_SESSION['TEAM_UserId'];
if (isset($_GET['LeadsId'])) {
  $REQ_LeadsId = SECURE($_GET['LeadsId'], "d");
  $_SESSION['REQ_LeadsId'] = $REQ_LeadsId;
} else {
  $REQ_LeadsId = $_SESSION['REQ_LeadsId'];
}

include "common/lead-count.php";
$TeamSqls = "SELECT * FROM users where UserId='$REQ_UserId'";
$EmployementSQL = "SELECT * FROM user_employment_details where UserMainUserId='$REQ_UserId'";
$PageSqls = "SELECT * FROM leads where LeadsId='$REQ_LeadsId'";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?php echo FETCH($TeamSqls, "UserSalutation"); ?> <?php echo FETCH($TeamSqls, "UserFullName"); ?> | <?php echo APP_NAME; ?></title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
  <meta name="keywords" content="<?php echo APP_NAME; ?>">
  <meta name="description" content="<?php echo SHORT_DESCRIPTION; ?>">
  <?php include $Dir . "/assets/HeaderFilesLoader.php"; ?>
  <script type="text/javascript">
    function SidebarActive() {
      document.getElementById("teams").classList.add("active");
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
                    <div class="col-md-12 mb-2">
                      <h4 class="app-heading"><?php echo $PageName; ?></h4>
                    </div>
                    <div class="col-md-4">
                      <div class="card p-2">
                        <h4>
                          <i class="fa fa-user"></i>
                          <span class='text-grey'>
                            <?php echo FETCH($TeamSqls, "UserSalutation"); ?>
                          </span> <?php echo FETCH($TeamSqls, "UserFullName"); ?>
                        </h4>
                        <p class="display-6">
                          <span><b>Phone Number :</b> <?php echo FETCH($TeamSqls, "UserPhoneNumber"); ?></span><br>
                          <span><b>Email-ID :</b> <?php echo FETCH($TeamSqls, "UserEmailId"); ?></span><br>
                          <span><b>DOB :</b> <?php echo DATE_FORMATES("d M, Y", FETCH($TeamSqls, "UserDateOfBirth")); ?></span><br>
                          <span><b>EMP Code :</b> <?php echo FETCH($EmployementSQL, "UserEmpJoinedId"); ?></span><br>
                          <span><b>EMP Background :</b> <?php echo FETCH($EmployementSQL, "UserEmpBackGround"); ?></span><br>
                          <span><b>Work Experience :</b> <?php echo FETCH($EmployementSQL, "UserEmpTotalWorkExperience"); ?></span><br>
                          <span><b>Blood Group :</b> <?php echo FETCH($EmployementSQL, "UserEmpBloodGroup"); ?></span><br>
                          <span><b>RERA ID :</b> <?php echo FETCH($EmployementSQL, "UserEmpReraId"); ?></span><br>
                          <span><b>CRM Status :</b> <?php echo FETCH($EmployementSQL, "UserEmpCRMStatus"); ?></span><br>
                          <span><b>Work Group :</b> <?php echo FETCH($EmployementSQL, "UserEmpGroupName"); ?></span><br>
                          <span><b>EMP Type :</b> <?php echo FETCH($EmployementSQL, "UserEmpType"); ?></span><br>
                          <span><b>Reporting Manager :</b>
                            <br>
                            <?php echo FETCH("SELECT * FROM users where UserId='" . FETCH($EmployementSQL, "UserEmpReportingMember") . "'", "UserFullName"); ?>
                          </span><br>
                        </p>
                        <hr>
                        <?php if (AuthAppUser("UserType") == "Admin" || AuthAppUser("UserType") == "Hr") { ?>
                          <div class="btn-group btn-group-sm">
                            <a href="../../users/details/?uid=<?php echo SECURE($REQ_UserId, "e"); ?>" class="btn btn-sm btn-dark"><i class="fa fa-edit"></i> Edit Profile</a>
                          </div>
                        <?php } ?>
                        <?php if (AuthAppUser("UserType") == "Admin" || AuthAppUser("UserType") == "Hr") { ?>
                          <a href="../index.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> View All Team</a>
                        <?php } ?>
                      </div>
                    </div>

                    <div class="col-md-8">
                      <div class="row mt-2">
                        <div class="col-md-12">
                          <a href="leads.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> Back to All Leads</a>
                          <a href="index.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> Back to Team</a>
                        </div>
                        <div class="col-md-6">
                          <h4 class="app-sub-heading">Lead Details</h4>
                          <div class="p-1 mt-3">
                            <div class="flex-start">
                              <h3><i class="fa fa-user"></i></h3>
                              <h4 class="ml-1 p-1"><?php echo FETCH($PageSqls, "LeadPersonFullname"); ?></h4>
                            </div>
                            <h5><?php echo LeadStage(FETCH($PageSqls, "LeadPersonStatus")); ?> <?php echo LeadStatus(FETCH($PageSqls, "LeadPriorityLevel")); ?></h5>
                            <p class="description mt-1 flex-column">
                              <span>
                                <?php echo PHONE(FETCH($PageSqls, "LeadPersonPhoneNumber"), "link", "text-black", "fa fa-phone text-primary"); ?>
                              </span><br>
                              <span>
                                <?php echo EMAIL(FETCH($PageSqls, "LeadPersonEmailId"), "link", "text-black", "fa fa-envelope text-danger"); ?>
                              </span><br>
                              <span>
                                <?php echo ADDRESS(FETCH($PageSqls, "LeadPersonAddress"), "link", "text-black", "fa fa-map-marker text-success"); ?>
                              </span>
                            </p>

                            <p class="flex-s-b mt-2">
                              <span>
                                <span class="text-grey">Created By</span><br>
                                <span class="team-list">
                                  <i class="fa fa-user"></i>
                                  <?php echo FETCH("SELECT * FROM users where UserId='" . FETCH($PageSqls, 'LeadPersonCreatedBy') . "'", "UserFullName"); ?>
                                </span>
                              </span>
                              <span>
                                <span class="text-grey">Managed By / Assigned To</span><br>
                                <span class="team-list">
                                  <i class="fa fa-user"></i>
                                  <?php echo FETCH("SELECT * FROM users where UserId='" . FETCH($PageSqls, 'LeadPersonManagedBy') . "'", "UserFullName"); ?>
                                </span>
                              </span>
                            </p>
                            <p class="desc flex-s-b mt-3">
                              <span>
                                <span class="text-grey">Created At</span><br>
                                <span class="text"><?php echo DATE_FORMATES("d M, Y", FETCH($PageSqls, "LeadPersonCreatedAt")); ?></span>
                              </span>

                              <span>
                                <span class="text-grey">Last Updated At</span><br>
                                <span class="text">
                                  <?php if (DATE_FORMATES("d M, Y", FETCH($PageSqls, "LeadPersonLastUpdatedAt")) ==  "01 Jan, 1970") {
                                    echo "No Update!";
                                  } else {
                                    echo DATE_FORMATES("d M, Y", FETCH($PageSqls, "LeadPersonLastUpdatedAt"));
                                  }; ?>
                                </span>
                              </span>
                            </p>

                            <p class="desc flex-s-b mt-3">
                              <span>
                                <span class="text-grey h2">Need & Requirements</span><br>
                                <span class="text">
                                  <?php
                                  $ProjectId = FETCH("SELECT * FROM lead_requirements WHERE LeadMainId='$REQ_LeadsId'", "LeadRequirementDetails");
                                  $ProjectName = FETCH("SELECT * FROM projects where ProjectsId='$ProjectId' or ProjectName='$ProjectId'", "ProjectName");
                                  if ($ProjectId == null) {
                                    echo "No Requirement";
                                  } else {
                                    echo $ProjectName;
                                  }; ?>
                                </span>
                              </span>
                            </p>

                            <p class="desc flex-s-b mt-3">
                              <span>
                                <span class="text-grey">Notes/Remarks</span><br>
                                <span class="text"><?php echo html_entity_decode(SECURE(FETCH($PageSqls, "LeadPersonNotes"), "d")); ?></span>
                              </span>
                            </p>
                          </div>
                        </div>


                        <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-12 data-display" style="box-shadow:none !important;padding:0px !important;">
                              <div class="rounded-2">
                                <h4 class="app-sub-heading bg-danger">Activity History</h4>
                                <ul class="calling-list pt-0">
                                  <?php
                                  $fetclFollowUps = _DB_COMMAND_("SELECT * FROM lead_followups where LeadFollowMainId='$REQ_LeadsId' ORDER BY LeadFollowUpId DESC", true);
                                  if ($fetclFollowUps != null) {
                                    foreach ($fetclFollowUps as $F) { ?>
                                      <li>
                                        <span><?php echo CallTypes("" . $F->LeadFollowUpCallType . ""); ?></span>
                                        <p>
                                          <span style="font-size:1rem;">
                                            <b class="text-grey"><?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpCreatedAt); ?></b> - <span class="text-grey" style="color:grey !important;"><?php echo $F->LeadFollowCurrentStatus; ?></span><br>
                                            <?php if ($F->LeadFollowStatus == "Follow Up" or $F->LeadFollowStatus == "follow Up" || $F->LeadFollowStatus == "FollowUp" || $F->LeadFollowStatus == "FOLLOW UP") { ?>
                                              <i class="fa fa-clock"></i>
                                            <?php } ?> <span class="text-grey"><?php echo $F->LeadFollowStatus; ?>
                                              <?php if (DATE_FORMATES("d M, Y", $F->LeadFollowUpDate) != "No Update") { ?>
                                                @ <span class="text-success"><?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpDate); ?> <?php echo $F->LeadFollowUpTime; ?></span>
                                              <?php } ?>
                                            </span>
                                          </span><br>
                                          <span style="font-size:1rem;">
                                            <span class="text-gray"><?php echo $F->LeadFollowUpDescriptions; ?></span>
                                            <br>
                                            <i style="font-size:1rem;" class="text-grey">By <?php echo FETCH("SELECT * FROM users where UserId='" . $F->LeadFollowUpHandleBy . "'", "UserFullName"); ?></i>
                                          </span>
                                        </p>
                                      </li>
                                  <?php
                                    }
                                  } else {
                                    NoData("No FollowUps or History Found!");
                                  } ?>
                                </ul>
                              </div>
                            </div>

                          </div>

                          <div class="lead-actions hidden">
                            <ul>
                              <li>
                                <a href="mailto:<?php echo FETCH($PageSqls, "LeadPersonEmailId"); ?>">
                                  <img src="<?php echo STORAGE_URL_D; ?>/tool-img/mail.jpg" style="width:50px;">
                                </a>
                              </li>
                              <li>
                                <a onclick="Databar('AddFollowUps')" href="tel:+91<?php echo FETCH($PageSqls, "LeadPersonPhoneNumber"); ?>">
                                  <img src="<?php echo STORAGE_URL_D; ?>/tool-img/call.png" style="width:50px;">
                                </a>
                              </li>
                              <li>
                                <a href="whatsapp://send?phone=91<?php echo FETCH($PageSqls, "LeadPersonPhoneNumber"); ?>&text=Hey <?php echo FETCH($PageSqls, "LeadPersonFullname"); ?>,">
                                  <img src="<?php echo STORAGE_URL_D; ?>/tool-img/whatsapp.png" style="width:50px;">
                                </a>
                              </li>
                            </ul>
                          </div>
                        </div>
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

    <?php include $Dir . "/include/footer.php"; ?>
  </div>

  <?php include $Dir . "/assets/FooterFilesLoader.php"; ?>

</body>

</html>