<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Lead Reports";
$PageDescription = "Manage all customers";
// 
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
            document.getElementById("profile").classList.add("active");
            document.getElementById("profile_view").classList.add("active");
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
                                        <div class='col-md-3'>
                                            <h4 class='app-heading'>Apply Filters</h4>

                                            <form class='row'>
                                                <div class='col-md-12 form-group'>
                                                    <label class="text-light">Select User</label>
                                                    <select class='form-control' onchange='form.submit()' name='UserId'>
                                                        <option value=''>All Users</option>
                                                        <?php
                                                        $AllUsers = _DB_COMMAND_("SELECT * FROM users, company_users where users.UserId=company_users.company_alloted_user_id and users.UserStatus='1' and company_users.company_main_id='" . CompanyId . "'", true);
                                                        if ($AllUsers != null) {
                                                            foreach ($AllUsers as $value) {
                                                                if (isset($_GET['UserId'])) {
                                                                    if ($_GET['UserId'] == $value->UserId) {
                                                                        $selected = "selected";
                                                                    } else {
                                                                        $selected = "";
                                                                    }
                                                                } else {
                                                                    $selected = "";
                                                                }
                                                        ?>
                                                                <option value='<?php echo $value->UserId; ?>' <?php echo $selected; ?>><?php echo $value->UserFullName; ?>
                                                                </option>
                                                        <?php
                                                            }
                                                        } else {
                                                            echo "<option value=''>No User Found!</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class='col-md-12 form-group'>
                                                    <label class="text-light">From date</label>
                                                    <input type='date' name='FromDate' onchange='form.submit()' class='form-control' value='<?php echo IfRequested("GET", "FromDate", date('Y-m-d'), false); ?>'>
                                                </div>
                                                <div class='col-md-12 form-group'>
                                                    <label class="text-light">To date</label>
                                                    <input type='date' name='ToDate' onchange='form.submit()' class='form-control' value='<?php echo IfRequested("GET", "ToDate", date('Y-m-d'), false); ?>'>
                                                </div>
                                                <div class='col-md-12 form-group text-right'>
                                                    <?php if (isset($_GET['ApplyFilters'])) {
                                                    ?>
                                                        <a href="index.php" class='btn btn-md btn-danger mt-3'><i class='fa fa-times'></i> Clear filters</a>
                                                    <?php
                                                    } ?>
                                                    <button type='submit' name='ApplyFilters' class='btn btn-md btn-success'>Apply Filters <i class='fa fa-angle-right'></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class='col-md-9'>
                                            <h4 class='app-heading'><?php echo $PageName; ?></h4>

                                            <div class='row'>
                                                <?php
                                                if (isset($_GET['UserId'])) {
                                                    $UserId = $_GET['UserId'];
                                                    if ($UserId != null) {
                                                        $condition = "UserId = '$UserId'";
                                                    } else {
                                                        $condition = "UserId like '%$UserId%'";
                                                    }
                                                    $FetchUsers = _DB_COMMAND_("SELECT * FROM users, company_users where  users.UserId=company_users.company_alloted_user_id and $condition and UserStatus='1' and company_users.company_main_id='" . CompanyId . "'  ORDER BY UserFullName ASC", true);
                                                } else {
                                                    $FetchUsers = _DB_COMMAND_("SELECT * FROM users, company_users where users.UserId=company_users.company_alloted_user_id and users.UserStatus='1' and company_users.company_main_id='" . CompanyId . "' ORDER BY UserFullName ASC", true);
                                                }
                                                if ($FetchUsers != null) {
                                                    foreach ($FetchUsers as $User) {
                                                ?>
                                                        <div class='col-md-12 '>
                                                            <div class='data-list bg-light'>
                                                                <div class='row'>
                                                                    <div class='col-md-2'>
                                                                        <?php UserDetails($User->UserId); ?>
                                                                    </div>
                                                                    <div class='col-md-9'>
                                                                        <div class='flex-s-b'>
                                                                            <?php

                                                                            if (isset($_GET['ApplyFilter'])) {
                                                                                $FromDate = Date($_GET['FromDate']);
                                                                                $ToDate = Date($_GET['ToDate']);
                                                                                $AllLeads = TOTAL("SELECT LeadsId FROM leads WHERE Date(LeadPersonCreatedAt)>='$FromDate' and Date(LeadPersonCreatedAt)<='$ToDate' and  LeadPersonManagedBy='" . $User->UserId . "' and CompanyID='" . CompanyId . "'");
                                                                                $AllFreshLeads = TOTAL("SELECT LeadsId FROM leads WHERE Date(LeadPersonCreatedAt)>='$FromDate' and Date(LeadPersonCreatedAt)<='$ToDate' and LeadPersonStatus like '%FRESH LEAD%' and LeadPersonManagedBy='" . $User->UserId . "' and CompanyID='" . CompanyId . "'");
                                                                            } else {
                                                                                $AllLeads = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='" . $User->UserId . "' and CompanyID='" . CompanyId . "'");
                                                                                $AllFreshLeads = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonStatus like '%FRESH LEAD%' and LeadPersonManagedBy='" . $User->UserId . "' and CompanyID='" . CompanyId . "'");
                                                                            }
                                                                            ?>
                                                                            <div class='pt-3'>
                                                                                <h5 class='mb-0'>
                                                                                    <?php echo $AllLeads; ?>
                                                                                </h5>
                                                                                <p class="mb-0 fs-14 text-grey small">All Leads</p>
                                                                            </div>
                                                                            <div class='pt-3'>
                                                                                <h5 class='mb-0'>
                                                                                    <?php echo $AllFreshLeads; ?>
                                                                                </h5>
                                                                                <p class="mb-0 fs-14 text-grey small">Fresh Leads</p>
                                                                            </div>
                                                                            <?php
                                                                            $AllCounters = _DB_COMMAND_("SELECT * FROM config_lead_counters where CompanyID='" . CompanyId . "' ORDER by config_lead_counter_id ASC", true);

                                                                            if ($AllCounters != null) {
                                                                                foreach ($AllCounters as $Counter) {
                                                                                    $LOGIN_UserViewId = $User->UserId;
                                                                                    if (isset($_GET['ApplyFilter'])) {
                                                                                        $FromDate = $_GET['FromDate'];
                                                                                        $ToDate = $_GET['ToDate'];
                                                                                        $Results = TOTAL("SELECT * FROM leads where CompanyID='" . CompanyId . "' and LeadPersonStatus like '%$Counter->config_counter_primary_search%'  and  LeadPersonManagedBy='" . $User->UserId . "' DATE(LeadPersonCreatedAt)<='$FromDate' and DATE(LeadPersonCreatedAt)>='$FromDate' and LeadPersonManagedBy='" . $User->UserId . "'");
                                                                                    } else {
                                                                                        $Results = TOTAL("SELECT * FROM leads where CompanyID='" . CompanyId . "' and LeadPersonStatus like '%$Counter->config_counter_primary_search%'  and LeadPersonManagedBy='" . $User->UserId . "'");
                                                                                    }
                                                                            ?>

                                                                                    <div class='pt-3'>
                                                                                        <h5 class='mb-0'>
                                                                                            <?php echo $Results; ?>
                                                                                        </h5>
                                                                                        <p class="mb-0 fs-14 text-grey small"><?php echo UpperCase($Counter->config_counter_name); ?></p>
                                                                                    </div>
                                                                            <?php
                                                                                }
                                                                            }
                                                                            ?>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php
                                                    }
                                                } else {
                                                    NoData("No User found!");
                                                } ?>
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