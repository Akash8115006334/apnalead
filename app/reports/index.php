<?php

use Random\Engine\Secure;

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
                            <div class="card card-primary billing-bg-color">
                                <div class="card-body">
                                    <div class="row">
                                        <div class='col-md-3'>
                                            <h4 class='app-heading'>Select User</h4>
                                            <form class='row'>
                                                <div class='col-md-12 form-group'>
                                                    <label>Select User</label>
                                                    <select class='form-control' onchange='form.submit()' name='UserId'>
                                                        <option value=''>Select Users</option>
                                                        <?php
                                                        $AllUsers = _DB_COMMAND_("SELECT * FROM users, company_users where users.UserId=company_users.company_alloted_user_id and users.UserStatus='1' and company_users.company_main_id='" . CompanyId . "'", true);
                                                        if ($AllUsers != null) {
                                                            foreach ($AllUsers as $value) {
                                                                if (isset($_GET['UserId'])) {
                                                                    if (Secure($_GET['UserId'], "d") == $value->UserId) {
                                                                        $selected = "selected";
                                                                    } else {
                                                                        $selected = "";
                                                                    }
                                                                } else {
                                                                    $selected = "";
                                                                }
                                                        ?>
                                                                <option value='<?php echo Secure($value->UserId, "e"); ?>' <?php echo $selected; ?>><?php echo $value->UserFullName; ?>
                                                                </option>
                                                        <?php
                                                            }
                                                        } else {
                                                            echo "<option value=''>No User Found!</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-12">

                                                    <?php if (isset($_GET['UserId'])) {
                                                        if ($_GET['UserId'] != null) {
                                                            $UserId = Secure($_GET['UserId'], "d");
                                                            $PageSqls = "SELECT * FROM users WHERE UserId='$UserId'";
                                                            $EmployementSQL = "SELECT * FROM user_employment_details where UserMainUserId='$UserId'";

                                                    ?>
                                                            <div class="w-100 mt-2 text-left">
                                                                <img src="<?php echo GetUserImage($UserId); ?>" class="w-25 img-fluid" alt="userlogo">
                                                            </div>



                                                            <p class="display-6">
                                                                <span><b>Name :</b> <?php echo FETCH($PageSqls, "UserFullName"); ?></span><br>
                                                                <span><b>Phone Number :</b> <?php echo FETCH($PageSqls, "UserPhoneNumber"); ?></span><br>
                                                                <span><b>Email-ID :</b> <?php echo FETCH($PageSqls, "UserEmailId"); ?></span><br>
                                                                <span><b>DOB :</b> <?php echo DATE_FORMATES("d M, Y", FETCH($PageSqls, "UserDateOfBirth")); ?></span><br>
                                                                <span><b>User Type :</b> <?php echo FETCH($PageSqls, "UserType"); ?></span><br>
                                                                <span><b>CRM Status :</b> <?php echo FETCH($EmployementSQL, "UserEmpCRMStatus"); ?></span><br>
                                                                <span><b>Work Group :</b> <?php echo FETCH($EmployementSQL, "UserEmpGroupName"); ?></span><br>
                                                                <span><b>Reporting Manager :</b>
                                                                    <br>
                                                                    <?php echo FETCH("SELECT * FROM users where UserId='" . FETCH($EmployementSQL, "UserEmpReportingMember") . "'", "UserFullName");
                                                                    $EmpId = FETCH($EmployementSQL, "UserEmpReportingMember");
                                                                    $ReportingEMPID = "SELECT * FROM user_employment_details where UserMainUserId='$EmpId'";
                                                                    ?>
                                                                </span><br>
                                                            </p>
                                                    <?php
                                                        } else {
                                                            NoData("Please select User");
                                                        }
                                                    } else {
                                                        NoData("Please select User");
                                                    }
                                                    ?>
                                                </div>
                                            </form>
                                        </div>
                                        <div class='col-md-9'>
                                            <h4 class='app-heading'><?php echo $PageName; ?></h4>
                                            <div class='row'>
                                                <?php if (isset($_GET["UserId"])) {


                                                    if ($_GET["UserId"] != null) {
                                                        $Req_UserId = Secure($_GET['UserId'], "d");
                                                        include "./common.php";
                                                ?>
                                                        <div class="row m-1">
                                                            <div class="col-md-3 col-6 mb-10px">
                                                                <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                                                    <div class="flex-s-b">
                                                                        <h2 class="count text-primary mb-0 m-t-5 h1">
                                                                            <?php echo $AllLeads; ?>
                                                                        </h2>
                                                                        <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                                            <span class="fs-11">Today : </span><span class="fs-13 count">
                                                                                <?php echo $AllLeadsToday; ?>
                                                                            </span><br>
                                                                            <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                                                <?php echo $AllLeadsYesterday; ?>
                                                                            </span>
                                                                        </span>
                                                                    </div>
                                                                    <p class="mb-0 fs-12 text-black">All Leads</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-6 mb-10px">
                                                                <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                                                    <div class="flex-s-b">
                                                                        <h2 class="count text-primary mb-0 m-t-5 h1">
                                                                            <?php echo $AllFresh; ?>
                                                                        </h2>
                                                                        <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                                            <span class="fs-11">Today : </span><span class="fs-13 count">
                                                                                <?php echo $AllFreshToday; ?>
                                                                            </span><br>
                                                                            <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                                                <?php echo $AllFreshYesterday; ?>
                                                                            </span>
                                                                        </span>
                                                                    </div>
                                                                    <p class="mb-0 fs-12 text-black"> FRESH LEADS</p>
                                                                </div>
                                                            </div>
                                                            <?php $AllStages = _DB_COMMAND_("SELECT * FROM configs, config_values WHERE configs.ConfigsId=config_values.ConfigValueGroupId AND configs.ConfigsId='7' AND config_values.CompanyID='" . CompanyId . "' ORDER BY ConfigValueId ASC", true);
                                                            if ($AllStages != null) {
                                                                foreach ($AllStages as $stage) {
                                                                    $All = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId'  and LeadPersonStatus like '%$stage->ConfigValueDetails%' and  LeadPersonStatus like '$stage->ConfigValueDetails%' and CompanyID='" . CompanyId . "'");
                                                                    $Today = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and LeadPersonStatus like '%$stage->ConfigValueDetails%' and  LeadPersonStatus like '$stage->ConfigValueDetails%' and CompanyID='" . CompanyId . "' and Date(LeadPersonCreatedAt)='" . date("Y-m-d") . "'");
                                                                    $Yesterday = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and LeadPersonStatus like '%$stage->ConfigValueDetails%' and  LeadPersonStatus like '$stage->ConfigValueDetails%' and CompanyID='" . CompanyId . "' and Date(LeadPersonCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'"); ?>
                                                                    <div class="col-md-3 col-6 mb-10px">
                                                                        <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                                                            <div class="flex-s-b">
                                                                                <h2 class="count text-primary mb-0 m-t-5 h1">
                                                                                    <?php echo $All; ?>
                                                                                </h2>
                                                                                <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                                                    <span class="fs-11">Today : </span><span class="fs-13 count">
                                                                                        <?php echo $Today; ?>
                                                                                    </span><br>
                                                                                    <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                                                        <?php echo $Yesterday; ?>
                                                                                    </span>
                                                                                </span>
                                                                            </div>
                                                                            <p class="mb-0 fs-12 text-black"> <?php echo UpperCase($stage->ConfigValueDetails); ?></p>
                                                                        </div>
                                                                    </div>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            <div class="col-md-3 col-6 mb-10px">
                                                                <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                                                    <div class="flex-s-b">
                                                                        <h2 class="count text-primary mb-0 m-t-5 h1">
                                                                            <?php echo $AllOutOfCoverage; ?>
                                                                        </h2>
                                                                        <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                                            <span class="fs-11">Today : </span><span class="fs-13 count">
                                                                                <?php echo $AllOutOfCoverageToday; ?>
                                                                            </span><br>
                                                                            <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                                                <?php echo $AllOutOfCoverageYesterday; ?>
                                                                            </span>
                                                                        </span>
                                                                    </div>
                                                                    <p class="mb-0 fs-12 text-black"> OUT OF COVERAGE AREA</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-6 mb-10px">
                                                                <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                                                    <div class="flex-s-b">
                                                                        <h2 class="count text-primary mb-0 m-t-5 h1">
                                                                            <?php echo $AllSwitchOff; ?>
                                                                        </h2>
                                                                        <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                                            <span class="fs-11">Today : </span><span class="fs-13 count">
                                                                                <?php echo $AllSwitchOfToday; ?>
                                                                            </span><br>
                                                                            <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                                                <?php echo $AllSwitchOfYesterday; ?>
                                                                            </span>
                                                                        </span>
                                                                    </div>
                                                                    <p class="mb-0 fs-12 text-black"> SWITCH OFF</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-6 mb-10px">
                                                                <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                                                    <div class="flex-s-b">
                                                                        <h2 class="count text-primary mb-0 m-t-5 h1">
                                                                            <?php echo $AllNumberDoesNot; ?>
                                                                        </h2>
                                                                        <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                                            <span class="fs-11">Today : </span><span class="fs-13 count">
                                                                                <?php echo $AllNumberDoesNotToday; ?>
                                                                            </span><br>
                                                                            <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                                                <?php echo $AllNumberDoesNotYesterday; ?>
                                                                            </span>
                                                                        </span>
                                                                    </div>
                                                                    <p class="mb-0 fs-12 text-black"> NUMBER DOES NOT EXIST</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-6 mb-10px">
                                                                <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                                                    <div class="flex-s-b">
                                                                        <h2 class="count text-primary mb-0 m-t-5 h1">
                                                                            <?php echo $AllOutOfValidity; ?>
                                                                        </h2>
                                                                        <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                                            <span class="fs-11">Today : </span><span class="fs-13 count">
                                                                                <?php echo $AllOutOfValidityToday; ?>
                                                                            </span><br>
                                                                            <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                                                <?php echo $AllOutOfValidityYesterday; ?>
                                                                            </span>
                                                                        </span>
                                                                    </div>
                                                                    <p class="mb-0 fs-12 text-black"> OUT OF VALIDITY</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-6 mb-10px">
                                                                <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                                                    <div class="flex-s-b">
                                                                        <h2 class="count text-primary mb-0 m-t-5 h1">
                                                                            <?php echo $AllNotPicked; ?>
                                                                        </h2>
                                                                        <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                                            <span class="fs-11">Today : </span><span class="fs-13 count">
                                                                                <?php echo $AllNotPickedToday; ?>
                                                                            </span><br>
                                                                            <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                                                <?php echo $AllNotPickedYesterday; ?>
                                                                            </span>
                                                                        </span>
                                                                    </div>
                                                                    <p class="mb-0 fs-12 text-black"> NOT PICKED</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php
                                                    } else {
                                                        NoData("Please Select the User");
                                                    }
                                                } else {
                                                    NoData("Please Select the User");
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




<!--   <div class='col-md-12 '>
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
                                                                                $AllLeads = TOTAL("SELECT LeadsId FROM leads WHERE  Date(LeadPersonCreatedAt)>='$FromDate' and Date(LeadPersonCreatedAt)<='$ToDate' and  LeadPersonManagedBy='" . $User->UserId . "' and CompanyID='" . CompanyId . "'");
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
                                                        </div> -->