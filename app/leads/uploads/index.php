<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Upload Leads";
$PageDescription = "Manage all customers";
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
                      <h3 class="app-heading">Upload Bulk Leads</h3>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-8">
                      <h5 class="app-sub-heading">Upload Leads</h5>
                      <form class="row" action="<?php echo CONTROLLER; ?>/ModuleHandler.php" enctype="multipart/form-data" method="POST">
                        <?php FormPrimaryInputs(true); ?>
                        <div class="form-group col-md-4">
                          <label>Select File (.csv)</label>
                          <input type="FILE" name="UploadedFile" class="form-control form-control-sm " required>
                        </div>

                        <div class="form-group col-md-4">
                          <label>Project Interest</label>
                          <select name="LeadProjectsRef" class="form-control form-control-sm " required="">
                            <option value="0">Select Project</option>
                            <?php
                            $companyID = CompanyId;
                            $Project = _DB_COMMAND_("SELECT * FROM projects where CompanyID='$companyID' ORDER BY ProjectsId DESC", true);
                            if ($Project != null) {
                              foreach ($Project as $Prj) {
                            ?>
                                <option value="<?php echo $Prj->ProjectsId; ?>"><?php echo $Prj->ProjectName; ?></option>
                            <?php
                              }
                            } ?>
                          </select>
                        </div>
                        <div class="col-md-12">
                          <a href="../uploaded/" class="btn btn-md btn-default m-t-15"><i class="fa fa-angle-left"></i> View Uploaded Leads</a>
                          <button type="submit" name="UploadLeads" class="btn btn-md btn-dark"><i class="fa fa-upload"></i> Upload Leads</button>
                        </div>
                      </form>
                    </div>

                    <div class="col-md-4">
                      <h5 class="app-sub-heading">Upload File Instructions</h5>
                      <ul>
                        <li>File must be in <b>.csv</b> formate</li>
                        <li>file have Fields with header

                          <ul>
                            <li>Name</li>
                            <li>Phone</li>
                            <li>Email</li>
                            <li>Address</li>
                            <li>City</li>
                            <li>Profession</li>
                            <li>Source</li>
                          </ul>
                        </li>
                      </ul>
                      <a style="margin-top:-4rem !important;" href="../../../storage/export/lead-import-formate.csv" download="lead-import-formate.csv" class='pull-right text-dark'><i class='fa fa-download'></i> Download Format</a>
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

  <?php include $Dir . "/assets/FooterFilesLoader.php"; ?>

</body>

</html>