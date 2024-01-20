<?php
require __DIR__ . "/../../acm/SysFileAutoLoader.php";

if (isset($_POST['FetchAndSaveLeadFromGoogleSheetToApnaLead'])) {
  $CompanyAuthenticationKey = $_POST['CompanyAuthenticationKey'];
  $PersonFullName = $_POST['PersonFullName'];
  $PersonPhoneNumber = $_POST['PersonPhoneNumber'];
  $PersonEmailId = $_POST['PersonEmailId'];
  $PersonRequirement = $fb_project_Id = $_POST['PersonRequirement'];
  $PersonMessage = $_POST['PersonMessage'];

  //Fetch Company ID
  $CompanyMainId = $companyId = $CompanyID = FETCH("SELECT CompanyMainId FROM encripted_companies where Enc_CompanyMainId='$CompanyAuthenticationKey'", "CompanyMainId");
  $CompanyId = $companyId = $CompanyMainId;

  $CheckLeadsEntry = CHECK("SELECT * FROM leads where LeadPersonPhoneNumber='$PersonPhoneNumber' and CompanyID='$CompanyMainId'");
  if ($CheckLeadsEntry == null) {

    //Insert Into Database/Leads
    $FaceBookLeads = [
      "LeadsName" => $PersonFullName,
      "LeadsEmail" => $PersonEmailId,
      "LeadsPhone" => $PersonPhoneNumber,
      "LeadsCity" => "Null",
      "LeadsSource" => "WEBSITE_API",
      "UploadedOn" => CURRENT_DATE_TIME,
      "LeadStatus" => "UPLOADED",
      "LeadsUploadBy" => 0,
      "LeadsUploadedfor" => "",
      "LeadsAddress" => "Null",
      "LeadsProfession" => "Null",
      "LeadProjectsRef" => $fb_project_Id,
      "LeadsWhatsappPhoneNumber" => "Null",
      "CompanyID" => $companyId,
    ];

    //Check in leads uploads table
    $CheckLeadUploadStatus = CHECK("SELECT * FROM lead_uploads where LeadsPhone='$PersonPhoneNumber' and CompanyID='$CompanyID'");
    if ($CheckLeadUploadStatus == null) {
      $Save = INSERT("lead_uploads", $FaceBookLeads);
      $leadUploadId = FETCH("SELECT leadsUploadId FROM lead_uploads Where CompanyID='$companyId' ORDER BY leadsUploadId DESC", "leadsUploadId");
      if (!empty($leadUploadId)) {

        //Distribute Leads
        $FetchAllUploadedLeads = _DB_COMMAND_("SELECT * FROM lead_uploads WHERE LeadStatus='UPLOADED' and LeadsSource='WEBSITE_API'", true);

        if ($FetchAllUploadedLeads != null) {
          foreach ($FetchAllUploadedLeads as $UploadedLead) {
            $companyId = $UploadedLead->CompanyID;
            $UserId = FETCH("SELECT * FROM user_project_type, company_users WHERE user_project_type.User_main_Id=company_users.company_alloted_user_id and company_user_role NOT IN ('Admin', 'Digital') AND User_project_main_Id='" . $UploadedLead->LeadProjectsRef . "' AND CompanyId='$companyId' ORDER BY rand() LIMIT 1", "User_main_Id");
            if ($UserId != null) {
              $LeadPersonManagedBy = $UserId;
            } else {
              $LeadPersonManagedBy = FETCH("SELECT * FROM company_users WHERE company_user_role NOT IN ('Admin', 'Digital') AND company_user_status='1' AND company_main_id='$companyId' ORDER BY rand() LIMIT 1", "company_alloted_user_id");
            }
            $leadsUploadId = $UploadedLead->leadsUploadId;
            $data = array(
              "LeadSalutations" => "",
              "LeadPersonFullname" => $UploadedLead->LeadsName,
              "LeadPersonPhoneNumber" => $UploadedLead->LeadsPhone,
              "LeadPersonEmailId" => $UploadedLead->LeadsEmail,
              "LeadPersonAddress" => $UploadedLead->LeadsAddress,
              "LeadPersonCreatedBy" => "",
              "LeadPersonManagedBy" => $LeadPersonManagedBy,
              "LeadPersonStatus" => "FRESH LEAD",
              "LeadPriorityLevel" => "HIGH",
              "LeadPersonNotes" => SECURE($PersonMessage, "e"),
              "LeadPersonSubStatus" => "",
              "LeadForCountry" => "",
              "LeadLastQualification" => "",
              "LeadUniversityName" => "",
              "LeadPersonSource" => $UploadedLead->LeadsSource,
              "LeadPersonCreatedAt" => CURRENT_DATE_TIME,
              "LeadPersonLastUpdatedAt" => CURRENT_DATE_TIME,
              "CompanyID" => $companyId,
            );
            $save = INSERT("leads", $data);
            $LeadMainId = FETCH("SELECT * FROM leads where LeadPersonPhoneNumber='" . $UploadedLead->LeadsPhone . "'", "LeadsId");

            $LeadRequirements = array(
              "LeadMainId" => $LeadMainId,
              "LeadRequirementDetails" => $UploadedLead->LeadProjectsRef,
              "LeadRequirementStatus" => "1",
              "LeadRequirementCreatedAt" => CURRENT_DATE_TIME,
              "LeadRequirementNotes" => "",
            );
            $Save = INSERT("lead_requirements", $LeadRequirements);
            $Update = UPDATE("UPDATE lead_uploads SET LeadStatus='TRANSFERRED' WHERE leadsUploadId='$leadsUploadId'");

            if ($Update == false) {
              echo "<b>Error:</b>Something went wrong!<br>";
            } else {
              echo "Ok<br>";
            }
          }
        }
      }
    } else {
      echo "";
    }
  } else {
    echo "";
  }
}
