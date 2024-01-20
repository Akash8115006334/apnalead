<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Campaign Reports";
$PageDescription = "Manage all customers";

// Set the file name and path
$filename = 'leads_reports.csv';
$path = __DIR__ . '/' . $filename;

// Open the file for writing
$file = fopen($path, 'w');

// Write the header row
$header_row = ['Sno', 'LeadPersonFullname', 'LeadPersonPhoneNumber', 'LeadPersonEmailId', 'LeadPersonAddress', "ProjectName", 'LeadPersonCreatedAt', 'LeadPersonManagedBy', 'LeadPersonStatus', 'LeadPriorityLevel', 'LeadPersonNotes', 'LeadPersonSource', 'TotalCalls', 'CallDurations', 'TotalFollowUps'];
fputcsv($file, $header_row);

include "../sections/pageHeader.php";
$LEAD_SQLS = _DB_COMMAND_($LEAD_SQLS, true);
if ($LEAD_SQLS == null) {
    NoData("No Leads Found!");
} else {
    $Sno = 0;
    $data_rows = [];
    foreach ($LEAD_SQLS as $Data) {
        $Sno++;
        $LeadsId = $Data->LeadsId;
        $CallCounts = TotalCalls($Data->LeadsId);
        $GetLeadsSeconds = GetLeadsCallDurations($LeadsId);
        $CallDurations = GetDurations($GetLeadsSeconds);
        $row = [
            "$Sno",
            "" . $Data->LeadPersonFullname . "",
            "" . $Data->LeadPersonPhoneNumber . "",
            "" . $Data->LeadPersonEmailId . "",
            "" . $Data->LeadPersonAddress . "",
            "" . FETCH("SELECT ProjectName from projects where ProjectsId='" . FETCH("SELECT * FROM lead_requirements where LeadMainId='" . $LeadsId . "'", "LeadRequirementDetails") . "'", "ProjectName") . "",
            "" . DATE_FORMATES("d M, Y", $Data->LeadPersonCreatedAt) . "",
            "" . FETCH("SELECT UserFullName from users where UserId='" . $Data->LeadPersonManagedBy . "'", "UserFullName") . " (" . UserEmpDetails($Data->LeadPersonManagedBy, "UserEmpJoinedId") . ")",
            "" . $Data->LeadPersonStatus . "",
            "" . $Data->LeadPersonSubStatus . "",
            "" . $Data->LeadPriorityLevel . "",
            "" . SECURE($Data->LeadPersonNotes, "d") . "",
            "" . $Data->LeadPersonSource . "",
            "" . $CallCounts . "",
            "" . $CallDurations . "",
            "" . TOTAL("SELECT * FROM lead_followups where LeadFollowMainId='$LeadsId' and LeadFollowStatus like '%Follow%'") . "",
        ];
        array_push($data_rows, $row);
    }
}

foreach ($data_rows as $data_row) {
    fputcsv($file, $data_row);
}


// Close the file
fclose($file);

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Pragma: no-cache');
readfile($path);
