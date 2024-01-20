<?php
DEFINE("CALL_STATUS", array("FRESH", "RINGING", "OUT OF REACH", "SWITCH OFF", "INVALID_PHONE_NUMBER", "BUSY", "NOT INTERESTED", "FEEDBACK", "FollowUp"));

//totoal calls
function TotalCalls($REQ_LeadsId)
{
 $Calls =   TOTAL("SELECT * FROM lead_followups where LeadFollowMainId='$REQ_LeadsId'");
 if ($Calls == 0) {
  $results = "0 Calls";
 } else {
  $results = $Calls . " Calls";
 }

 return $results;
}
