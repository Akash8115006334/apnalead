<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Edit Deal Details";
$PageDescription = "Manage all leads";

if (isset($_GET['dealsid'])) {
    $_SESSION['REQ_LeadsId'] = SECURE($_GET['dealsid'], "d");
    $REQ_LeadsId = $_SESSION['REQ_LeadsId'];
} else {
    $REQ_LeadsId = $_SESSION['REQ_LeadsId'];
}

$PageSqls = "SELECT * FROM leads where LeadsId='$REQ_LeadsId'";

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

                                    <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST">
                                        <?php FormPrimaryInputs(true, [
                                            "ManagedBy" => FETCH($PageSqls, "LeadPersonManagedBy")
                                        ]); ?>
                                        <div class="row">
                                            <div class="col-md-7">
                                                <h4 class="app-heading"><?php echo FETCH($PageSqls, "LeadPersonFullname"); ?> : <?php echo LEADID($REQ_LeadsId); ?></h4>
                                                <div class="row mb-2px">
                                                    <div class="form-group col-md-3">
                                                        <label>Salutation</label>
                                                        <select name="LeadSalutations" class="form-control form-control-sm">
                                                            <?php InputOptions(["Mr.", "Mrs.", "Miss.", "Ms.", "Dr.", "Prof.", "Sir"], FETCH($PageSqls, "LeadSalutations")); ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-9">
                                                        <label>Full Name</label>
                                                        <input type="text" name="LeadPersonFullname" value="<?php echo FETCH($PageSqls, "LeadPersonFullname"); ?>" list="LeadPersonFullname" class="form-control form-control-sm" placeholder="Gaurav Singh" required="">
                                                        <?php SUGGEST("leads", "LeadPersonFullname", "ASC") ?>
                                                    </div>
                                                </div>

                                                <div class="row mb-2px">
                                                    <div class="form-group col-md-5">
                                                        <label>Phone Number</label>
                                                        <input type="phone" name="LeadPersonPhoneNumber" value="<?php echo FETCH($PageSqls, "LeadPersonPhoneNumber"); ?>" list="LeadPersonPhoneNumber" placeholder="without +91" class="form-control form-control-sm" required="">
                                                        <?php SUGGEST("leads", "LeadPersonPhoneNumber", "ASC") ?>
                                                    </div>
                                                    <div class="form-group col-md-7">
                                                        <label>Email</label>
                                                        <input type="email" name="LeadPersonEmailId" value="<?php echo FETCH($PageSqls, "LeadPersonEmailId"); ?>" list="LeadPersonEmailId" class="form-control form-control-sm" placeholder="example@domain.tld">
                                                        <?php SUGGEST("leads", "LeadPersonEmailId", "ASC") ?>
                                                    </div>
                                                </div>
                                                <div class="row mb-2px">
                                                    
                                                    <div class="form-group col-md-6">
                                                        <label>Lead Source</label>
                                                        <select class="form-control form-control-sm" name="LeadPersonSource">
                                                            <?php CONFIG_VALUES("LEAD_SOURCES", FETCH($PageSqls, "LeadPersonSource")); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2px">
                                                    <div class="form-group col-md-12">
                                                        <label>Address</label>
                                                        <textarea name="LeadPersonAddress" row="3" class="form-control form-control-sm" placeholder="Address"><?php echo FETCH($PageSqls, "LeadPersonAddress"); ?></textarea>
                                                    </div>
                                                </div>

                                                <?php if (AuthAppUser("UserType") == "Admin") { ?>
                                                    <div class="row mb-2px">
                                                        <div class="form-group col-md-6">
                                                            <label>Lead Assigned To</label>
                                                            <select class="form-control form-control-sm" name="LeadPersonManagedBy">
                                                                <?php
                                                                $UserID = AuthAppUser("UserId");
                                                                $companyId = FETCH("SELECT * FROM company_users where company_alloted_user_id='$UserID'", "company_main_id");
                                                                $Users = _DB_COMMAND_("SELECT * FROM users, company_users where users.UserId=company_users.company_alloted_user_id and company_users.company_main_id='$companyId' ORDER BY users.UserFullName ASC", true);

                                                                // $Users = _DB_COMMAND_("SELECT * FROM users ORDER BY UserFullName ASC", true);
                                                                foreach ($Users as $User) {
                                                                    if ($User->UserId == FETCH($PageSqls, "LeadPersonManagedBy")) {
                                                                        $selected = "selected";
                                                                    } else {
                                                                        $selected = "";
                                                                    }
                                                                    echo "<option value='" . $User->UserId . "' $selected>" . $User->UserFullName . " @ " . $User->UserPhoneNumber . "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <div class="row mb-2px">
                                                    <div class="form-group col-md-12">
                                                        <label>Notes/Remarks</label>
                                                        <textarea name="LeadPersonNotes" class="form-control form-control-sm" rows="3"><?php echo SECURE(FETCH($PageSqls, "LeadPersonNotes"), "d"); ?></textarea>
                                                    </div>
                                                </div>

                                                <div class="row mb-2px">
                                                    <div class="col-md-12">
                                                        <a href="index.php" class="btn btn-sm btn-default mt-4" value="<?php echo SECURE($REQ_LeadsId, "e"); ?>"><i class="fa fa-angle-double-left"></i> Back To Details</a>
                                                        <button class="btn btn-sm btn-success mt-4" name="UpdateLeads" value="<?php echo SECURE($REQ_LeadsId, "e"); ?>" TYPE="submit">Update Lead Details</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <script>
                                function CheckCallStatus() {
                                    var call_status = $("#call_status").val();
                                    if (call_status == "FollowUp") {
                                        $("#call_reminder").removeClass("hidden");
                                    } else {
                                        $("#call_reminder").addClass("hidden");
                                    }
                                }
                            </script>
                            <script>
                                function GetExpireDate() {
                                    var date = document.getElementById("purchasedate").value;
                                    var period = document.getElementById("purchaseperiod").value;
                                    var expire = new Date(date);
                                    expire.setFullYear(expire.getFullYear() + parseInt(period));
                                    document.getElementById("expiredate").value = expire.toISOString().substring(0, 10);
                                }

                                function DomainPreview() {
                                    var domain = document.getElementById("domain").value;
                                    document.getElementById("domain_preview").src = "https://www.whois.com/whois/" + domain;
                                }
                            </script>
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