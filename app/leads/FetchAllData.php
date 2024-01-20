<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';
$Lead_Sql = $_POST['Lead_Sql'];
$TotalItems = $_POST['TotalLeads'];
$listcounts = $_POST['ListCount'];
$page = $_POST['view_page'];
$start = ($page - 1) * $listcounts;
$next_page = ($page + 1);
$previous_page = ($page - 1);
// $Getleads = _DB_COMMAND_("SELECT * FROM leads WHERE CompanyID='" . CompanyId . "' ORDER BY LeadsId DESC LIMIT $start, $listcounts", true);
$GetLeads = _DB_COMMAND_($Lead_Sql . "  LIMIT $start, $listcounts", true);

if ($GetLeads == null) { ?>
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
    <?php
} else {
    if ($page == 1 || $page == 0) {
        $Count = 0;
    } else {
        $Count = ($page - 1) * $listcounts;
    }
    foreach ($GetLeads as $leads) {
        $Count++;
        $LeadsId = $leads->LeadsId;
        $LeadPersonName = $leads->LeadSalutations . " " . LimitText($leads->LeadPersonFullname, 0, 37);
        if ($leads->LeadPersonPhoneNumber == null) {
            $LeadPersonPhone = "NO PHONE NUMBER";
        } else {
            $LeadPersonPhone = $leads->LeadPersonPhoneNumber;
        }
        if ($leads->LeadPersonEmailId == null) {
            $LeadPersonEmail = "NO EMAIL";
        } else {
            $LeadPersonEmail = $leads->LeadPersonEmailId;
        }
        if ($leads->LeadPersonSubStatus == null) {
            $LeadPersonSubStatus = "No FOLLOWUP Found!";
        } else {
            $LeadPersonSubStatus = $leads->LeadPersonSubStatus;
        }
        $LeadPersonCreatedAt = DATE_FORMATES("d M, Y", $leads->LeadPersonCreatedAt);
        if ($leads->LeadPersonStatus == "0") {
            $LeadPersonStatus = "FRESH LEAD";
        } else {
            $LeadPersonStatus = $leads->LeadPersonStatus;
        }
        $LeadPersonStatus = $leads->LeadPersonStatus;
        $LeadPersonPriority = $leads->LeadPriorityLevel;
        if ($leads->LeadPersonSource == null) {
            $LeadPersonSource = "No Source!";
        } else {
            $LeadPersonSource = $leads->LeadPersonSource;
        }

        $TotalCall = TotalCalls($LeadsId);
        $TotalFollowups = TOTAL("SELECT * FROM lead_followups where LeadFollowMainId='$LeadsId' and LeadFollowStatus like '%Follow%'");
        $LeadPersonManagebyName = FETCH("SELECT UserFullName FROM users WHERE UserId='$leads->LeadPersonManagedBy'", "UserFullName");
        $LeadPersonManagebyPhone = FETCH("SELECT UserPhoneNumber FROM users WHERE UserId='$leads->LeadPersonManagedBy'", "UserPhoneNumber");
        $LeadPersonManagebyUsertype = FETCH("SELECT UserType FROM users WHERE UserId='$leads->LeadPersonManagedBy'", "UserType");
        $LeadPersonManagebyUserStatus = FETCH("SELECT UserStatus FROM users WHERE UserId='$leads->LeadPersonManagedBy'", "UserStatus");
        $LeadPersonManagebyEmail = FETCH("SELECT UserEmailId FROM users WHERE UserId='$leads->LeadPersonManagedBy'", "UserEmailId");
        $FollowUpsSQL = "SELECT LeadFollowUpDate, LeadFollowUpTime  FROM lead_followups where LeadFollowMainId='$LeadsId'";
        $LeadFollowUpDate = FETCH($FollowUpsSQL, "LeadFollowUpDate");
        $LeadFollowUpTime = FETCH($FollowUpsSQL, "LeadFollowUpTime");
        if ($LeadPersonManagebyUserStatus == "1") {
            $status = "<span class='text-success'><i class='fa fa-check-circle'></i></span>";
        } else {
            $status = "<span class='text-danger'><i class='fa fa-warning'></i></span>";
        }
        if (DEVICE_TYPE == "COMPUTER") { ?>
            <div class="col-md-12">
                <div class="data-list flex-s-b bg-light">
                    <div class="w-pr-3 mt-2">
                        <span><?php echo $Count; ?></span>
                    </div>
                    <div class="w-pr-30 pt-2">
                        <span class="text-primary">
                            <a class="w-100 text-primary" href="details/index.php?LeadsId='<?php echo SECURE($leads->LeadsId, "e"); ?>">
                                <span class="text-info"> <i class="fa fa-user"></i> <?php echo $LeadPersonName; ?></span> <br>
                                <?php $ProjectId = _DB_COMMAND_("SELECT LeadRequirementDetails FROM lead_requirements WHERE LeadMainId='$LeadsId' LIMIT 2", true);
                                if ($ProjectId !== null) {
                                    $proCount = 0;
                                    foreach ($ProjectId as $Pid) {
                                        $proCount++;
                                        $ProjectName = FETCH("SELECT ProjectName FROM projects where ProjectsId='$Pid->LeadRequirementDetails'", "ProjectName"); ?>
                                        <span class='btn btn-xs btn-warning fs-10'><i class='fa fa-hashtag'></i> <?php echo $ProjectName; ?> </span>
                                    <?php
                                    }
                                    if ($proCount > 1) { ?>
                                        <span class='bold text-danger fs-10'>...+ More</span>
                                    <?php
                                    }
                                } else { ?>
                                    <span class='btn btn-xs btn-warning fs-10'> <i class='fa fa-hashtag'></i>No Requirement </span>
                                <?php  } ?>
                                <br>
                                <span class="text-black mt-2"><i class="fa fa-phone text-success"></i> <?php echo $LeadPersonPhone ?><br></span>
                                <span class="text-black"><i class="fa fa-envelope text-danger"></i> <?php echo  $LeadPersonEmail; ?></span><br>
                                <span class="text-black"> <i class="fa fa-clock-o text-success fs-15" aria-hidden="true"></i> <?php echo $LeadPersonCreatedAt; ?></span><br>
                            </a>
                        </span>
                    </div>
                    <div class="w-pr-15 text-right pt-3">
                        <span class="btn btn-xs btn-default m-1"><?php echo $LeadPersonPriority; ?></span><br>
                        <span class="btn btn-xs btn-info m-1"><?php echo $LeadPersonSource; ?></span><br>
                        <span class="btn btn-xs btn-default m-1">Managed By</span><br>
                    </div>
                    <div class="w-pr-15 pt-3">
                        <span class="btn btn-xs btn-success m-1"><?php echo $leads->LeadPersonStatus; ?></span><br>
                        <span class="btn btn-xs btn-danger m-1"><?php echo $LeadPersonSubStatus; ?></span><br>
                        <span class="btn btn-default btn-xs m-1"> <?php echo $status . $LeadPersonManagebyName; ?></span><br>
                    </div>
                    <div class="w-pr-25 pt-2 m-1" style="line-height:0.85rem !important;">
                        <div class="shadow-sm p-1 cursor" onclick="Databar('feedback_list_<?php echo $LeadsId; ?>')">
                            <span class="bold text-primary">Last Feedbacks</span><br>
                            <span class="small">
                                <?php
                                $CountFeedbacks = TOTAL("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime from lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC");
                                $LastFeedbacks = _DB_COMMAND_("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime ,LeadFollowUpCreatedAt from lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC limit 3", true);
                                if ($LastFeedbacks != NULL) {
                                    foreach ($LastFeedbacks as $Feedback) { ?>
                                        <span class="text-grey small"><i class="fa fa-angle-double-right"></i> <?php echo DATE_FORMATES("d M, Y", $Feedback->LeadFollowUpCreatedAt) . ' ' . DATE_FORMATES("h:i A", $Feedback->LeadFollowUpCreatedAt); ?> @</span><br><?php echo $Feedback->LeadFollowUpDescriptions; ?> <br>
                                    <?php }
                                    if ($CountFeedbacks > 3) { ?>
                                        <span class="pull-right" style="margin-top:-0.9rem;"><?php echo ($CountFeedbacks - 3); ?>+ <i class="fa fa-angle-down"></i></span>
                                        <div class="hidden small" id="feedback_list_<?php echo $LeadsId; ?>">
                                            <span class="small">
                                                <?php
                                                $LastFeedbacks = _DB_COMMAND_("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime, LeadFollowUpCreatedAt from lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC limit 3, 100", true);
                                                foreach ($LastFeedbacks as $Feedback) { ?>
                                                    <span class="text-grey small"><i class="fa fa-angle-double-right"></i> <?php echo DATE_FORMATES("d M, Y", $Feedback->LeadFollowUpCreatedAt) . ' ' . DATE_FORMATES("h:i A", $Feedback->LeadFollowUpCreatedAt); ?> @</span><br><?php echo  $Feedback->LeadFollowUpDescriptions; ?><br>
                                                <?php  } ?>
                                            </span>

                                        </div>
                                    <?php  }
                                } else { ?>
                                    <span>No Feedback Found!</span>
                                <?php } ?>
                            </span>
                        </div>
                    </div>
                    <div class='w-pr-40'>
                        <span class='flex-s-b p-1 mt-2'>
                            <span class='w-100 text-center app-sub-heading fs-15 p-1 mt-3 m-1'>
                                <i class='fa fa-phone text-success mt-1' style='font-size:1.5rem !important;'></i><br>
                                <small><?php echo $TotalCall; ?></small>
                            </span>

                            <span class='w-100 text-center app-sub-heading fs-15 p-1 mt-3 m-1'>
                                <i class='fa fa-clock text-warning mt-1' style='font-size:1.5rem !important;'></i><br>
                                <small>0 Sec</small>
                            </span>
                            <span class='w-100 text-center app-sub-heading fs-15 p-1 mt-3 m-1'>
                                <i class='fa fa-refresh text-danger mt-1' style='font-size:1.5rem !important;'></i><br>
                                <small><?php echo $TotalFollowups; ?> Followups</small>
                            </span>
                            <span class='mt-3 w-100 app-sub-heading m-1 text-center d-flex justify-content-center align-items-center'>
                                <a href='#' onmouseover="GetInstantTime('displayTime_<?php echo $LeadsId; ?>', 'value')" onclick="Databar('Lead_Update_<?php echo $LeadsId; ?>')" class='btn btn-md btn-success'><i class='fa fa-plus'></i></a></span>
                            <span class='mt-3 w-100 app-sub-heading m-1 text-center d-flex justify-content-center align-items-center'>
                                <?php if (AuthAppUser("UserType") == "Admin") {
                                    CONFIRM_DELETE_POPUP('delete_leads', [
                                        'delete_leads' => true,
                                        'control_id' => $LeadsId,
                                    ], 'ModuleHandler', '<i class="fa fa-trash"></i>', 'btn btn-danger');
                                } ?>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="col-md-4 col-12 col-xs-6">
                <div class="data-list bg-light" style="line-height:1rem !important;">
                    <div class="w-pr-100 text-left">
                        <span class="mr-0 count"><?php echo $Count; ?></span>
                    </div>
                    <div class="flex-s-b">
                        <div class="w-pr-67 pl-2">
                            <div class="">
                                <h5 class="mb-1  ">
                                    <a class="btn btn-xs btn-info text-light bold" href="details/index.php?LeadsId=<?php echo SECURE($leads->LeadsId, "e"); ?>"> <i class="fa fa-user"></i>
                                        <?php echo $LeadPersonName; ?>
                                    </a>
                                </h5>
                                <div class="w-100 flex-s-b lead-action mt-2">
                                    <a href="tel:<?php echo $LeadPersonPhone; ?>" onclick="Databar('Lead_Update_<?php echo $LeadsId; ?>')" class=" btn btn-xs btn-default  fs-12"><i class="fa fa-phone"></i><?php echo $leads->LeadPersonPhoneNumber; ?></a>
                                    <span class="btn btn-xs btn-warning ml-1">
                                        <i class="fa fa-hashtag"></i>
                                        <?php
                                        $ProjectId = FETCH("SELECT LeadRequirementDetails FROM lead_requirements WHERE LeadMainId='$LeadsId'", "LeadRequirementDetails");
                                        $ProjectName = FETCH("SELECT ProjectName FROM projects where ProjectsId='$ProjectId'", "ProjectName");
                                        if ($ProjectId == null) {
                                            echo "No Requirement";
                                        } else {
                                            echo $ProjectName;
                                        } ?>
                                    </span>
                                </div>

                            </div>
                        </div>
                        <div class="w-pr-33 text-right">
                            <span class="text-gray fs-10"> <?php echo $TotalCall; ?></span><br>
                            <span class="text-gray fs-10"><?php echo $TotalFollowups; ?> Followups</span><br>
                        </div>

                    </div>
                    <div class="flex-s-b align-items-center col-sm-12">
                        <div class="w-pr-60">
                            <span class="btn btn-xs btn-success mt-1"><?php echo $leads->LeadPersonStatus; ?></span><br>
                            <span class="btn btn-xs btn-danger mt-1"><?php echo $LeadPersonSubStatus; ?></span>
                        </div>
                        <div class="w-pr-30  text-right">
                            <a href="#" class="btn btn-md btn-primary" onmouseover="GetInstantTime('displayTime_<?php echo $LeadsId; ?>', 'value')" onclick="Databar('Lead_Update_<?php echo $LeadsId; ?>')"><i class="fa fa-plus"></i></a>
                            <a href="tel:<?php echo $LeadPersonPhone; ?>" onclick="Databar('Lead_Update_<?php echo $LeadsId; ?>')" class=" btn btn-md btn-success  fs-12"><i class="fa fa-phone"></i></a>
                        </div>
                    </div>




                    <div class="w-100 mt-2">
                        <div class="shadow-sm p-1 cursor" onclick="Databar('feedback_list_<?php echo $LeadsId; ?>')">
                            <span class="bold text-primary">Last Feedbacks</span><br>
                            <span class="small">
                                <?php
                                $CountFeedbacks = TOTAL("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime from lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC");
                                $LastFeedbacks = _DB_COMMAND_("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime, LeadFollowUpCreatedAt from lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC limit 1", true);
                                if ($LastFeedbacks != NULL) {
                                    foreach ($LastFeedbacks as $Feedback) { ?>
                                        <span class="text-grey small"><i class="fa fa-angle-double-right"></i> <?php echo DATE_FORMATES("d M, Y", $Feedback->LeadFollowUpCreatedAt) . ' ' . DATE_FORMATES("h:i A", $Feedback->LeadFollowUpCreatedAt); ?> @</span><br><?php echo $Feedback->LeadFollowUpDescriptions; ?><br>
                                    <?php }
                                    if ($CountFeedbacks > 1) { ?>
                                        <span class="pull-right" style="margin-top:-0.9rem;"><?php echo ($CountFeedbacks - 1); ?>+ <i class="fa fa-angle-down"></i></span>
                                        <div class="hidden small" id="feedback_list_<?php echo $LeadsId; ?>">
                                            <span class="small">
                                                <?php
                                                $LastFeedbacks = _DB_COMMAND_("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime , LeadFollowUpCreatedAt from lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC limit 1, 100", true);
                                                foreach ($LastFeedbacks as $Feedback) { ?>
                                                    <span class="text-grey small"><i class="fa fa-angle-double-right"></i> <?php echo DATE_FORMATES("d M, Y", $Feedback->LeadFollowUpCreatedAt) . ' ' . DATE_FORMATES("h:i A", $Feedback->LeadFollowUpCreatedAt); ?> @</span><br><?php echo  $Feedback->LeadFollowUpDescriptions; ?><br>
                                                <?php } ?>
                                            </span>
                                        </div>
                                <?php  }
                                } else {
                                    echo '<span>No Feedback Found!</span>';
                                } ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- feedback  -->
        <section class="pop-section hidden" id="Lead_Update_<?php echo $LeadsId; ?>">
            <div class="action-window">
                <div class='container'>
                    <div class='row'>
                        <div class='col-md-12'>
                            <h4 class='app-heading'>Add Feedback </h4>
                        </div>
                    </div>
                    <form action="<?php echo CONTROLLER; ?>/ModuleHandler.php" method="POST">
                        <?php FormPrimaryInputs(true, [
                            "LeadFollowMainId" => $LeadsId
                        ]);
                        $PageSqls = "SELECT * FROM leads where LeadsId='$LeadsId'"; ?>
                        <input type="text" hidden id="leascurrentstatus_<?php echo $LeadsId; ?>" name="LeadFollowCurrentStatus" value="">
                        <input type="text" hidden id='displayTime_<?php echo $LeadsId; ?>' name="StartTime" value=''>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <p><b>Was Call Connected?</b></p>
                                    </div>
                                    <div class="form-group col-md-6 mt-2">
                                        <span id="call_not_connected_<?php echo $LeadsId; ?>" class="btn btn-default w-100">Not Connected?</span>
                                    </div>
                                    <div class="form-group col-md-6 mt-2">
                                        <span id="call_connected_<?php echo $LeadsId; ?>" class="btn btn-default w-100">Yes, Connected?</span>
                                    </div>
                                </div>
                                <div class="row w-100 text-left hidden" id="call_not_connected_box_<?php echo $LeadsId; ?>">
                                    <div class="col-md-12">
                                        <hr>
                                        <p><b>Please specify the reason?</b></p>
                                        <hr>
                                    </div>
                                    <div class="col-md-6 ml-3">
                                        <label class="btn btn-default"><input type="Radio" value="Out Of Coverage Area" name="LeadFollowStatus"> Out Of Coverage Area</label><br>
                                        <label class="btn btn-default"><input type="Radio" value="Switch Off" name="LeadFollowStatus"> Switch Off </label><br>
                                        <label class="btn btn-default"><input type="Radio" value="Number Dose not Exist" name="LeadFollowStatus"> Number Dose not Exist </label><br>
                                        <label class="btn btn-default"><input type="Radio" value="Out of Validity" name="LeadFollowStatus"> Out of Validity </label><br>
                                        <label class="btn btn-default"><input type="Radio" value="Not Picked" name="LeadFollowStatus"> Not Picked</label><br>
                                    </div>
                                </div>
                                <div class="row w-100 text-left hidden" id="call_connected_box_<?php echo $LeadsId; ?>">
                                    <div class="col-md-12">
                                        <hr>
                                        <p><b>Please specify the reason?</b></p>
                                        <hr>
                                    </div>
                                    <div class="col-md-5 ml-3">
                                        <!-- <small>Your Added Status</small> -->
                                        <?php
                                        $UserID = AuthAppUser("UserId");
                                        $companyID = FETCH("SELECT * FROM company_users WHERE company_alloted_user_id='$UserID'", "company_main_id");
                                        $Industry = _DB_COMMAND_("SELECT * FROM configs, config_values WHERE configs.ConfigsId=config_values.ConfigValueGroupId AND configs.ConfigsId='7' AND config_values.CompanyID='$companyID' ORDER BY ConfigValueId ASC", true);

                                        if ($Industry != null) {
                                            foreach ($Industry as $Industry_Name) {
                                                echo '<label class="btn btn-default"><input type="radio" value="' . $Industry_Name->ConfigValueDetails . '" name="LeadFollowStatus" onclick="checkFollowUp_' . $LeadsId . '(this)"> ' . $Industry_Name->ConfigValueDetails . '</label><br>';
                                            }
                                        } else {
                                            NoData("Add more Call Status!!");
                                        }
                                        ?>
                                    </div>

                                    <div class="col-md-12 m-2">
                                        <span onclick="Databar('reminder_<?php echo $LeadsId; ?>')" id="mycheckbtnspan_<?php echo $LeadsId; ?>" class="btn btn-info hidden">
                                            <input id="set_reminder_<?php echo $LeadsId; ?>" name="mycheckbtn" type="checkbox" style="display: none;">Set Reminder
                                        </span>
                                        <div class="w-100 p-1 hidden mt-3" id="reminder_<?php echo $LeadsId; ?>">
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
                                            <span class="btn btn-default ml-1" id="Show_Time_Box_<?php echo $LeadsId; ?>">Other</span>
                                            <label class="m-1 hidden" id="Time_Box_<?php echo $LeadsId; ?>">
                                                <span class="d-flex feedbackspan">
                                                    <input type="date" name="LeadFollowUpDate" class="form-control form-control-sm" value="<?php echo date("Y-m-d"); ?>">
                                                    <input type="time" name="LeadFollowUpTime" value="<?php echo DATE("H:i", strtotime("+5 min")); ?>" class="form-control form-control-sm"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 m-2">
                                        <div class="form-group">
                                            <label>Lead Priority level </label>
                                            <select class="form-control form-control-sm" name="LeadPriorityLevel">
                                                <?php CONFIG_VALUES("LEAD_PERIORITY_LEVEL", FETCH($PageSqls, "LeadPriorityLevel")); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <style>

                                </style>
                                <div class="row ">

                                    <div class="col-md-12 mt-3">
                                        <div id="calldesc">
                                            <div class="form-group text-left">
                                                <label>Notes/Remark</label>
                                                <textarea class="form-control" name="LeadFollowUpDescriptions" rows="2" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit" name="AddLeadStatus" class="btn btn-md btn-success">Add Status</button>
                                <a href="#" onclick="Databar('Lead_Update_<?php echo $LeadsId; ?>')" class="btn btn-md btn-default mt-3">cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <script>
            // call connected or not
            var Notconnected_<?php echo $LeadsId; ?> = document.getElementById("call_not_connected_<?php echo $LeadsId; ?>");
            var Connected_<?php echo $LeadsId; ?> = document.getElementById("call_connected_<?php echo $LeadsId; ?>");
            var NotconnectedBox_<?php echo $LeadsId; ?> = document.getElementById("call_not_connected_box_<?php echo $LeadsId; ?>");
            var ConnectedBox_<?php echo $LeadsId; ?> = document.getElementById("call_connected_box_<?php echo $LeadsId; ?>");
            var Reminder_<?php echo $LeadsId; ?> = document.getElementById("set_reminder_<?php echo $LeadsId; ?>");
            var ReminderSpan_<?php echo $LeadsId; ?> = document.getElementById("mycheckbtnspan_<?php echo $LeadsId; ?>");

            // console.log(ConnectedBox);
            Notconnected_<?php echo $LeadsId; ?>.addEventListener("click", function() {
                NotconnectedBox_<?php echo $LeadsId; ?>.classList.remove("hidden");
                Notconnected_<?php echo $LeadsId; ?>.classList.remove("btn-default");
                Connected_<?php echo $LeadsId; ?>.classList.remove("btn-primary");
                Notconnected_<?php echo $LeadsId; ?>.classList.add("btn-primary");
                ConnectedBox_<?php echo $LeadsId; ?>.classList.add("hidden");
                Connected_<?php echo $LeadsId; ?>.classList.add("btn-default");
            });

            Connected_<?php echo $LeadsId; ?>.addEventListener("click", function() {
                // Remove the "hidden" class from ConnectedBox
                ConnectedBox_<?php echo $LeadsId; ?>.classList.remove("hidden");
                Connected_<?php echo $LeadsId; ?>.classList.remove("btn-default");
                Notconnected_<?php echo $LeadsId; ?>.classList.remove("btn-primary");
                Connected_<?php echo $LeadsId; ?>.classList.add("btn-primary");
                NotconnectedBox_<?php echo $LeadsId; ?>.classList.add("hidden");
                Notconnected_<?php echo $LeadsId; ?>.classList.add("btn-default");
            });

            function checkFollowUp_<?php echo $LeadsId; ?>(radio) {
                if (radio.value.toUpperCase() === "FOLLOW-UP" || radio.value.toUpperCase() === "FOLLOW UP" || radio.value.toUpperCase() === "MEETING PLAN" || radio.value.toUpperCase() === "MEETING PLANNED" || radio.value.toUpperCase() === "SITE VISIT PLANNED") {
                    ReminderSpan_<?php echo $LeadsId; ?>.classList.remove("hidden");
                } else {
                    ReminderSpan_<?php echo $LeadsId; ?>.classList.add("hidden");
                }
            }

            ReminderSpan_<?php echo $LeadsId; ?>.addEventListener("click", function() {
                Reminder_<?php echo $LeadsId; ?>.checked = !Reminder_<?php echo $LeadsId; ?>.checked;
            });
            var ShowTimeBox_<?php echo $LeadsId; ?> = document.getElementById("Show_Time_Box_<?php echo $LeadsId; ?>");
            var TimeBox_<?php echo $LeadsId; ?> = document.getElementById("Time_Box_<?php echo $LeadsId; ?>");
            var radioButtons_<?php echo $LeadsId; ?> = document.getElementsByName("predefinetime_<?php echo $LeadsId; ?>");
            ShowTimeBox_<?php echo $LeadsId; ?>.addEventListener("click", function() {
                TimeBox_<?php echo $LeadsId; ?>.classList.toggle("hidden");
                if (!TimeBox_<?php echo $LeadsId; ?>.classList.contains("hidden")) {
                    // If "Other" is clicked, uncheck all radio buttons
                    radioButtons_<?php echo $LeadsId; ?>.forEach(function(radioButton) {
                        radioButton.checked = false;
                    });
                }

            });
        </script>

    <?php   }
    ?>
<?php }
?>