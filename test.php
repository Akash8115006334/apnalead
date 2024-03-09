<?php require "acm/SysFileAutoLoader.php";

//fetch all leads
// $AllLeads = _DB_COMMAND_("SELECT LeadPersonPhoneNumber,LeadsId FROM leads ORDER BY LeadPersonPhoneNumber ASC", true);
// if ($AllLeads != null) {
//     $LeadCount = 0;
//     foreach ($AllLeads as $Leads) {
//         $LeadCount++;
//         $LeadsId2 = $Leads->LeadsId;
//         $Leadstatus = $Leads->LeadPersonStatus;
//         $RealPhoneNumber = $Leads->LeadPersonPhoneNumber;
//         // $NewPhoneNumber = preg_replace('/[^0-9]/', '', $Leads->LeadPersonPhoneNumber);
//         // $PhoneNumberLength = strlen($NewPhoneNumber);
//         // //trim phone number and only 10 digit number
//         // $TrimedPhoneNumber = substr($NewPhoneNumber, -10);

//         //check duplicate
//         $DuplicateLeads = _DB_COMMAND_("SELECT LeadPersonPhoneNumber FROM leads WHERE LeadPersonPhoneNumber='$RealPhoneNumber'", true);
//         $DuplicateCount = 0;
//         if ($DuplicateLeads != null) {
//             foreach ($DuplicateLeads as $Dleads) {
//                 $DuplicateCount++;
//             }
//         } else {
//             $DuplicateCount = $DuplicateCount;
//         }
//         if ($DuplicateCount > 1) {
//             $DeletCount = $DuplicateCount - 1;
//             $Status = "Deletion Required";
//             //$DeleteUploads = DELETE_SQL("DELETE FROM lead_uploads where LeadsPhone='$RealPhoneNumber' limit $DeletCount");
//             // $DeleteLeads = DELETE_SQL("DELETE FROM leads where LeadPersonStatus like '%Fresh lead%' and LeadPersonPhoneNumber='$RealPhoneNumber' limit $DeletCount");
//             $AllLeadsForFollowup = _DB_COMMAND_("SELECT LeadsId FROM leads where LeadPersonPhoneNumber='$RealPhoneNumber' limit $DeletCount", true);
//             if ($AllLeadsForFollowup != null) {
//                 foreach ($AllLeadsForFollowup as $LeadFollowup) {
//                     $LeadsId = $LeadFollowup->LeadsId;
//                     $UpdateFollowups = UPDATE("UPDATE lead_followups SET LeadFollowMainId='$LeadsId2' WHERE LeadFollowMainId='$LeadsId'");
//                     $UpdateRequirement = UPDATE("UPDATE lead_requirements SET LeadMainId='$LeadsId2' WHERE LeadMainId='$LeadsId'");

//                     $UpdatePhone = UPDATE("UPDATE leads SET LeadPersonPhoneNumber='$TrimedPhoneNumber' where LeadsId='$LeadsId'");
//                 }
//             }
//         } else {
//             $UpdatePhone = UPDATE("UPDATE leads SET LeadPersonPhoneNumber='$TrimedPhoneNumber' where LeadsId='$LeadsId2'");
//             $Status = "Ok";
//             $DeleteLeads = "1";
//             $DeleteUploads = "1";
//         }
//         echo "
//     LEAD-($LeadCount)
//     ---DATA:(" . $Leads->LeadPersonPhoneNumber . ")
//     ---PHONE:($NewPhoneNumber)
//     ---LENGTH:($PhoneNumberLength)
//     ---TRIMMED-PHONE:($TrimedPhoneNumber)
//     ---DOUBLE:($DuplicateCount)
//     ---STATUS:($Status)
//     ---DELETE-LEAD:($DeleteLeads)
//     <br>";
//     }
// }




// validate the number

// $AllInvalidNumber = _DB_COMMAND_("SELECT LeadPersonPhoneNumber ,LeadsId FROM leads ORDER BY LeadPersonPhoneNumber ASC", true);
// if ($AllInvalidNumber != null) {
//     foreach ($AllInvalidNumber as $invalid) {
//         $LeadsId = $invalid->LeadsId;
//         $RealPhone = $invalid->LeadPersonPhoneNumber;
//         $NewPhoneNumber = preg_replace('/[^0-9]/', '', $RealPhone);
//         $PhoneNumberLength = strlen($NewPhoneNumber);
//         //trim phone number and only 10 digit number
//         $TrimedPhoneNumber = substr($NewPhoneNumber, -10);

//         $UpdatePhone = UPDATE("UPDATE leads SET LeadPersonPhoneNumber='$TrimedPhoneNumber' where LeadsId='$LeadsId'");

//         echo "
//            LeadsId = (" . $LeadsId . ")
//            -------RealPhoneNumber = (" . $RealPhone . ")
//            --------Number Length = (" . $PhoneNumberLength . ")
//            ---------New Phone Number = (" . $TrimedPhoneNumber . ")
//            <br>
//         ";
//     }
// }




/// check the duplicate number

$AllNumbers = _DB_COMMAND_("SELECT LeadPersonPhoneNumber, LeadPersonStatus, LeadsId ,LeadPersonFullName FROM leads   ORDER BY LeadPersonPhoneNumber ASC", true);
$TotalLeadsWithDuplicate =  TOTAL("SELECT LeadsId FROM leads  ORDER BY LeadPersonPhoneNumber ASC");
$Allduplicate = TOTAL("SELECT LeadPersonPhoneNumber FROM leads GROUP BY LeadPersonPhoneNumber HAVING COUNT(LeadPersonPhoneNumber) > 1");
echo "TotalLeadsWithDuplicate = " . $TotalLeadsWithDuplicate;
echo "<br> Total Duplicate Leads = " . $Allduplicate . "<br>";

$seenNumbers = [];
$duplicateNumbers = [];

if ($AllNumbers != null) {
    foreach ($AllNumbers as $number) {
        $LeadPersonPhoneNumber = $number->LeadPersonPhoneNumber;
        $status = $number->LeadPersonStatus;
        $LeadsId = $number->LeadsId;

        echo "
        LeadsId = (" . $LeadsId . ")
        --------LeadPersonStatus = (" . $status . ")
        ------LeadPersonPhoneNumber = (" . $LeadPersonPhoneNumber . ")";

        // Check if the number is a duplicate
        if (isset($seenNumbers[$LeadPersonPhoneNumber])) {
            echo " -------Duplicate";
            $duplicateNumbers[] = $LeadsId;
        } else {
            $seenNumbers[$LeadPersonPhoneNumber] = true;
        }

        echo "<br>";
    }
} else {
    echo "No leads found.";
}
//delete duplicate leads

if (!empty($duplicateNumbers)) {
    $deleteQuery = "DELETE FROM leads WHERE LeadsId IN (" . implode(",", $duplicateNumbers) . ")";
    $deleteResult = _DB_COMMAND_($deleteQuery, true);
    if ($deleteResult) {
        echo "Deleted duplicate leads successfully.";
    } else {
        echo "Failed to delete duplicate leads.";
    }
}
