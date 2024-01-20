<?php
$Dir = "../../";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "All Projects";
$PageDescription = "Manage System Profile, address, logo";
$UserID = AuthAppUser("UserId");
$MainCompanyId = FETCH("SELECT * FROM company_users WHERE company_alloted_user_id='$UserID'", "company_main_id");
$CompanyTableDetails = "SELECT * FROM config_companies WHERE company_id='$MainCompanyId'";
$ComapnyMainId = FETCH($CompanyTableDetails, "company_id");

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
  <meta name="keywords" content="<?php echo APP_NAME; ?>">
  <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
  <?php include $Dir . "/assets/HeaderFilesLoader.php"; ?> <script type="text/javascript">
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
                    <div class="col-md-10">
                      <h4 class="app-heading"><?php echo $PageName; ?></h4>
                    </div>
                    <div class="col-md-2">
                      <a href="#" class="btn btn-block btn-danger" onclick="Databar('add_projects')"><i class="fa fa-plus"></i> Add Projects</a>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">

                      <div id="add_projects" class="hidden">
                        <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST"> <?php FormPrimaryInputs(true); ?> <div class="row">
                            <div class="col-md-4 form-group">
                              <select class="form-control form-control-sm" name="ProjectTypeId" required="" onchange="ProjectTypeInput2(this)">
                                <option value="0">Select Details Type</option>
                                <?php
                                $ProjectTypes = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='PROJECT_TYPES' and config_values.CompanyID='$ComapnyMainId'", true);
                                if ($ProjectTypes != null) {
                                  foreach ($ProjectTypes as $Types) {
                                ?> <option value="<?php echo $Types->ConfigValueId; ?>"> <?php echo $Types->ConfigValueDetails; ?></option>
                                <?php }
                                }
                                echo "<option value='NEW'>CREATE NEW TYPE</option>";
                                ?>
                              </select>
                            </div>
                            <div class="col-md-8 form-group hidden" id="project-type">
                              <input type="text" class="form-control form-control-sm" name="ProjectType" placeholder="Project Type Name">
                            </div>
                            <div class="col-md-8 form-group" id="project-name">
                              <input type="text" class="form-control form-control-sm" name="ProjectName" placeholder="Enter Name" required="">
                            </div>
                            <div class="col-md-12 form-group">
                              <textarea class="form-control form-control-sm" name="ProjectDescriptions" rows="3" placeholder="Enter Description"></textarea>
                            </div>
                            <div class="col-md-12">
                              <button type="submit" name="SaveNewProjects" class="btn btn-md btn-success mt-0 mb-0" style="margin-top:0px !important;">Save</button>
                              <a href="#" onclick="Databar('add_projects')" class="btn btn-md btn-default">Cancel</a>
                              <hr>
                            </div>
                          </div>
                        </form>
                      </div>
                      <div class="row">
                        <br>
                        <div class="col-md-12 ">
                          <?php $Projects = _DB_COMMAND_("SELECT * FROM projects where CompanyID='$ComapnyMainId'", true);
                          if ($Projects != null) {
                            $SerialNo = 0;
                            foreach ($Projects as $Data) {
                              $SerialNo++;
                              $ProjectTypeId = $Data->ProjectTypeId;
                              $TypSql = "SELECT * FROM config_values where ConfigValueId='$ProjectTypeId' and CompanyID='$ComapnyMainId'"; ?>
                              <div class="data-list flex-s-b bg-light">
                                <span>
                                  <span class="count"><?php echo $SerialNo; ?></span>
                                  <a href="details/index.php?proid=<?php echo SECURE($Data->ProjectsId, "e"); ?>">
                                    <?php echo $Data->ProjectName; ?> - <i class='text-grey'><?php echo FETCH($TypSql, "ConfigValueDetails"); ?></i>
                                  </a>
                                </span>
                                <span class="menu">
                                  <span class="text-grey"><i class="fa fa-calendar"></i>
                                    <?php echo DATE_FORMATES("d M, Y", $Data->ProjectCreatedAt); ?></span>
                                  <a href="#" onclick="Databar('update_<?php echo $Data->ProjectsId; ?>')" class="text-info">Update</a>
                                  <?php CONFIRM_DELETE_POPUP(
                                    "projects_list",
                                    [
                                      "delete_project_records" => true,
                                      "control_id" => $Data->ProjectsId
                                    ],
                                    "ModuleHandler",
                                    "Remove",
                                    "text-danger"
                                  ); ?> </span>
                              </div>
                              <div id="update_<?php echo $Data->ProjectsId; ?>" class="hidden">
                                <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST">
                                  <?php FormPrimaryInputs(true, [
                                    "ProjectsId" => $Data->ProjectsId
                                  ]); ?> <div class="row">
                                    <div class="col-md-4 form-group">
                                      <select class="form-control form-control-sm" name="ProjectTypeId" required="">
                                        <option value="0">Select Detail Type</option>
                                        <?php
                                        $ProjectTypes = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='PROJECT_TYPES'  and config_values.CompanyID='$ComapnyMainId'", true);
                                        if ($ProjectTypes != null) {
                                          foreach ($ProjectTypes as $Types) {
                                            if ($Types->ConfigValueId == $Data->ProjectTypeId) {
                                              $selected = "selected";
                                            } else {
                                              $selected = "";
                                            }
                                        ?>
                                            <option value="<?php echo $Types->ConfigValueId; ?>" <?php echo $selected; ?>>
                                              <?php echo $Types->ConfigValueDetails; ?></option>
                                        <?php }
                                        } else {
                                          echo "<option value='0'>No Data Available</option>";
                                        }
                                        ?>
                                      </select>
                                    </div>
                                    <div class="col-md-8 form-group">
                                      <input type="text" class="form-control form-control-sm" name="ProjectName" value="<?php echo $Data->ProjectName; ?>" placeholder="Enter Project Name" required="">
                                    </div>
                                    <div class="col-md-12 form-group">
                                      <textarea class="form-control form-control-sm" name="ProjectDescriptions" rows="3" placeholder="Enter Project Description"><?php echo SECURE($Data->ProjectDescriptions, "d"); ?></textarea>
                                    </div>
                                    <div class="col-md-12">
                                      <button type="submit" name="UpdateProjectsDetails" class="btn btn-md btn-success mt-0 mb-0" style="margin-top:0px !important;">Save</button>
                                      <a href="#" onclick="Databar('update_<?php echo $Data->ProjectsId; ?>')" class="btn btn-md btn-default">Cancel</a>
                                      <hr>
                                    </div>
                                  </div>
                                </form>
                              </div>
                          <?php }
                          } else {
                            NoData("<b>No details Found!</b><br> Please add some details");
                          } ?>
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
    </div> <?php include $Dir . "/include/footer.php"; ?>
  </div> <?php include $Dir . "/assets/FooterFilesLoader.php"; ?>
  <script>
    function ProjectTypeInput2(selectElement) {
      var projectTypeDiv = document.getElementById("project-type");
      var projectNameDiv = document.getElementById("project-name");
      if (selectElement.value === "NEW") {
        projectTypeDiv.classList.remove("hidden");
        // projectNameDiv.classList.remove("col-md-8");
        projectNameDiv.classList.add("col-md-12");
      } else {
        projectTypeDiv.classList.add("hidden");
        projectNameDiv.classList.add("col-md-8");
        projectNameDiv.classList.remove("col-md-12");
      }
    }
  </script>
</body>

</html>