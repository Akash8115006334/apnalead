<?php require "acm/SysFileAutoLoader.php";
// GET ALL LEADS AND FOLLOW UPS FORM OLD DATABASE 
// $AllLeads = _DB_COMMAND_("SELECT * FROM leadsold", true);
// if ($AllLeads != null) {
//     foreach ($AllLeads as $leads) {
//         $LeadsId = $leads->LeadsId;
//         $name = $leads->LeadPersonFullname;
//         $solutation = $leads->LeadSalutations;
//         $phone = $leads->LeadPersonPhoneNumber;
//         $email = $leads->LeadPersonEmailId;
//         $address = $leads->LeadPersonAddress;
//         $cretedat = $leads->LeadPersonCreatedAt;
//         $updatedat = $leads->LeadPersonLastUpdatedAt;
//         $createdby = $leads->LeadPersonCreatedBy;
//         $managedby = $leads->LeadPersonManagedBy;
//         $status = $leads->LeadPersonStatus;
//         $priority = $leads->LeadPriorityLevel;
//         $notes = $leads->LeadPersonNotes;
//         $source = $leads->LeadPersonSource;
//         $substatus = $leads->LeadPersonSubStatus;
//         $country = $leads->LeadForCountry;
//         $state = $leads->state;
//         $companyid = $leads->CompanyID;
//         $project = $leads->LeadProjectId;

//         $Allfollowups = _DB_COMMAND_("SELECT * FROM lead_followupsold where LeadFollowMainId='$LeadsId'", true);
//         if ($Allfollowups != null) {
//             foreach ($Allfollowups as $followups) {
//                 $FollowupId = $followups->LeadFollowUpId;
//                 $mainid = $followups->LeadFollowMainId;
//                 $callstatus = $followups->CallStatus;
//                 $followstatus = $followups->LeadFollowStatus;
//                 $followcurrentstatus = $followups->LeadFollowCurrentStatus;
//                 $followdat = $followups->LeadFollowUpDate;
//                 $followtime = $followups->LeadFollowUpTime;
//                 $description = $followups->LeadFollowUpDescriptions;
//                 $handleby = $followups->LeadFollowUpHandleBy;
//                 $followcreatedat = $followups->LeadFollowUpCreatedAt;
//                 $calltype = $followups->LeadFollowUpCallType;
//                 $remindstatus = $followups->LeadFollowUpRemindStatus;
//                 $remindnotes = $followups->LeadFollowUpRemindNotes;
//                 $followupdatedat = $followups->LeadFollowUpUpdatedAt;
//                 echo "OLD DATABASE ):- 
//                  LeadsId = (" . $LeadsId . ")
//                  -----LeadFollowupMainId =(" . $mainid . ")
//                  ------LeadPersonStatus = (" . $status . ")
//                  -------LeadPersonPhoneNumber = (" . $phone . ")
//                  ----------CompanyID = (" . $companyid . ")

//                 <br> ";
//             }
//         }
//     }
// }


//ADDING NEW DATABASE FOR FETCHING TODAYS LEADS AND FOLLOW-UPS

