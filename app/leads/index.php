<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';
//pagevariables
$PageName = "All Leads";
$PageDescription = "Manage all Leads";
$btntext = "Add New Leads";
$DomainExpireInCurrentMonth = date("Y-m-d", strtotime("+1 month"));
//get company id
$UserID = AuthAppUser("UserId");
$companyID = CompanyId;
include "sections/pageHeader.php";
if (isset($_GET['type'])) {
  $type = $_GET['type'];
  $from = $_GET['from'];
  $to = $_GET['to'];
  $by = $_GET['by'];
  $level = $_GET['level'];
  $LeadPersonSource = $_GET['LeadPersonSource'];
} else {
  $type = "";
  $from = date("Y-m-d");
  $to = date("Y-m-d");
  $by = AuthAppUser("UserId");
  $level = "";
  $LeadPersonSource = "";
}
if (isset($_GET["view_page"])) {
  $page = $_GET["view_page"];
} else {
  $page = 1;
}
$next_page = ($page + 1);
$previous_page = ($page - 1);
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
      document.getElementById("all_leads").classList.add("active");
    }
    window.onload = SidebarActive;
  </script>
  <style>
    .card {
      box-shadow: 0px 0px 1px black !important;
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
          <div class="row">
            <div class="col-12">
              <div class="card card-primary new-bg-color">
                <div class="card-body">
                  <div class="row">

                    <div class="col-sm-5 col-12">
                      <?php
                      if (isset($_GET['type'])) {
                        $ListHeading = "All " . ucfirst(str_replace("_", " ", $_GET['type']))  . "";
                      } elseif (isset($_GET['view'])) {
                        $ListHeading = "All " . $_GET['view'];
                      } elseif (isset($_GET['sub_status'])) {
                        $ListHeading = "All " . $_GET['sub_status'];
                      } else {
                        $ListHeading = "All Leads";
                      } ?>
                      <h2 class="app-heading"><?php echo $ListHeading; ?> <small class="text-grey"> </small></h2>
                    </div>
                    <div class="col-sm-7 text-right">
                      <span class="btn btn-dark" id="lead_action"> <i class="fa fa-cogs text-light" aria-hidden="true"></i> Lead Action</span>
                      <span class="btn btn-dark" id="lead_filter"> <i class="fa fa-filter text-light" aria-hidden="true"></i> Lead Filter</span>
                    </div>

                    <!-- leads action -->
                    <div class="col-sm-12 col-12 text-right hidden" id="lead_action_div">
                      <?php if (AuthAppUser("UserType") == "Admin" || AuthAppUser("UserType") == "Digital") { ?>
                        <a href="uploads/" class="btn btn-sm btn-dark m-1"><i class="fa fa-upload"></i> Upload Bulk Leads</a>
                        <a href="../teams/" class="btn btn-sm btn-dark m-1">Team Leads</a>
                        <a href="transfer/" class="btn btn-sm btn-dark m-1"><i class="fa fa-exchange"></i> Move Leads </a>
                        <a href="uploaded/" class="btn btn-sm btn-dark m-1">Uploaded Leads</a>
                      <?php } ?>
                      <?php
                      $CheckReportingManagersStatus = CHECK("SELECT * FROM user_employment_details where UserEmpReportingMember='" . AuthAppUser("UserId") . "'");
                      if ($CheckReportingManagersStatus != NULL) { ?>
                        <a href="../teams/" class="btn btn-sm btn-dark m-1">Team Leads</a>
                      <?php } ?>
                      <a href="add.php" class="btn btn-sm btn-dark m-1"><i class="fa fa-plus"></i> New Lead</a>
                    </div>
                  </div>
                  <!-- filter -->

                  <div class="row hidden " id="lead_filter_div">
                    <div class="col-md-12 col-12">
                      <form class="row">
                        <input type="text" hidden id="leascurrentstatus" name="LeadPersonSubStatus" value="">
                        <input type="text" hidden id="leasstatus" name="LeadPersonStatus" value="">
                        <div class="col-md-2 col-6 flex-s-b">
                          <select class="form-control form-control-sm " name="LeadFollowStatus" onchange="form.submit()">
                            <option value="">All Lead Status</option>
                            <option value="FRESH LEAD">FRESH LEAD</option>

                            <?php
                            $FetchCallStatus = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='CALL_STATUS' and config_values.CompanyID='$companyID'", true);
                            if ($FetchCallStatus != null) {
                              foreach ($FetchCallStatus as $CallStatus) {
                                if (isset($_GET['LeadFollowStatus'])) {
                                  $arr = ["Call Back", "Ringing", "Not Picked", "Not Interested", "Already Taken", "Junk Call", "Out Of Coverage Area", "Switch Off", "Number Dose not Exist", "Out of Validity"];
                                  if ($_GET['LeadFollowStatus'] == $CallStatus->ConfigValueDetails) {
                                    $selected = "selected";
                                  } else {
                                    $selected = "";
                                  }
                                } else {
                                  $selected = "";
                                } ?>
                                <option <?php echo $selected; ?> value="<?php echo $CallStatus->ConfigValueDetails; ?>"><?php echo $CallStatus->ConfigValueDetails; ?></option>
                            <?php
                              }
                            } ?>
                            <option value="Not Picked">Not Picked</option>
                            <option value="Out Of Coverage Area"> Out Of Coverage Area</option>
                            <option value="Switch Off"> Switch Off </option>
                            <option value="Number Dose not Exist"> Number Dose not Exist </option>
                            <option value="Out of Validity"> Out of Validity </option>
                          </select>
                        </div>
                        <div class="col-md-2 col-6">
                          <select name="LeadRequirment" onchange="form.submit()" class="form-control form-control-sm">
                            <option value="">By All Projects</option>
                            <?php
                            $FetchProjectName = _DB_COMMAND_("SELECT * FROM projects where CompanyID='$companyID'", true);
                            if ($FetchProjectName != null) {
                              foreach ($FetchProjectName as $Project) {
                                if (isset($_GET['LeadRequirment'])) {
                                  if ($_GET['LeadRequirment'] == $Project->ProjectsId) {
                                    $selected = "selected";
                                  } else {
                                    $selected = "";
                                  }
                                } else {
                                  $selected = "";
                                }
                            ?>
                                <option <?php echo $selected; ?> value="<?php echo $Project->ProjectsId; ?>"><?php echo $Project->ProjectName; ?></option>
                            <?php
                              }
                            } ?>
                          </select>
                        </div>
                        <div class="col-md-2 col-6">
                          <input type="text" name="LeadPersonFullname" list="LeadPersonFullname" class="form-control form-control-sm " placeholder="Enter Person name">
                        </div>
                        <div class="col-md-2 col-6">
                          <input type="text" name="LeadPersonPhoneNumber" list="LeadPersonPhoneNumber" class="form-control form-control-sm " placeholder="Enter Phone number">
                        </div>
                        <div class="col-md-2 col-6">
                          <input type="text" value="" name="LeadPersonSource" list="LeadPersonSource" class="form-control form-control-sm " placeholder="Lead Source">
                        </div>
                        <?php
                        if (AuthAppUser("UserType") == "Admin" || AuthAppUser("UserType") == "Digital") { ?>
                          <div class="col-md-2 col-6">
                            <select name="LeadPersonManagedBy" onchange="form.submit()" class="form-control form-control-sm">
                              <option value="">All Users</option>
                              <?php
                              $FetchLeadsStatus = _DB_COMMAND_("SELECT * FROM leads where CompanyId='$companyID' GROUP BY LeadPersonManagedBy", true);
                              if ($FetchCallStatus != null) {
                                foreach ($FetchLeadsStatus as $LeadBy) {
                                  if (isset($_GET['LeadPersonManagedBy'])) {
                                    if ($_GET['LeadPersonManagedBy'] == $LeadBy->LeadPersonManagedBy) {
                                      $selected = "selected";
                                    } else {
                                      $selected = "";
                                    }
                                  } else {
                                    $selected = "";
                                  }
                              ?>
                                  <option <?php echo $selected; ?> value="<?php echo $LeadBy->LeadPersonManagedBy; ?>"><?php echo FETCH("SELECT * FROM users where UserId='" . $LeadBy->LeadPersonManagedBy . "'", "UserFullName"); ?></option>
                              <?php
                                }
                              }
                              ?>
                            </select>
                          </div>
                        <?php } else { ?>
                          <input type="text" hidden value="<?php echo AuthAppUser("UserId"); ?>" name="LeadPersonManagedBy" class="form-control" value='<?php echo date("Y-m-d"); ?>'>
                        <?php } ?>

                        <div class="col-md-2 col-6">
                          <input type="text" id="fromDateInput" name="from" autocomplete="off" placeholder="From Date" class="form-control" onclick="changeInputType('fromDateInput')">
                        </div>
                        <div class="col-md-2 col-6">
                          <input type="text" id="toDateInput" name="to" autocomplete="off" placeholder="To Date" class="form-control" onclick="changeInputType('toDateInput')">
                        </div>
                        <div class="col-md-2 col-6">
                          <button type="submit" name="search_true" class="btn btn-sm btn-primary btn-block">Apply Filters</button>
                        </div>
                        <div class="col-md-2 col-6">
                          <?php
                          $Filters = "";
                          if (isset($_GET['LeadRequirment'])) {
                            foreach ($_GET as $param_name => $param_value) {
                              $Filters .= $param_name . '=' . $param_value . '&';
                            }
                          } ?>
                          <a href="export/csv.php?<?php echo $Filters; ?>" type="submit" name="export_true" class="btn btn-sm btn-default btn-block">Export CSV <i class="fa fa-file text-success"></i></a>
                        </div>
                      </form>
                    </div>
                  </div>
                  <?php if (isset($_GET['LeadRequirment'])) { ?>
                    <div class="row">
                      <div class="col-md-12 mb-2 shadow-sm p-2 bg-light">
                        <h6 class="mb-2 text-black"><i class="fa fa-filter text-warning"></i> Filter Applied</h6>
                        <span class="flex-s-b">
                          <p class="fs-11">
                            <span>
                              <span class="text-grey">Lead Status :</span>
                              <span class="bold"><?php echo IfRequested("GET", "LeadFollowStatus", "All", false); ?></span>
                            </span>
                            <span>
                              <span class="text-grey">Project Type :</span>
                              <span class="bold"><?php $requirementId = IfRequested("GET", "LeadRequirment", "All", false);
                                                  $ProjectName = FETCH("SELECT * FROM projects where ProjectsId='$requirementId'", "ProjectName");
                                                  if ($ProjectName == 0) {
                                                    $res = "By All Project";
                                                  } else {
                                                    $res =  $ProjectName;
                                                  }
                                                  echo $res; ?></span>
                            </span>
                            <span>
                              <span class="text-grey">Person Name :</span>
                              <span class="bold"><?php echo IfRequested("GET", "LeadPersonFullname", "All", false);  ?></span>
                            </span>
                            <span>
                              <span class="text-grey">Phone Number :</span>
                              <span class="bold"><?php echo IfRequested("GET", "LeadPersonPhoneNumber", "All", false);  ?></span>
                            </span>
                            <span>
                              <span class='text-grey'>Priority level :</span>
                              <span class='bold'><?php echo IfRequested("GET", "LeadPriorityLevel", "All", false);  ?></span>
                            </span>
                            <span>
                              <span class='text-grey'>Lead Source : </span>
                              <span class='bold'><?php echo IfRequested("GET", "LeadPersonSource", "All", false);  ?></span>
                            </span>
                            <span>
                              <span class='text-grey'>From Date : </span>
                              <span class='bold'><?php echo IfRequested("GET", "from", "All", false);  ?></span>
                            </span>
                            <span>
                              <span class='text-grey'>To Date : </span>
                              <span class='bold'><?php echo IfRequested("GET", "to", "All", false);  ?></span>
                            </span>
                            <span>
                              <span class='text-grey'>Managed By : </span>
                              <span class='bold'>
                                <?php $UserResponseId = IfRequested("GET", "LeadPersonManagedBy", "All", false);
                                if (AuthAppUser("UserType") == "Admin" || AuthAppUser("UserType") == "Digital") {
                                  $UserFullName = FETCH("SELECT * FROM users where UserId='$UserResponseId'", "UserFullName");
                                  $UserPhoneNumber = FETCH("SELECT * FROM users where UserId='$UserResponseId'", "UserPhoneNumber");
                                  if ($UserFullName == null || $UserPhoneNumber  == 0) {
                                    $res = "By All Users";
                                  } else {
                                    $res = $UserFullName . " @ " . $UserPhoneNumber;
                                  }
                                } else {
                                  $res = FETCH("SELECT * FROM users where UserId='" . AuthAppUser("UserId") . "'", "UserFullName");
                                }
                                echo $res; ?>
                              </span>
                            </span>
                          </p>
                          <span>
                            <span class="text-gray">Total :</span>
                            <span class="bold"><?php echo $TotalItems; ?> Leads</span>
                          </span>
                        </span>
                        <a href="index.php" class="btn btn-xs btn-danger fs-11 pull-right" style="margin-top:-5.3em !important;">Clear Filter <i class="fa fa-times"></i></a>
                      </div>
                    </div>
                  <?php } ?>
                  <div class="row">
                    <div class="col-md-12" id="lead-content">
                      <center>
                        <i class="fa fa-spinner fa-spin h1 text-center"></i> <br>Loding Details........ <br>
                      </center>
                    </div>
                    <div class="col-md-12 flex-s-b mt-2 mb-1">
                      <?php
                      $listcounts = DEFAULT_RECORD_LISTING;
                      $NetPages = round(($TotalItems / $listcounts) + 0.5);
                      ?>
                      <div class="">
                        <span class="mb-0" style="font-size:0.75rem;color:white;">Page <b class="text-danger fs-12"><?php echo IfRequested("GET", "view_page", $page, false); ?></b> from <b class="text-info fs-12"><?php echo $NetPages; ?> </b> pages <br>Total <b class="text-success fs-12"><?php echo $TotalItems; ?></b> Entries</span>
                      </div>
                      <div class="flex">
                        <span class="mr-1">
                          <?php
                          if (isset($_GET['view'])) {
                            $viewcheck = "&view=" . $_GET['view'];
                          } else {
                            $viewcheck = "";
                          }
                          if (isset($_GET['sub_status'])) {
                            $sub_statuscheck = "&sub_status=" . $_GET['sub_status'];
                          } else {
                            $sub_statuscheck = "";
                          }
                          if (isset($_GET['LeadRequirment']) || isset($_GET['LeadFollowStatus']) || isset($_GET['search_true'])) {
                            $pagefilter = "&LeadPersonManagedBy=" . $_GET['LeadPersonManagedBy'] . "&LeadPersonSource=" . "&LeadRequirment=" . $_GET['LeadRequirment'] . "&LeadPersonStatus=" . $_GET['LeadPersonStatus'] . "&LeadFollowStatus=" . $_GET['LeadFollowStatus'] . "&LeadPersonFullname=" . $_GET['LeadPersonFullname'] . "&LeadPersonPhoneNumber=" . $_GET['LeadPersonPhoneNumber'] . "&from=" . $_GET['from'] . "&to=" . $_GET['to'];
                          } else {
                            $pagefilter = "";
                          } ?>
                          <a href="?view_page=<?php echo $previous_page; ?><?php echo $viewcheck; ?><?php echo $sub_statuscheck; ?><?php echo $pagefilter; ?>" class="btn btn-sm btn-default"><i class="fa fa-angle-double-left"></i></a>
                        </span>
                        <form style="padding:0.3rem !important;">
                          <input type="number" name="view_page" onchange="form.submit()" class="form-control form-control-sm  mb-0" min="1" max="<?php echo $NetPages; ?>" value="<?php echo IfRequested("GET", "view_page", 1, false); ?>">
                        </form>
                        <span class="ml-1">
                          <a href="?view_page=<?php echo $next_page; ?><?php echo $viewcheck; ?><?php echo $sub_statuscheck; ?><?php echo $pagefilter; ?>" class="btn btn-sm btn-default"><i class="fa fa-angle-double-right"></i></a>
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
        </div>
      </section>
    </div>
    <?php
    include $Dir . "/include/footer.php"; ?>
  </div>
  <script>
    $(document).ready(function() {
      $.ajax({
        url: "FetchAllData.php",
        type: "POST",
        data: {
          view_page: "<?php echo $page; ?>",
          Lead_Sql: "<?php echo $LEAD_SQLS; ?>",
          TotalLeads: "<?php echo $TotalItems; ?>",
          ListCount: "<?php echo $listcounts; ?>",

        },
        success: function(data) {
          $('#lead-content').html(data);
        }
      })
    });
  </script>
  <script>
    function CallStatusFunction() {
      var statustype = document.getElementById("statustype");
      <?php
      $FetchCallStatus = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='CALL_STATUS' ORDER BY ConfigValueId DESC", true);
      if ($FetchCallStatus != null) {
        foreach ($FetchCallStatus as $CallStatus) { ?>
          if (statustype.value == <?php echo $CallStatus->ConfigValueId; ?>) {
            document.getElementById("view_<?php echo $CallStatus->ConfigValueId; ?>").style.display = "block";
            document.getElementById("leasstatus").value = "<?php echo $CallStatus->ConfigValueDetails; ?>";
          } else {
            document.getElementById("view_<?php echo $CallStatus->ConfigValueId; ?>").style.display = "none";
          }
      <?php }
      } ?>
    }

    // lead filter and action script

    document.getElementById("lead_action").addEventListener("click", function() {
      document.getElementById("lead_action_div").classList.toggle("hidden");
    });
    document.getElementById("lead_filter").addEventListener("click", function() {
      document.getElementById("lead_filter_div").classList.toggle("hidden");
    });
  </script>
  <script>
    function changeInputType(inputId) {
      var input = document.getElementById(inputId);
      input.type = 'date';
      input.removeEventListener('click', function() {
        changeInputType(inputId);
      });
    }
  </script>
  <?php include $Dir . "/assets/FooterFilesLoader.php"; ?>
</body>

</html>