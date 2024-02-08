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
                    <div class="col-sm-12 col-12">
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
                      <div class="flex-s-b data-list bg-light">
                        <div class="flex-s-b align-items-center">
                          <h3 class="bold m-1">
                            <?php echo $ListHeading; ?>
                          </h3>
                        </div>
                        <div class="text-right">
                          <div>
                            <span class=" btn btn-xs btn-default cursor-default mr-1"><i class="fa fa-flag text-success" aria-hidden="true"></i> HIGH</span>
                            <span class=" btn btn-xs btn-default cursor-default mr-1"><i class="fa fa-flag text-info" aria-hidden="true"></i> MEDIUM</span>
                            <span class=" btn btn-xs btn-default cursor-default mr-1"><i class="fa fa-flag text-warning" aria-hidden="true"></i> LOW</span>
                            <span class=" btn btn-xs btn-default cursor-default mr-1"><i class="fa fa-comments text-info" aria-hidden="true"></i> Add Feedback</span><br>
                          </div>
                          <div class="mt-2">
                            <span id="lead_action" class=" btn btn-xs btn-info  mr-1"><i class="fa fa-eye text-light" aria-hidden="true"></i> Lead Action</span>
                            <a href="add.php" class=" btn btn-xs btn-danger mr-1"><i class="fa fa-plus fs-10 text-white" aria-hidden="true"></i> Add New Lead </b></a>
                            <span class=" btn btn-xs btn-default cursor-default mr-1"><i class="fa fa-circle fs-10 text-gray" aria-hidden="true"></i> Total Lead <b><?php echo TOTAL("SELECT LeadsId FROM leads WHERE CompanyID='" . CompanyId . "' GROUP BY LeadsId"); ?></b></span>
                          </div>
                          <div class="hidden mt-2" id="lead_action_div">
                            <?php if (AuthAppUser("UserType") == "Admin" || AuthAppUser("UserType") == "Digital") { ?>
                              <a href="uploads/" class="btn btn-xs btn-dark "><i class="fa fa-upload"></i> Upload Bulk Leads</a>
                              <a href="../teams/" class="btn btn-xs btn-dark ">Team Leads</a>
                              <a href="transfer/" class="btn btn-xs btn-dark "><i class="fa fa-exchange"></i> Move Leads </a>
                              <a href="uploaded/" class="btn btn-xs btn-dark ">Uploaded Leads</a>
                            <?php } ?>
                            <?php
                            $CheckReportingManagersStatus = CHECK("SELECT * FROM user_employment_details where UserEmpReportingMember='" . AuthAppUser("UserId") . "'");
                            if ($CheckReportingManagersStatus != NULL) { ?>
                              <a href="../teams/" class="btn btn-xs btn-dark ">Team Leads</a>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 col-12 mt-0">
                      <div class="data-list bg-light">
                        <div class="flex-s-b btn-default data-list">
                          <div class="w-pr-5">
                            <span class="bold  ">Sr. No</span>
                          </div>
                          <div class="w-pr-20 pl-2">
                            <span class="bold">Name</span>
                          </div>
                          <div class="w-pr-15">
                            <span class="bold  ">Phone</span>
                          </div>
                          <div class="w-pr-13 text-center">
                            <span class="bold  ">Lead Stage</span>
                          </div>
                          <div class="w-pr-10 text-center">
                            <span class="bold  ">Source</span>
                          </div>
                          <div class="w-pr-10 text-center">
                            <span class="bold">Created Date</span>
                          </div>
                          <div class="w-pr-12 text-center">
                            <span class="bold">Managed By</span>
                          </div>
                          <div class="w-pr-15 text-center">
                            <span class="bold">Action</span>
                          </div>
                        </div>
                        <form>
                          <div class="flex-s-b w-100">
                            <input type="text" hidden name="search_true">
                            <div class="w-pr-25">
                              <input type="text" onchange="form.submit()" name="LeadPersonFullName" list="LeadPersonFullname" class="w-100 custom-input form-control" value="<?php echo IfRequested("GET", "LeadPersonFullName", "", false); ?>" placeholder="Enter Full Name">
                              <?php SUGGEST("leads", "LeadPersonFullname", "ASC", CompanyId); ?>
                            </div>
                            <div class="w-pr-15 ">
                              <input type="text" onchange="form.submit()" name="LeadPersonPhoneNumber" list="LeadPersonPhoneNumber" pattern="0-9" class="w-100 custom-input text-left form-control" placeholder="Phone Number" value="<?php echo IfRequested("GET", "LeadPersonPhoneNumber", "", false); ?>">
                              <?php SUGGEST("leads", "LeadPersonPhoneNumber", "ASC", CompanyId); ?>
                            </div>
                            <div class="w-pr-13">
                              <select name="LeadPersonStatus" onchange="form.submit()" id="" class="w-100 custom-option form-control fs-15">
                                <option value="">Select Status</option>
                                <?php
                                $FetchCallStatus = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='CALL_STATUS' and config_values.CompanyID='$companyID'", true);
                                if ($FetchCallStatus != null) {
                                  foreach ($FetchCallStatus as $CallStatus) {
                                    if (isset($_GET['LeadPersonStatus'])) {
                                      // $arr = ["Call Back", "Ringing", "Not Picked", "Not Interested", "Already Taken", "Junk Call", "Out Of Coverage Area", "Switch Off", "Number Dose not Exist", "Out of Validity"];
                                      if ($_GET['LeadPersonStatus'] == $CallStatus->ConfigValueDetails) {
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
                                  InputOptions(["FRESH LEAD", "Not Picked", "Out Of Coverage Area", "Switch Off", "Number Dose not Exist", "Out of Validity"], IfRequested("GET", "LeadPersonStatus", "", false));
                                } ?>
                              </select>
                            </div>
                            <div class="w-pr-10">
                              <input type="text" onchange="form.submit()" name="LeadPersonSource" list="LeadPersonSource" class="w-100 custom-input text-center form-control" placeholder="Source" value="<?php echo IfRequested("GET", "LeadPersonSource", "", false); ?>">
                              <?php SUGGEST("leads", "LeadPersonSource", "ASC", CompanyId); ?>
                            </div>
                            <div class="w-pr-10">
                              <input type="text" onchange="form.submit()" onclick="changeInputType(this)" name="LeadCreatedAt" class="w-100 custom-input form-control" placeholder="Date" value="<?php echo IfRequested("GET", "LeadCreatedAt", "", false); ?>">
                            </div>
                            <div class="w-pr-12">
                              <?php
                              if (AuthAppUser("UserType") == "Admin" || AuthAppUser("UserType") == "Digital") { ?>
                                <select name="LeadManagedBy" onchange="form.submit()" class="w-100 custom-option form-control fs-15">
                                  <option value="">All Users</option>
                                  <?php
                                  $FetchLeadsStatus = _DB_COMMAND_("SELECT company_alloted_user_id FROM company_users where company_main_id='$companyID' GROUP BY company_alloted_user_id", true);
                                  if ($FetchCallStatus != null) {
                                    foreach ($FetchLeadsStatus as $LeadBy) {
                                      if (isset($_GET['LeadManagedBy'])) {
                                        if ($_GET['LeadManagedBy'] == $LeadBy->company_alloted_user_id) {
                                          $selected = "selected";
                                        } else {
                                          $selected = "";
                                        }
                                      } else {
                                        $selected = "";
                                      }
                                  ?>
                                      <option <?php echo $selected; ?> value="<?php echo $LeadBy->company_alloted_user_id; ?>"><?php echo FETCH("SELECT * FROM users where UserId='" . $LeadBy->company_alloted_user_id . "'", "UserFullName"); ?></option>
                                  <?php
                                    }
                                  }
                                  ?>
                                </select>

                              <?php } else { ?>
                                <input type="text" readonly class="w-100 custom-input form-control text-center" value="<?php echo FETCH("SELECT UserFullName FROM users WHERE UserId='" . AuthAppUser("UserId") . "'", "UserFullName"); ?>" name="LeadManagedBy">
                              <?php } ?>
                            </div>
                            <div class="w-pr-15 text-center ">
                              <span class="btn btn-xs btn-warning w-75 mt-2" id="filter">More Filter</span>
                            </div>

                          </div>
                          <div class="row m-0 hidden" id="more_filter">
                            <div class="col-md-12 m-0">
                              <hr class="new-hr m-0">
                              <div class="flex mt-0">
                                <div class="w-pr-20 mr-1">
                                  <select name="LeadRequirment" onchange="form.submit()" class="w-100 custom-option form-control fs-15">
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
                                <div class="w-pr-15 ml-1">
                                  <select name="LeadPriorityLevel" onchange="form.submit()" class="w-100 custom-option form-control fs-15">
                                    <option value="">Select Priority Level</option>
                                    <?php CONFIG_VALUES("LEAD_PERIORITY_LEVEL", IfRequested("GET", "LeadPriorityLevel", "", false)); ?>
                                  </select>
                                </div>
                                <div class="w-pr-65 text-right">

                                  <?php
                                  if (AuthAppUser("UserType") == "Admin") {
                                    $Filters = "";
                                    if (isset($_GET['search_true'])) {
                                      foreach ($_GET as $param_name => $param_value) {
                                        $Filters .= $param_name . '=' . $param_value . '&';
                                      }
                                    } ?>
                                    <a href="export/csv.php?<?php echo $Filters; ?>" type="submit" name="export_true" class="btn btn-xs btn-success p-1  mt-2 ">Export CSV <i class="fa fa-file text-light"></i></a>
                                  <?php } ?>
                                </div>
                              </div>
                            </div>
                          </div>

                        </form>
                      </div>
                    </div>
                  </div>
                  <?php if (isset($_GET['search_true'])) {
                  ?>
                    <div class="row">
                      <div class="col-md-12 mb-2 shadow-sm p-2 bg-light">
                        <h6 class="mb-2"><i class="fa fa-filter text-warning"></i> Search Result <b class="fs-20"><?php echo $TotalItems; ?></b></h6>
                        <p class="fs-11">
                          <span>
                            <span class="text-grey">Person Name :</span>
                            <span class="bold"><?php echo IfRequested("GET", "LeadPersonFullName", "All", false);  ?></span>
                          </span>
                          <span>
                            <span class="text-grey">Phone Number :</span>
                            <span class="bold"><?php echo IfRequested("GET", "LeadPersonPhoneNumber", "All", false);  ?></span>
                          </span>
                          <span>
                            <span class="text-grey">Lead Status :</span>
                            <span class="bold"><?php echo IfRequested("GET", "LeadPersonStatus", "All", false);  ?></span>
                          </span>
                          <span>
                            <span class="text-grey">Project Name:</span>
                            <span class="bold"><?php $projectid = IfRequested("GET", "LeadRequirment", "All", false);
                                                if ($projectid != null) {
                                                  echo FETCH("SELECT ProjectName FROM projects WHERE ProjectsId='$projectid' and  CompanyID='$companyID'", "ProjectName");
                                                } ?></span>
                          </span>
                          <span>
                            <span class="text-grey">Priority Level :</span>
                            <span class="bold"><?php echo IfRequested("GET", "LeadPriorityLevel", "All", false);  ?></span>
                          </span>
                          <span>
                            <span class="text-grey">Source :</span>
                            <span class="bold"><?php echo IfRequested("GET", "LeadPersonSource", "All", false);  ?></span>
                          </span>
                          <span>
                            <span class="text-grey">LeadCreatedAt :</span>
                            <span class="bold"><?php echo IfRequested("GET", "LeadCreatedAt", "All", false);  ?></span>
                          </span>
                          <span>
                            <span class="text-grey">Managed By :</span>
                            <span class="bold"><?php $userid = IfRequested("GET", "LeadManagedBy", "All", false);
                                                if ($userid == null) {
                                                  echo "All";
                                                } else {
                                                  echo FETCH("SELECT UserFullName FROM users where UserId='$userid'", "UserFullName");
                                                } ?></span>
                          </span>
                        </p>
                        <a href="index.php" class="btn btn-xs btn-danger fs-11 pull-right" style="margin-top:-5.3em !important;">Clear Filter <i class="fa fa-times"></i></a>
                      </div>
                    </div>
                  <?php }
                  ?>
                  <?php
                  $listcounts = 10;
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
                  ?>
                  <div class="row">
                    <div class="col-md-12" id="lead-content">
                      <center>
                        <i class="fa fa-spinner fa-spin h1 text-center"></i> <br>Loding Details........ <br>
                      </center>
                    </div>
                    <?php PaginationFooter($TotalItems, "index.php"); ?>

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
      let currentUrl = window.location.href;
      $.ajax({
        url: "FetchAllData.php",
        type: "POST",
        data: {
          view_page: "<?php echo $page; ?>",
          Lead_Sql: "<?php echo $LEAD_SQLS; ?>",
          TotalLeads: "<?php echo $TotalItems; ?>",
          ListCount: "<?php echo $listcounts; ?>",
          CurrentUrl: currentUrl,

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
    document.getElementById("filter").addEventListener("click", function() {
      document.getElementById("more_filter").classList.toggle("hidden");
    });
  </script>
  <script>
    function changeInputType(input) {
      input.type = "date";
    }
  </script>
  <script>
    // $(document).on("click", ".feedbackFormIcon", function(event) {
    //   let currentUrl = window.location.href;
    //   let clickedSpanId = $(event.target).closest('span').attr('id');

    //   // Set the URL to the input field
    //   document.getElementById("urlInput").value = currentUrl;

    //   // Log or use the clicked span ID as needed
    //   console.log("Clicked span ID: " + clickedSpanId);
    // });
  </script>

  <?php include $Dir . "/assets/FooterFilesLoader.php"; ?>
</body>

</html>