//GET NEW LEADS AND FOLLOWUPS 
$GetTodayLeads = _DB_COMMAND_("SELECT * FROM leads WHERE LeadPersonCreatedAt >= '2024-03-07 00:00:00' AND LeadPersonCreatedAt < '2024-03-09 00:00:00';", true);
if ($GetTodayLeads != null) {
    foreach ($GetTodayLeads as $today) {
        $TodayLeadsId = $today->LeadsId;
        $Todayname = $today->LeadPersonFullname;
        $Todaysolutation = $today->LeadSalutations;
        $Todayphone = $today->LeadPersonPhoneNumber;
        $Todayemail = $today->LeadPersonEmailId;
        $Todayaddress = $today->LeadPersonAddress;
        $Todaycretedat = $today->LeadPersonCreatedAt;
        $Todayupdatedat = $today->LeadPersonLastUpdatedAt;
        $Todaycreatedby = $today->LeadPersonCreatedBy;
        $Todaymanagedby = $today->LeadPersonManagedBy;
        $Todaystatus = $today->LeadPersonStatus;
        $Todaypriority = $today->LeadPriorityLevel;
        $Todaynotes = $today->LeadPersonNotes;
        $Todaysource = $today->LeadPersonSource;
        $Todaysubstatus = $today->LeadPersonSubStatus;
        $Todaycountry = $today->LeadForCountry;
        $Todaystate = $today->state;
        $Todaycompanyid = $today->CompanyID;
        $Todayproject = $today->LeadProjectId;
        $Data = [
            "LeadPersonFullname" => $Todayname,
            "LeadSalutations" => $Todaysolutation,
            "LeadPersonPhoneNumber" => $Todayphone,
            "LeadPersonEmailId" => $Todayemail,
            "LeadPersonAddress" => $Todayaddress,
            "LeadPersonCreatedAt" => $Todaycretedat,
            "LeadPersonManagedBy" => $Todaymanagedby,
            "LeadPersonStatus" => $Todaystatus,
            "LeadPriorityLevel" => $Todaypriority,
            "LeadPersonNotes" => $Todaynotes,
            "LeadPersonSource" => $Todaysource,
            "LeadPersonSubStatus" => $Todaysubstatus,
            "LeadForCountry" => $Todaycountry,
            "state" => $Todaystate,
            "CompanyID" => $Todaycompanyid,
            "LeadProjectId" => $Todayproject,
        ];
        $save = INSERT("leadsold", $Data);
        $NewLeadId = FETCH("SELECT LeadsId FROM leadsold ORDER BY LeadsId DESC LIMIT 1", "LeadsId");
        // echo "NEW DATABASE ):-  
        //      -----LeadsId = (" . $TodayLeadsId . ")
        //     ------ Phone Number = (" . $Todayphone . ")
        //    --------CompanyId = (" . $Todaycompanyid . ")
        //    --------Created Date = (" . $Todaycretedat . ")
        //   <br> ";
        // Get all Today follow ups
        $TodayFollowups = _DB_COMMAND_("SELECT * FROM lead_followups WHERE LeadFollowMainId='$TodayLeadsId' and  LeadFollowUpCreatedAt >='2024-03-07 00:00:00' AND LeadFollowUpCreatedAt < '2024-03-09 00:00:00'", true);
        if ($TodayFollowups != null) {
            foreach ($TodayFollowups as $follow) {
                $TodayFollowupId = $follow->LeadFollowUpId;
                $Todaymainid = $follow->LeadFollowMainId;
                $Todaycallstatus = $follow->CallStatus;
                $Todayfollowstatus = $follow->LeadFollowStatus;
                $Todayfollowcurrentstatus = $follow->LeadFollowCurrentStatus;
                $Todayfollowdat = $follow->LeadFollowUpDate;
                $Todayfollowtime = $follow->LeadFollowUpTime;
                $Todaydescription = $follow->LeadFollowUpDescriptions;
                $Todayhandleby = $follow->LeadFollowUpHandleBy;
                $Todayfollowcreatedat = $follow->LeadFollowUpCreatedAt;
                $Todaycalltype = $follow->LeadFollowUpCallType;
                $Todayremindstatus = $follow->LeadFollowUpRemindStatus;
                $Todayremindnotes = $follow->LeadFollowUpRemindNotes;
                $Todayfollowupdatedat = $follow->LeadFollowUpUpdatedAt;
                $NewData = [
                    "LeadFollowMainId" => $NewLeadId,
                    "CallStatus" => $follow->CallStatus,
                    "LeadFollowStatus" => $follow->LeadFollowStatus,
                    "LeadFollowCurrentStatus" => $follow->LeadFollowCurrentStatus,
                    "LeadFollowUpDate" => $follow->LeadFollowUpDate,
                    "LeadFollowUpTime" => $follow->LeadFollowUpTime,
                    "LeadFollowUpDescriptions" => $follow->LeadFollowUpDescriptions,
                    "LeadFollowUpHandleBy" => $follow->LeadFollowUpHandleBy,
                    "LeadFollowUpCreatedAt" => $follow->LeadFollowUpCreatedAt,
                    "LeadFollowUpCallType" => $follow->LeadFollowUpCallType,
                    "LeadFollowUpRemindStatus" => $follow->LeadFollowUpRemindStatus,
                    "LeadFollowUpRemindNotes" => $follow->LeadFollowUpRemindNotes,
                    "LeadFollowUpUpdatedAt" => $follow->LeadFollowUpUpdatedAt,
                ];
                $save2 = INSERT("lead_followupsold", $NewData);
                echo "NEW DATABASE ):-  
                    -----Inserted = (" . $NewLeadId . ")
                    ------Inserted Phone Number = (" . $Todayphone . ")
                    --------Inserted CompanyId = (" . $Todaycompanyid . ")
                    -------- Created Date = (" . $Todaycretedat . ")
                   <br> ";
            }
        }
    }
}
