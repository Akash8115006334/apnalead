<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Member lead Details";
$PageDescription = "Manage all customers";


$REQ_UserId = $_SESSION['TEAM_UserId'];

$UserId = $REQ_UserId;
include "common/lead-count.php";
$PageSqls = "SELECT * FROM users where UserId='$REQ_UserId'";
$EmployementSQL = "SELECT * FROM user_employment_details where UserMainUserId='$REQ_UserId'";
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8" />
   <title><?php echo FETCH($PageSqls, "UserSalutation"); ?> <?php echo FETCH($PageSqls, "UserFullName"); ?> | <?php echo APP_NAME; ?></title>
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
                                          <?php echo FETCH($PageSqls, "UserSalutation"); ?>
                                       </span> <?php echo FETCH($PageSqls, "UserFullName"); ?>
                                    </h4>
                                    <p class="display-6">
                                       <span><b>Phone Number :</b> <?php echo FETCH($PageSqls, "UserPhoneNumber"); ?></span><br>
                                       <span><b>Email-ID :</b> <?php echo FETCH($PageSqls, "UserEmailId"); ?></span><br>
                                       <span><b>DOB :</b> <?php echo DATE_FORMATES("d M, Y", FETCH($PageSqls, "UserDateOfBirth")); ?></span><br>
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
                                          <a href="../../team/details/?uid=<?php echo SECURE($REQ_UserId, "e"); ?>" class="btn btn-sm btn-dark"><i class="fa fa-edit"></i> Edit Profile</a>
                                       </div>
                                    <?php } ?>
                                    <?php if (AuthAppUser("UserType") == "Admin" || AuthAppUser("UserType") == "Hr") { ?>
                                       <a href="../index.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> View All Team</a>
                                    <?php } ?>
                                 </div>
                              </div>

                              <div class="col-md-8">
                                 <div class="row">
                                    <div class="col-md-4 col-6 mb-10px">
                                       <a href="leads.php">
                                          <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                             <div class="flex-s-b">
                                                <h2 class="count text-primary mb-0 m-t-5 h1">
                                                   <?php echo $Leads; ?>
                                                </h2>
                                                <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                   <span class="fs-11">Today : </span><span class="fs-13 count">
                                                      <?php echo $LeadsToday; ?>
                                                   </span><br>
                                                   <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                      <?php echo $LeadsYesterday; ?>
                                                   </span>
                                                </span>
                                             </div>
                                             <p class="mb-0 fs-12 text-black">All Leads</p>
                                          </div>
                                       </a>
                                    </div>

                                    <div class="col-md-4 col-6 mb-10px">
                                       <a href="leads.php?view=Fresh Lead">
                                          <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                             <div class="flex-s-b">
                                                <h2 class="count text-primary mb-0 m-t-5 h1">
                                                   <?php echo $AllFreshLeads; ?>
                                                </h2>
                                                <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                   <span class="fs-11">Today : </span><span class="fs-13 count">
                                                      <?php echo $AllFreshLeadsToday; ?>
                                                   </span><br>
                                                   <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                      <?php echo $AllFreshLeadsYesterday; ?>
                                                   </span>
                                                </span>
                                             </div>
                                             <p class="mb-0 fs-12 text-black"> FRESH LEADS</p>
                                          </div>
                                       </a>
                                    </div>

                                    <div class="col-md-4 col-6 mb-10px">
                                       <a href="leads.php?view=FOLLOW-UP">
                                          <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                             <div class="flex-s-b">
                                                <h2 class="count text-primary mb-0 m-t-5 h1">
                                                   <?php echo $AllFollowUpLeads; ?>
                                                </h2>
                                                <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                   <span class="fs-11">Today : </span><span class="fs-13 count">
                                                      <?php echo $AllFollowUpLeadsToday; ?>
                                                   </span><br>
                                                   <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                      <?php echo $AllFollowUpLeadsYesterday; ?>
                                                   </span>
                                                </span>
                                             </div>
                                             <p class="mb-0 fs-12 text-black">TOTAL FOLLOW UPS</p>
                                          </div>
                                       </a>
                                    </div>

                                    <div class="col-md-4 col-6 mb-10px">
                                       <a href="leads.php?sub_status=MEETING PLANNED">
                                          <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                             <div class="flex-s-b">
                                                <h2 class="count text-primary mb-0 m-t-5 h1">
                                                   <?php echo $AllSiteVisitPlannedLeads; ?>
                                                </h2>
                                                <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                   <span class="fs-11">Today : </span><span class="fs-13 count">
                                                      <?php echo $AllSiteVisitPlannedLeadsToday; ?>
                                                   </span><br>
                                                   <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                      <?php echo $AllSiteVisitPlannedLeadsYesterday; ?>
                                                   </span>
                                                </span>
                                             </div>
                                             <p class="mb-0 fs-12 text-black">SITE VISITS PLANNED</p>
                                          </div>
                                       </a>
                                    </div>

                                    <div class="col-md-4 col-6 mb-10px">
                                       <a href="leads.php?sub_status=RINGING">
                                          <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                             <div class="flex-s-b">
                                                <h2 class="count text-primary mb-0 m-t-5 h1">
                                                   <?php echo $AllRingingLeads; ?>
                                                </h2>
                                                <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                   <span class="fs-11">Today : </span><span class="fs-13 count">
                                                      <?php echo $AllRingingToday; ?>
                                                   </span><br>
                                                   <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                      <?php echo $AllRingingYesterday; ?>
                                                   </span>
                                                </span>
                                             </div>
                                             <p class="mb-0 fs-12 text-black">ALL RINGING CALL</p>
                                          </div>
                                       </a>
                                    </div>

                                    <div class="col-md-4 col-6 mb-10px">
                                       <a href="leads.php?sub_status=MEETING DONE">
                                          <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                             <div class="flex-s-b">
                                                <h2 class="count text-primary mb-0 m-t-5 h1">
                                                   <?php echo $AllSiteVisitDoneLeads; ?>
                                                </h2>
                                                <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                   <span class="fs-11">Today : </span><span class="fs-13 count">
                                                      <?php echo $AllSiteVisitPlannedLeadsToday; ?>
                                                   </span><br>
                                                   <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                      <?php echo $AllSiteVisitPlannedLeadsYesterday; ?>
                                                   </span>
                                                </span>
                                             </div>
                                             <p class="mb-0 fs-12 text-black">SITE VISITS DONE</p>
                                          </div>
                                       </a>
                                    </div>
                                    <div class="col-md-4 col-6 mb-10px">
                                       <a href="leads.php?view=Registration">
                                          <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                             <div class="flex-s-b">
                                                <h2 class="count text-primary mb-0 m-t-5 h1">
                                                   <?php echo $AllRegistrationsLeads; ?>
                                                </h2>
                                                <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                   <span class="fs-11">Today : </span><span class="fs-13 count">
                                                      <?php echo $AllRegistrationsLeadsToday; ?>
                                                   </span><br>
                                                   <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                      <?php echo $AllRegistrationsLeadsYesterday; ?>
                                                   </span>
                                                </span>
                                             </div>
                                             <p class="mb-0 fs-12 text-black">REGISTATION</p>
                                          </div>
                                       </a>
                                    </div>

                                    <!-- <div class="col-md-4 col-6 mb-10px">
                                       <a href="leads.php?view=Sale Close">
                                          <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                             <div class="flex-s-b">
                                                <h2 class="count text-primary mb-0 m-t-5 h1">
                                                   <?php echo $AllSaleClosedLeads; ?>
                                                </h2>
                                                <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                   <span class="fs-11">Today : </span><span class="fs-13 count">
                                                      <?php echo $AllSaleClosedLeadsToday; ?>
                                                   </span><br>
                                                   <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                      <?php echo $AllSaleClosedLeadsYesterday; ?>
                                                   </span>
                                                </span>
                                             </div>
                                             <p class="mb-0 fs-12 text-black">SALE CLOSED</p>
                                          </div>
                                       </a>
                                    </div> -->

                                    <div class="col-md-4 col-6 mb-10px">
                                       <a href="leads.php?view=Not Interested">
                                          <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                             <div class="flex-s-b">
                                                <h2 class="count text-primary mb-0 m-t-5 h1">
                                                   <?php echo $AllNullLeads; ?>
                                                </h2>
                                                <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                   <span class="fs-11">Today : </span><span class="fs-13 count">
                                                      <?php echo $AllNullLeadsToday; ?>
                                                   </span><br>
                                                   <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                      <?php echo $AllNullLeadsYesterday; ?>
                                                   </span>
                                                </span>
                                             </div>
                                             <p class="mb-0 fs-12 text-black">NOT INTERESTED</p>
                                          </div>
                                       </a>
                                    </div>

                                    <div class="col-md-4 col-6 mb-10px">
                                       <a href="leads.php?view=junk">
                                          <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                             <div class="flex-s-b">
                                                <h2 class="count text-primary mb-0 m-t-5 h1">
                                                   <?php echo $AllJunkLeads; ?>
                                                </h2>
                                                <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                   <span class="fs-11">Today : </span><span class="fs-13 count">
                                                      <?php echo $AllJunkLeadsToday; ?>
                                                   </span><br>
                                                   <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                      <?php echo $AllJunkLeadsYesterday; ?>
                                                   </span>
                                                </span>
                                             </div>
                                             <p class="mb-0 fs-12 text-black">JUNKS</p>
                                          </div>
                                       </a>
                                    </div>

                                 </div>
                                 <?php if (isset($_GET['type'])) {
                                    $ListHeading = "All "  . ucfirst(str_replace("_", " ", $_GET['type']))  . "";
                                 } elseif (isset($_GET['sub_status'])) {
                                    $ListHeading = "All " . $_GET['sub_status'];
                                 } elseif (isset($_GET['view'])) {
                                    $ListHeading = "All "  . $_GET['view'];
                                 } else {
                                    $ListHeading = "All Leads";
                                 } ?>
                                 <h4 class="app-heading"> <?php echo $ListHeading; ?></h4>
                                 <div class="row">
                                    <?php
                                    if (isset($_GET['view'])) {
                                       $view = $_GET['view'];
                                       $GetLeads = _DB_COMMAND_("SELECT * FROM leads where LeadPersonStatus LIKE '%$view%' and LeadPersonManagedBy='$REQ_UserId' GROUP BY LeadsId ORDER by LeadsId DESC", true);
                                    } elseif (isset($_GET['sub_status'])) {
                                       $sub_status = $_GET['sub_status'];
                                       $GetLeads = _DB_COMMAND_("SELECT * FROM leads where LeadPersonSubStatus like '%$sub_status%' and LeadPersonManagedBy='$REQ_UserId' GROUP BY LeadsId ORDER by LeadsId DESC", true);
                                    } else {
                                       $GetLeads = _DB_COMMAND_("SELECT * FROM leads where LeadPersonManagedBy='$REQ_UserId' GROUP BY LeadsId ORDER by LeadsId DESC", true);
                                    }
                                    if ($GetLeads == null) {
                                    ?>
                                       <div class="col-md-12">
                                          <div class="card card-body border-0 shadow-sm">
                                             <div class="text-left">
                                                <h1><i class="fa fa-globe fa-spin display-4 text-success"></i></h1>
                                                <h4 class="text-muted">No leads found</h4>
                                                <p class="text-muted">You can add a new lead by clicking the button above.</p>
                                                <a href="add.php" class="btn btn-md btn-primary">Add leads</a>
                                             </div>
                                          </div>
                                       </div>
                                       <?php } else {
                                       $Count = 0;
                                       foreach ($GetLeads as $leads) {
                                          $Count++;
                                          $LeadPersonCreatedBy = $leads->LeadPersonCreatedBy;
                                          $LeadsId = $leads->LeadsId;
                                          $FollowUpsSQL = "SELECT * FROM lead_followups where LeadFollowMainId='$LeadsId'";
                                          $LeadFollowUpDate = FETCH($FollowUpsSQL, "LeadFollowUpDate");
                                          $LeadFollowUpTime = FETCH($FollowUpsSQL, "LeadFollowUpTime");
                                       ?>
                                          <div class="col-md-12">
                                             <a class="w-100" href="lead-details.php?LeadsId=<?php echo SECURE($leads->LeadsId, "e"); ?>">
                                                <p class="data-list flex-s-b">
                                                   <span>
                                                      <span class="text-primary"><span class="right-btn-i"><?php echo $Count; ?></span>
                                                         <i class="fa fa-tag text-warning"></i>
                                                         <span><?php echo $leads->LeadSalutations; ?></span> <?php echo $leads->LeadPersonFullname; ?></span> |
                                                      <span><?php echo LeadStage($leads->LeadPersonStatus); ?></span> - <span><?php echo FETCH("SELECT * FROM lead_followups where LeadFollowMainId='" . $leads->LeadsId . "' ORDER BY LeadFollowUpId DESC", "LeadFollowCurrentStatus"); ?></span> |
                                                      <span style='margin-top:-1rem !important;'><?php echo LeadStatus($leads->LeadPriorityLevel); ?></span>
                                                   </span>
                                                   <span class="mt-2px">
                                                      <span class="italic text-warning"><?php echo $leads->LeadPersonSource; ?></span>
                                                      <span class='right-btn-i text-grey'>
                                                         <?php echo DATE_FORMATES("d M, Y", $leads->LeadPersonCreatedAt); ?>
                                                         <i class="fa fa-angle-right fs-15"></i>
                                                      </span>
                                                   </span>
                                                </p>
                                             </a>
                                          </div>
                                       <?php } ?>
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