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
if (isset($_POST['CurrentUrl'])) {
    $CurrentUrl = $_POST['CurrentUrl'];
} else {
    $CurrentUrl = "";
}
// $Getleads = _DB_COMMAND_("SELECT * FROM leads WHERE CompanyID='" . CompanyId . "' ORDER BY LeadsId DESC LIMIT $start, $listcounts", true);
$GetLeads = _DB_COMMAND_($Lead_Sql . "  LIMIT $start, $listcounts", true);
if ($GetLeads == null) { ?>
    <div class="col-md-12 card card-body border-0 shadow-sm">

        <div class="text-left">
            <h1><i class="fa fa-globe fa-spin display-4 text-success"></i></h1>
            <h4 class="text-muted">No Leads found</h4>
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
        $LeadPersonCreatedBy = $leads->LeadPersonCreatedBy;
        $LeadsId = $leads->LeadsId;
        if ($leads->LeadPriorityLevel == "HIGH") {
            $Priority = '<i class="fa fa-flag text-success" aria-hidden="true"></i>';
        } elseif ($leads->LeadPriorityLevel == "MEDIUM") {
            $Priority = '<i class="fa fa-flag text-info" aria-hidden="true"></i>';
        } elseif ($leads->LeadPriorityLevel == "LOW") {
            $Priority = '<i class="fa fa-flag text-warning" aria-hidden="true"></i>';
        } else {
            $Priority = '<i class="fa fa-flag text-dark" aria-hidden="true"></i>';
        }
        if ($leads->LeadPersonStatus == "Follow Up" || $leads->LeadPersonStatus == "FOLLOW-UP" || $leads->LeadPersonStatus == "MEETING PLANNED") {
            $dot = '<i class="fa fa-circle fs-10 text-danger" aria-hidden="true"></i>';
        } elseif ($leads->LeadPersonStatus == "FRESH LEAD" || $leads->LeadPersonStatus == "Fresh Leads") {
            $dot = '<i class="fa fa-circle fs-10 text-success" aria-hidden="true"></i>';
        } else {
            $dot = '<i class="fa fa-circle fs-10 text-info" aria-hidden="true"></i>';
        }
        $FollowUpsSQL = "SELECT LeadFollowUpDate, LeadFollowUpTime  FROM lead_followups where LeadFollowMainId='$LeadsId'";
        $LeadFollowUpDate = FETCH($FollowUpsSQL, "LeadFollowUpDate");
        $LeadFollowUpTime = FETCH($FollowUpsSQL, "LeadFollowUpTime");
        $LeadPersonManagebyName = FETCH("SELECT UserFullName FROM users WHERE UserId='$leads->LeadPersonManagedBy'", "UserFullName");
        $lead_requirements = CHECK("SELECT * FROM data_lead_requirements where DataMainId='$LeadsId'");
        $LeadPersonManagebyUserStatus = FETCH("SELECT UserStatus FROM users WHERE UserId='$leads->LeadPersonManagedBy'", "UserStatus");
        if ($LeadPersonManagebyUserStatus == "1") {
            $status = "<span class='text-success'><i class='fa fa-check-circle'></i></span>";
        } else {
            $status = "<span class='text-danger'><i class='fa fa-warning'></i></span>";
        }
    ?>
        <?php if (DEVICE_TYPE == "COMPUTER") { ?>
            <div class="col-md-12 data-list flex-s-b align-items-center bg-light new-lead-outline">
                <div class="w-pr-5">
                    <span class=""><?php echo $Count; ?></span>
                </div>
                <div class="w-pr-20 ">
                    <span class="d-flex justify-content-start align-items-center w-100">
                        <span class="fs-15" style="width: 10% !important;"><?php echo $Priority; ?></span>
                        <span class="w-75">
                            <a class="w-100 text-primary" href="details/index.php?LeadsId=<?php echo SECURE($leads->LeadsId, "e"); ?>">
                                <span class=" ml-1 bold"> <?php echo $leads->LeadSalutations; ?>
                                    <?php echo LimitText($leads->LeadPersonFullname, 0, 22); ?></span><br>
                                <?php $projectId = FETCH("SELECT LeadRequirementDetails FROM lead_requirements WHERE LeadMainId='$LeadsId'", "LeadRequirementDetails");
                                if ($projectId  == null) {
                                    echo "<span class='text-gray fs-10 '>
                                                                <i class='fa fa-hashtag'></i>No Requirement
                                                                </span>";
                                } else {
                                    $ProjectName = FETCH("SELECT * FROM projects WHERE ProjectsId='$projectId'", "ProjectName");
                                    echo "<span class='text-gray fs-10'>
                                                                <i class='fa fa-hashtag'></i>" . $ProjectName . "
                                                                </span>";
                                } ?>
                            </a>
                        </span>
                    </span>
                </div>
                <div class="w-pr-15 ">
                    <span class=""><?php
                                    if ($leads->LeadPersonPhoneNumber == null) {
                                        echo "No-Phone";
                                    } else {
                                        echo $leads->LeadPersonPhoneNumber;
                                    } ?></span>
                </div>

                <div class="w-pr-13 text-center">
                    <span class="btn btn-default btn-xs cursor-default "><?php echo $dot . " " . $leads->LeadPersonStatus; ?></span>
                </div>
                <div class="w-pr-10 text-center ">
                    <span class="btn btn-default btn-xs cursor-default"> <?php if ($leads->LeadPersonSource == null) {
                                                                                echo "No Source Found!";
                                                                            } else {
                                                                                echo $leads->LeadPersonSource;
                                                                            } ?></span>
                </div>
                <div class="w-pr-10 text-center">
                    <span class=""><?php echo DATE_FORMATES("d M, Y", $leads->LeadPersonCreatedAt); ?></span>
                </div>
                <div class="w-pr-12 text-center ">
                    <span class="btn btn-default btn-xs m-1 cursor-default"> <?php echo $status . " " . $LeadPersonManagebyName; ?></span>
                </div>
                <div class="w-pr-15 ">
                    <span class="d-flex justify-content-around">
                        <span class='w-100 text-center'>
                            <a href='tel:<?php echo $leads->LeadPersonPhoneNumber; ?>' class='btn btn-md btn-default'> <i class='fa fa-phone text-success h5'></i><br></a>
                        </span>
                        <span class='w-100 text-center'>
                            <a href='#' onmouseover="GetInstantTime('displayTime_<?php echo $LeadsId; ?>', 'value')" onclick="Databar('Lead_Update_<?php echo $LeadsId; ?>')" class='btn btn-md btn-default' id="feedBackFormIconId"><i class="fa fa-comments text-info" aria-hidden="true"></i></a>
                        </span>
                        <span class='w-100 text-center'>
                            <div class='btn btn-md btn-default popup-btn'><i class="fa fa-ellipsis-h" aria-hidden="true"></i></div>
                            <div class="popup">
                                <div class=" text-center text-info "> <i class='fa fa-user'></i>
                                    <?php echo $leads->LeadSalutations . " " . $leads->LeadPersonFullname; ?>
                                </div>
                                <hr class="mt-0">
                                <div class="flex-s-b w-100">
                                    <span class="w-pr-50">
                                        <span class="text-gray"><i class='fa fa-phone text-success h6'></i> <b><?php echo TOTAL("SELECT LeadFollowUpId FROM lead_followups WHERE LeadFollowMainId='$LeadsId'"); ?></b> Calls </span>
                                    </span>
                                    <span class="w-pr-50">
                                        <span class="text-gray"> <i class='fa fa-refresh text-danger h6'></i> <b><?php echo TOTAL("SELECT LeadFollowStatus FROM lead_followups where LeadFollowMainId='$LeadsId' and LeadFollowStatus like '%Follow%'"); ?></b> Follow ups <b></b></span>
                                    </span>
                                </div>
                                <div class="w-100">
                                    <span class='text-small bold text-left w-pr-100'>Last Feedback</span>
                                    <hr class="mt-0 mb-0 ">
                                    <span class="text-justify w-100  fs-10">
                                        <?php
                                        $LastFeedback = FETCH("SELECT LeadFollowUpDescriptions from lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC limit 1", "LeadFollowUpDescriptions");
                                        if ($LastFeedback == null) {
                                            echo "No feedback";
                                        } else {
                                            echo $LastFeedback;
                                        } ?>
                                    </span>
                                </div>
                            </div>
                        </span>
                        <?php
                        if (AuthAppUser("UserType") == "Admin") { ?>
                            <span class=" w-100  text-center d-flex justify-content-center align-items-center"> <?php

                                                                                                                CONFIRM_DELETE_POPUP('delete_leads', [
                                                                                                                    "delete_leads" => true,
                                                                                                                    "control_id" => $LeadsId,
                                                                                                                ], "ModuleHandler", "<i class='fa fa-trash '></i>", "btn btn-md btn-danger");
                                                                                                                ?></span><?php  } ?>
                    </span>
                    </span>
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
                                        <?php echo $leads->LeadSalutations . " " . $leads->LeadPersonFullname; ?>
                                    </a>
                                </h5>
                                <div class="w-100 flex-s-b lead-action mt-2">
                                    <a href="tel:<?php echo $leads->LeadPersonPhoneNumber; ?>" onclick="Databar('Lead_Update_<?php echo $LeadsId; ?>')" class=" btn btn-xs btn-default  fs-12"><i class="fa fa-phone"></i><?php echo $leads->LeadPersonPhoneNumber; ?></a>
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
                            <span class="text-gray fs-10"> <?php echo TOTAL("SELECT LeadFollowUpId FROM lead_followups WHERE LeadFollowMainId='$LeadsId'"); ?></span><br>
                            <span class="text-gray fs-10"><?php echo TOTAL("SELECT LeadFollowStatus FROM lead_followups where LeadFollowMainId='$LeadsId' and LeadFollowStatus like '%Follow%'"); ?> Followups</span><br>
                        </div>

                    </div>
                    <div class="flex-s-b align-items-center col-sm-12">
                        <div class="w-pr-60">
                            <span class="btn btn-xs btn-success mt-1"><?php echo $leads->LeadPersonStatus; ?></span><br>
                            <span class="btn btn-xs btn-danger mt-1"><?php if ($leads->LeadPersonSubStatus == null) {
                                                                            echo "No FOLLOW UP Found!";
                                                                        } else {
                                                                            echo $leads->LeadPersonSubStatus;
                                                                        }; ?></span>
                        </div>
                        <div class="w-pr-30  text-right">
                            <a href="#" class="btn btn-md btn-primary" onmouseover="GetInstantTime('displayTime_<?php echo $LeadsId; ?>', 'value')" onclick="Databar('Lead_Update_<?php echo $LeadsId; ?>')"><i class="fa fa-plus"></i></a>
                            <a href="tel:<?php echo $leads->$LeadPersonPhoneNumber; ?>" onclick="Databar('Lead_Update_<?php echo $LeadsId; ?>')" class=" btn btn-md btn-success  fs-12"><i class="fa fa-phone"></i></a>
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
<?php }
        include "../../include/forms/Add-Instant-Feedback.php";
    }
}
?>