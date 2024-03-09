<?php
if (isset($_GET['delete_leads'])) {
  DeleteReqHandler(
    "delete_leads",
    [
      "leads" => "LeadsId='" . SECURE($_GET['control_id'], "d") . "'",
      "lead_followups" => "LeadFollowMainId='" . SECURE($_GET['control_id'], "d") . "'",
      "lead_requirements" => "LeadMainId='" . SECURE($_GET['control_id'], "d") . "'",
      "lead_followup_durations" => "LeadCallFollowUpMainId='" . SECURE($_GET['control_id'], "d") . "'"
    ],
    [
      "true" => "lead delete successfully",
      "false" => "Unable to delete lead at the moment!"
    ],
    DOMAIN . "/app/leads"
  );
} elseif (isset($_POST['CreateLeads'])) {
  $UserID = AuthAppUser("UserId");
  $companyId = CompanyId;
  $Phonenumber = VALID_PHONE_NUMBER($_POST['LeadPersonPhoneNumber']);
  $error_url = APP_URL . "/leads/add.php";
  $checkNumber = CHECK("SELECT LeadPersonPhoneNumber FROM leads Where LeadPersonPhoneNumber='$Phonenumber' and CompanyID='" . CompanyId . "'");
  if ($checkNumber) {
    LOCATION("warning", "Mobile Number Already Taken!", "$error_url");
  } else {
    $Tablerows = [
      "LeadPersonFullname" => $_POST['LeadPersonFullname'],
      "LeadSalutations" => $_POST['LeadSalutations'],
      "LeadPersonPhoneNumber" => VALID_PHONE_NUMBER($_POST['LeadPersonPhoneNumber']),
      "LeadPersonEmailId" => $_POST['LeadPersonEmailId'],
      "LeadPersonAddress" => $_POST['LeadPersonAddress'],
      "LeadPersonCreatedBy" => $UserID,
      "LeadPersonCreatedAt" => CURRENT_DATE_TIME,
      "LeadPersonManagedBy" => $_POST['LeadPersonManagedBy'],
      "LeadPersonStatus" => "FRESH LEAD",
      "LeadPriorityLevel" => $_POST['LeadPriorityLevel'],
      "LeadPersonSource" => $_POST['LeadPersonSource'],
      "LeadPersonLastUpdatedAt" =>  CURRENT_DATE_TIME,
      "LeadPersonNotes" => SECURE($_POST['LeadPersonNotes'], "e"),
      "CompanyID" =>  $companyId,
      "Distribute_Type" => "Manual",
    ];
    $SAVE = INSERT("leads", $Tablerows);
    //get Lead id
    $LeadsId = FETCH("SELECT * FROM leads  where LeadPersonManagedBy='" . $_POST['LeadPersonManagedBy'] . "' and CompanyID='$companyId' ORDER BY LeadsId DESC LIMIT 1", "LeadsId");
    $LeadFollowMainId = $LeadsId;
    //save feadback too
    // ========================================================================
    if (isset($_POST['LeadFollowStatus'])) {
      $LeadFollowStatus = $_POST['LeadFollowStatus'];
      $LeadPriorityLevel = $_POST['LeadPriorityLevel'];
      if (isset($_POST['mycheckbtn'])) {
        $LeadFollowUpRemindNotes = $_POST['LeadFollowUpDescriptions'];
        $LeadFollowUpRemindStatus = "ACTIVE";
        if ($LeadFollowStatus == "MEETING PLANNED" || $LeadFollowStatus == "Meeting Plan") {
          $LeadFollowCurrentStatus = "MEETING PLANNED";
          $LeadPersonSubStatus = "MEETING PLANNED";
        } elseif ($LeadFollowStatus == "Call Back" || $LeadFollowStatus == "CALL BACK") {
          $LeadFollowCurrentStatus = "CALL BACK";
          $LeadPersonSubStatus = "CALL BACK";
        } else {
          $LeadFollowCurrentStatus = "FOLLOW-UP";
          $LeadPersonSubStatus = "FOLLOW-UP";
        }
        if (isset($_POST['predefinetime'])) {
          $currentDate = date("Y-m-d"); // Use date() instead of Date()

          if ($_POST['predefinetime'] == '15min') {
            $LeadFollowUpDate = $currentDate; // Use $currentDate instead of date("Y-m-d")
            $LeadFollowUpTime = date("h:i A", strtotime("+15 minutes")); // Use "minutes" instead of "min"
          } else if ($_POST['predefinetime'] == 'Tomorrow') {
            $LeadFollowUpDate = date("Y-m-d", strtotime("+1 day", strtotime($currentDate))); // Correct order of arguments in strtotime
            $LeadFollowUpTime = date("h:i A"); // Use "tomorrow" instead of CURRENT_TIME


          } else if ($_POST['predefinetime'] == 'NextWeek') {
            $LeadFollowUpDate = date("Y-m-d", strtotime("+7 days", strtotime($currentDate))); // Correct order of arguments in strtotime
            $LeadFollowUpTime = date("h:i A"); // Use "next week" instead of CURRENT_TIME
          }
        } else if (isset($_POST['LeadFollowUpDate']) || isset($_POST['LeadFollowUpTime'])) {

          // die($_POST['LeadFollowUpDate']);
          $LeadFollowUpDate = $_POST['LeadFollowUpDate'];
          $LeadFollowUpTime = date("h:i A", strtotime($_POST['LeadFollowUpTime']));
        } else {
          $LeadFollowUpDate = "";
          $LeadFollowUpTime = "";
        }
      } else {
        $LeadFollowUpDate = "";
        $LeadFollowUpTime = "";
        $LeadFollowUpRemindNotes = $_POST['LeadFollowUpDescriptions'];
        $LeadFollowUpRemindStatus = "NONE";
        $LeadFollowCurrentStatus = "";
        $LeadPersonSubStatus = "";
      }

      $data = array(
        "LeadFollowMainId" => $LeadFollowMainId,
        "LeadFollowStatus" => $LeadFollowStatus,
        "LeadFollowCurrentStatus" => $LeadFollowCurrentStatus,
        "LeadFollowUpDate" => $LeadFollowUpDate,
        "LeadFollowUpTime" => $LeadFollowUpTime,
        "LeadFollowUpDescriptions" => $LeadFollowUpRemindNotes,
        "LeadFollowUpHandleBy" => AuthAppUser("UserId"),
        "LeadFollowUpCreatedAt" => CURRENT_DATE_TIME,
        "LeadFollowUpCallType" => '',
        "LeadFollowUpRemindStatus" => $LeadFollowUpRemindStatus,
        "LeadFollowUpRemindNotes" => $_POST['LeadFollowUpDescriptions'],
        "LeadFollowUpUpdatedAt" => CURRENT_DATE_TIME
      );

      $Update = UPDATE("UPDATE lead_followups SET LeadFollowUpRemindStatus='INACTIVE' where LeadFollowMainId='$LeadFollowMainId'");
      $Save = INSERT("lead_followups", $data);
      $Update = UPDATE("UPDATE leads SET LeadPersonStatus='$LeadFollowStatus', LeadPersonSubStatus='$LeadPersonSubStatus', LeadPriorityLevel='$LeadPriorityLevel' where LeadsId='$LeadFollowMainId'");
    }
    // ========================================================================

    //save lead requirement
    $LeadRequirementCreatedAt = CURRENT_DATE_TIME;
    $LeadRequirementStatus = "1";
    $LeadMainId = FETCH("SELECT * FROM leads ORDER BY LeadsId DESC LIMIT 1", "LeadsId");
    if ($_POST['LeadRequirementDetails'] != null) {
      foreach ($_POST['LeadRequirementDetails'] as $LeadReq) {
        $LeadRequirementDetails = $LeadReq;
        $LeadRequirement = array(
          "LeadMainId" => $LeadMainId,
          "LeadRequirementDetails" => $LeadRequirementDetails,
          "LeadRequirementCreatedAt" => $LeadRequirementCreatedAt,
          "LeadRequirementStatus" =>  $LeadRequirementStatus,
        );
        $save = INSERT("lead_requirements", $LeadRequirement);
      }
    } else {
      $LeadRequirement = array(
        "LeadMainId" => $LeadMainId,
        "LeadRequirementDetails" => null,
        "LeadRequirementCreatedAt" => $LeadRequirementCreatedAt,
        "LeadRequirementStatus" =>  $LeadRequirementStatus,
      );
      $save = INSERT("lead_requirements", $LeadRequirement);
    }
    RESPONSE($save, "Leads Saved Successfully", "Leads Not Saved Successfully");
  }
  //update lead requirements
} elseif (isset($_POST['UpdateLeadRequirements'])) {
  $LeadMainId = SECURE($_POST['UpdateLeadRequirements'], "d");
  $LeadRequirementCreatedAt = CURRENT_DATE_TIME;
  $LeadRequirementStatus = "1";
  foreach ($_POST['LeadRequirementDetails'] as $key => $LeadReq) {
    $LeadRequirementDetails = $LeadReq;
    $LeadRequirement = array(
      "LeadMainId" => $LeadMainId,
      "LeadRequirementDetails" => $LeadRequirementDetails,
      "LeadRequirementCreatedAt" => $LeadRequirementCreatedAt,
      "LeadRequirementStatus" =>  $LeadRequirementStatus,
    );
    $save = INSERT("lead_requirements", $LeadRequirement);
  }
  RESPONSE($save, "Lead Requirements Updated Successfully", "Lead Requirements Not Updated Successfully");

  //delete lead requirements
} elseif (isset($_GET['delete_lead_requirements'])) {
  $access_url = SECURE($_GET['access_url'], "d");
  $delete_lead_requirements = SECURE($_GET['delete_lead_requirements'], "d");

  if ($delete_lead_requirements == true) {
    $control_id = SECURE($_GET['control_id'], "d");
    $Delete = DELETE_FROM("lead_requirements",  "LeadRequirementID='$control_id'");
    RESPONSE($Delete, "Lead Requirement Deleted Successfully", "Lead Requirement Not Deleted Successfully");
  } else {
    RESPONSE(false, "Lead Requirement Not Deleted Successfully", "Lead Requirement Not Deleted Successfully");
  }

  //upload leads
} elseif (isset($_POST['UploadLeads'])) {
  $UserID = AuthAppUser("UserId");
  $companyId = CompanyId;
  $LeadUploadedFor = AuthAppUser("UserId");

  // Check if the file is a CSV
  $FileName = explode(".", $_FILES['UploadedFile']['name']);
  if ($FileName[1] == "csv") {
    $handle = fopen($_FILES['UploadedFile']['tmp_name'], "r");
    $flag = true; // To skip the header row
    $successCount = 0; // To count successfully uploaded leads

    while ($data = fgetcsv($handle)) {
      if ($flag) {
        $flag = false;
        continue; // Skip the header row
      }

      // Extract data from CSV columns
      $LeadsName = $data[0];
      $LeadsEmail = $data[2];
      $LeadsPhone = $data[1];
      $LeadsAddress = $data[3];
      $LeadsCity = $data[4];
      $LeadsProfession = $data[5];
      $LeadsSource = $data[6];

      // Validate and format phone number
      $phone = VALID_PHONE_NUMBER($LeadsPhone);

      // Check if the phone number exists in lead_upload table
      if (!entryExists($phone, $companyId)) {
        // Check if the phone number exists in leads table
        if (!CheckInLeads($phone, $companyId)) {
          $data = array(
            "LeadsName" => $LeadsName,
            "LeadsUploadBy" => AuthAppUser("UserId"),
            "LeadsUploadedfor" => $LeadUploadedFor,
            "LeadsEmail" => $LeadsEmail,
            "LeadsPhone" => $phone,
            "LeadsAddress" => $LeadsAddress,
            "LeadsCity" => $LeadsCity,
            "LeadsProfession" => $LeadsProfession,
            "LeadsSource" => $LeadsSource,
            "UploadedOn" => CURRENT_DATE_TIME,
            "LeadStatus" => "UPLOADED",
            "LeadProjectsRef" => $_POST['LeadProjectsRef'],
            "CompanyID" => $companyId,
            "Upload_Source" => "Self",
          );

          // Insert into lead_uploads table
          $Save = INSERT("lead_uploads", $data);

          if ($Save) {
            $successCount++;
          }
        }
      }
    }

    fclose($handle);

    // Provide response based on successful uploads
    if ($successCount > 0) {
      RESPONSE(true, "$successCount Leads Uploaded successfully!", "Unable to upload leads at the moment!");
    } else {
      RESPONSE(false, "No new leads to upload!", "Unable to upload leads at the moment!");
    }
  } else {
    RESPONSE(false, "Invalid file format. Please upload a CSV file.", "Unable to upload leads at the moment!");
  }



  //leadss transfer
} elseif (isset($_POST['TransferLeads'])) {
  // get the adminid and digital id 
  $UserID = AuthAppUser("UserId");
  $companyId = FETCH("SELECT * FROM company_users where company_alloted_user_id='$UserID'", "company_main_id");
  $LeadPersonManagedBy =  $_POST['LeadPersonManagedBy'];
  $LeadPersonStatus = "FRESH LEAD";
  $LeadPriorityLevel = $_POST['LeadPriorityLevel'];

  if ($_POST['bulkselect'] != "null") {
    if ($_POST['bulkselect'] == "custom") {
      $totalleadcounts = $_POST['custom_value'];
    } else {
      $totalleadcounts = $_POST['bulkselect'];
    }
    $orderby = $_POST['sortedby'];
    //die("SELECT * FROM lead_uploads where LeadStatus='UPLOADED' and CompanyID='$companyId' ORDER BY leadsUploadId $orderby limit 0, $totalleadcounts");
    $FETCH = _DB_COMMAND_("SELECT * FROM lead_uploads where LeadStatus='UPLOADED' and CompanyID='$companyId' ORDER BY leadsUploadId $orderby limit 0, $totalleadcounts", true);
    if ($FETCH != null) {
      foreach ($FETCH as $leads) {
        $leadsUploadId = $leads->leadsUploadId;
        $data = array(
          "LeadPersonFullname" => $leads->LeadsName,
          "LeadPersonPhoneNumber" => VALID_PHONE_NUMBER($leads->LeadsPhone),
          "LeadPersonEmailId" => $leads->LeadsEmail,
          "LeadPersonAddress" => $leads->LeadsAddress,
          "LeadPersonCreatedBy" => AuthAppUser("UserId"),
          "LeadPersonManagedBy" => $LeadPersonManagedBy,
          "LeadPersonStatus" => $LeadPersonStatus,
          "LeadPriorityLevel" => $LeadPriorityLevel,
          "LeadPersonSource" => $leads->LeadsSource,
          "LeadPersonCreatedAt" => CURRENT_DATE_TIME,
          "LeadPersonLastUpdatedAt" => CURRENT_DATE_TIME,
          "CompanyID" => $companyId,
          "Distribute_Type" => "Manual",
        );
        $save = INSERT("leads", $data);
        $LeadMainId = FETCH("SELECT * FROM leads ORDER BY LeadsId DESC limit 1", "LeadsId");

        $LeadRequirements = array(
          "LeadMainId" => $LeadMainId,
          "LeadRequirementDetails" => FETCH("SELECT * FROM projects where ProjectsId='" . $leads->LeadProjectsRef . "'", "ProjectsId"),
          "LeadRequirementStatus" => "1",
          "LeadRequirementCreatedAt" => CURRENT_DATE_TIME,
          "LeadRequirementNotes" => "",
        );
        $Save = INSERT("lead_requirements", $LeadRequirements);
        $Update = UPDATE("UPDATE lead_uploads SET LeadStatus='TRANSFERRED' WHERE leadsUploadId='$leadsUploadId'");
      }
    }
  } else {
    foreach ($_POST['Leads'] as $values) {
      $FETCH = _DB_COMMAND_("SELECT * FROM lead_uploads where leadsUploadId='$values'", true);
      if ($FETCH != null) {
        foreach ($FETCH as $leads) {
          $data = array(
            "LeadPersonFullname" => $leads->LeadsName,
            "LeadPersonPhoneNumber" => VALID_PHONE_NUMBER($leads->LeadsPhone),
            "LeadPersonEmailId" => $leads->LeadsEmail,
            "LeadPersonAddress" => $leads->LeadsAddress,
            "LeadPersonCreatedBy" => AuthAppUser("UserId"),
            "LeadPersonManagedBy" => $LeadPersonManagedBy,
            "LeadPersonStatus" => $LeadPersonStatus,
            "LeadPriorityLevel" => $LeadPriorityLevel,
            "LeadPersonSource" => $leads->LeadsSource,
            "LeadPersonCreatedAt" => CURRENT_DATE_TIME,
            "LeadPersonLastUpdatedAt" => CURRENT_DATE_TIME,
            "CompanyID" => $companyId,
            "Distribute_Type" => "Manual",
          );
          $save = INSERT("leads", $data);
          $LeadMainId = FETCH("SELECT * FROM leads ORDER BY LeadsId DESC limit 1", "LeadsId");

          $LeadRequirements = array(
            "LeadMainId" => $LeadMainId,
            "LeadRequirementDetails" => FETCH("SELECT * FROM projects where ProjectsId='" . $leads->LeadProjectsRef . "'", "ProjectsId"),
            "LeadRequirementStatus" => "1",
            "LeadRequirementCreatedAt" => CURRENT_DATE_TIME,
            "LeadRequirementNotes" => "",
          );
          $Save = INSERT("lead_requirements", $LeadRequirements);
          $Update = UPDATE("UPDATE lead_uploads SET LeadStatus='TRANSFERRED' WHERE leadsUploadId='$values'");
        }
      }
    }
  }
  RESPONSE($Save, "Leads Transferred Successfully", "Leads Not Transferred successfully!");
  //update leads   //update leads 
} elseif (isset($_POST['UpdateLeads'])) {
  $LeadsId = SECURE($_POST['UpdateLeads'], "d");

  if (AuthAppUser("UserType") == "Admin") {
    $LeadPersonManagedBy = $_POST['LeadPersonManagedBy'];
  } else {
    $LeadPersonManagedBy = SECURE($_POST['ManagedBy'], "d");
  }
  $data = array(
    "LeadPersonFullname" => $_POST['LeadPersonFullname'],
    "LeadSalutations" => $_POST['LeadSalutations'],
    "LeadPersonPhoneNumber" => VALID_PHONE_NUMBER($_POST['LeadPersonPhoneNumber']),
    "LeadPersonEmailId" => $_POST['LeadPersonEmailId'],
    "LeadPersonAddress" => $_POST['LeadPersonAddress'],
    "LeadPersonLastUpdatedAt" => CURRENT_DATE_TIME,
    "LeadPersonManagedBy" => $LeadPersonManagedBy,
    "LeadPersonNotes" => SECURE($_POST['LeadPersonNotes'], "e"),
    "LeadPersonSource" => $_POST['LeadPersonSource'],
  );
  $Update = UPDATE_TABLE("leads", $data, "LeadsId='$LeadsId'");
  RESPONSE($Update, "Leads Details are updated successfully!", "Unable to update leads details at the moment!");
  //add leads status
} elseif (isset($_POST['AddLeadStatus'])) {
  if (isset($_POST['currentURL'])) {
    $Url = $_POST['currentURL'];
  } else {
    $Url = APP_URL . "/leads/index.php";
  }
  $LeadFollowMainId = SECURE($_POST['LeadFollowMainId'], "d");
  $LeadFollowStatus = $_POST['LeadFollowStatus'];
  if ($_POST['LeadPriorityLevel1'] !== null) {
    $LeadPriorityLevel = $_POST['LeadPriorityLevel1'];
  } else {
    $LeadPriorityLevel = $_POST['LeadPriorityLevel'];
  }
  if (isset($_POST['mycheckbtn'])) {
    $LeadFollowUpRemindNotes = $_POST['LeadFollowUpDescriptions'];
    $LeadFollowUpRemindStatus = "ACTIVE";
    if ($LeadFollowStatus == "MEETING PLANNED" || $LeadFollowStatus == "Meeting Plan") {
      $LeadFollowCurrentStatus = "MEETING PLANNED";
      $LeadPersonSubStatus = "MEETING PLANNED";
    } elseif ($LeadFollowStatus == "Call Back" || $LeadFollowStatus == "CALL BACK") {
      $LeadFollowCurrentStatus = "CALL BACK";
      $LeadPersonSubStatus = "CALL BACK";
    } else {
      $LeadFollowCurrentStatus = "FOLLOW-UP";
      $LeadPersonSubStatus = "FOLLOW-UP";
    }
    if (isset($_POST['predefinetime'])) {
      $currentDate = date("Y-m-d"); // Use date() instead of Date()

      if ($_POST['predefinetime'] == '15min') {
        $LeadFollowUpDate = $currentDate; // Use $currentDate instead of date("Y-m-d")
        $LeadFollowUpTime = date("h:i A", strtotime("+15 minutes")); // Use "minutes" instead of "min"
      } else if ($_POST['predefinetime'] == 'Tomorrow') {
        $LeadFollowUpDate = date("Y-m-d", strtotime("+1 day", strtotime($currentDate))); // Correct order of arguments in strtotime
        $LeadFollowUpTime = date("h:i A"); // Use "tomorrow" instead of CURRENT_TIME
      } else if ($_POST['predefinetime'] == 'NextWeek') {
        $LeadFollowUpDate = date("Y-m-d", strtotime("+7 days", strtotime($currentDate))); // Correct order of arguments in strtotime
        $LeadFollowUpTime = date("h:i A"); // Use "next week" instead of CURRENT_TIME
      }
      // die($_POST['predefinetime']);
    } else if (isset($_POST['LeadFollowUpDate']) || isset($_POST['LeadFollowUpTime'])) {

      // die($_POST['LeadFollowUpDate']);
      $LeadFollowUpDate = $_POST['LeadFollowUpDate'];
      $LeadFollowUpTime = date("h:i A", strtotime($_POST['LeadFollowUpTime']));
    } else {
      $LeadFollowUpDate = "";
      $LeadFollowUpTime = "";
    }
  } else {
    $LeadFollowUpDate = "";
    $LeadFollowUpTime = "";
    $LeadFollowUpRemindNotes = $_POST['LeadFollowUpDescriptions'];
    $LeadFollowUpRemindStatus = "NONE";
    $LeadFollowCurrentStatus = "";
    $LeadPersonSubStatus = "";
  }
  $data = array(
    "LeadFollowMainId" => $LeadFollowMainId,
    "LeadFollowStatus" => $LeadFollowStatus,
    "LeadFollowCurrentStatus" => $LeadFollowCurrentStatus,
    "LeadFollowUpDate" => $LeadFollowUpDate,
    "LeadFollowUpTime" => $LeadFollowUpTime,
    "LeadFollowUpDescriptions" => $LeadFollowUpRemindNotes,
    "LeadFollowUpHandleBy" => AuthAppUser("UserId"),
    "LeadFollowUpCreatedAt" => CURRENT_DATE_TIME,
    "LeadFollowUpCallType" => '',
    "LeadFollowUpRemindStatus" => $LeadFollowUpRemindStatus,
    "LeadFollowUpRemindNotes" => $_POST['LeadFollowUpDescriptions'],
    "LeadFollowUpUpdatedAt" => CURRENT_DATE_TIME
  );
  $Update = UPDATE("UPDATE lead_followups SET LeadFollowUpRemindStatus='INACTIVE' where LeadFollowMainId='$LeadFollowMainId'");
  $Save = INSERT("lead_followups", $data);
  $Update = UPDATE("UPDATE leads SET LeadPersonStatus='$LeadFollowStatus', LeadPersonSubStatus='$LeadPersonSubStatus', LeadPersonLastUpdatedAt='" . date("Y-m-d h:i:s A") . "', LeadPriorityLevel='$LeadPriorityLevel' where LeadsId='$LeadFollowMainId'");
  RESPONSE($Save, "Leads Status & Follow Up Details are saved successfully!", "Unable to save lead status & follow up details at the moment!", $Url);

  //update reminder
} elseif (isset($_POST['UpdateFollowUp'])) {
  $LeadFollowUpId = SECURE($_POST['LeadFollowUpId'], "d");

  $data = array(
    "LeadFollowUpDescriptions" => $_POST['LeadFollowUpDescriptions'],
    "LeadFollowUpRemindStatus" => "INACTIVE",
    "LeadFollowUpUpdatedAt" => CURRENT_DATE_TIME
  );

  $Update = UPDATE_TABLE("lead_followups", $data, "LeadFollowUpId='$LeadFollowUpId'");
  RESPONSE($Update, "Lead Follow Up Details are updated successfully!", "Unable to update follow up details at the moment!");

  //move leads from to 
} elseif (isset($_POST['MoveLeads'])) {
  $From = SECURE($_POST['From'], "d");
  $LeadPersonManagedBy = $_POST['LeadPersonManagedBy'];
  $LeadPersonStatus = SECURE($_POST['LeadPersonStatus'], "d");
  if ($_POST['NumberOfLeads'] != 0) {
    $NumberOfLeads = $_POST['NumberOfLeads'];
    $OrderOfSelection = $_POST['OrderOfSelection'];

    $AllLeads = _DB_COMMAND_("SELECT * FROM leads where LeadPersonStatus like '%$LeadPersonStatus%' and LeadPersonManagedBy='$From' ORDER by LeadsId $OrderOfSelection limit 0, $NumberOfLeads", true);
    if ($AllLeads != null) {
      foreach ($AllLeads as $Lead) {
        $data = array(
          "LeadPersonLastUpdatedAt" => CURRENT_DATE_TIME,
          "LeadPersonCreatedBy" => AuthAppUser("UserId"),
          "LeadPersonManagedBy" => $LeadPersonManagedBy,
        );
        $Update = UPDATE_TABLE("leads", $data, "LeadsId='" . $Lead->LeadsId . "'");
      }
    }
  } else {
    foreach ($_POST['selected_lead_for_transfer'] as $LeadsId) {
      $data = array(
        "LeadPersonLastUpdatedAt" => CURRENT_DATE_TIME,
        "LeadPersonCreatedBy" => AuthAppUser("UserId"),
        "LeadPersonManagedBy" => $LeadPersonManagedBy,
      );
      $Update = UPDATE_TABLE("leads", $data, "LeadsId='$LeadsId'");
    }
  }
  RESPONSE($Update, "Leads Successfully Transeffered!", "Unable to Transfer Leads!");
}
