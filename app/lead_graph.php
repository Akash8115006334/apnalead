<?php
// Assuming _DB_COMMAND_ function fetches data from the database
$leads = _DB_COMMAND_("SELECT DATE(LeadFollowUpCreatedAt) AS date, COUNT(*) AS records_count FROM lead_followups, leads  WHERE lead_followups.LeadfollowmainId=leads.LeadsId and leads.CompanyID='" . CompanyId . "' and MONTH(LeadFollowUpCreatedAt) = MONTH(CURDATE()) AND YEAR(LeadFollowUpCreatedAt) = YEAR(CURDATE()) GROUP BY date", true);

$dataPoints = array();

if ($leads != null) {
    foreach ($leads as $row) {
        $dataPoints[] = array("y" => $row->records_count, "label" => DATE_FORMATES("d M", $row->date));
    }
} else {
    NoData("No Call History Found!");
}
