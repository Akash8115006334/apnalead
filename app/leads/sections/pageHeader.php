<?php
$companyID = CompanyId;
if (isset($_GET['view'])) {
  $view = $_GET['view'];
  if (AuthAppUser("UserType") == "Admin" || AuthAppUser("UserType") == "Digital") {
    $LEAD_SQLS = "SELECT LeadsId , LeadSalutations,LeadPersonFullname,LeadPersonPhoneNumber,LeadPersonEmailId,LeadPersonCreatedAt,LeadPersonManagedBy,LeadPersonStatus,LeadPriorityLevel,LeadPersonNotes,LeadPersonSource,LeadPersonSubStatus,LeadPersonCreatedBy  FROM leads WHERE LeadPersonStatus LIKE '%$view%' and CompanyID='$companyID' ORDER BY LeadsId DESC ";
  } else {
    $UserId = AuthAppUser("UserId");
    $LEAD_SQLS = "SELECT LeadsId , LeadSalutations,LeadPersonFullname,LeadPersonPhoneNumber,LeadPersonEmailId,LeadPersonCreatedAt,LeadPersonManagedBy,LeadPersonStatus,LeadPriorityLevel,LeadPersonNotes,LeadPersonSource,LeadPersonSubStatus,LeadPersonCreatedBy  FROM leads where LeadPersonStatus LIKE '%$view%' and LeadPersonManagedBy='$UserId' and CompanyID='$companyID' ORDER BY LeadsId DESC ";
  }
} elseif (isset($_GET['search_true'])) {
  $LeadPersonFullName = $_GET['LeadPersonFullName'];
  $LeadPersonPhoneNumber = $_GET['LeadPersonPhoneNumber'];
  $LeadPersonStatus = $_GET['LeadPersonStatus'];
  $LeadPersonSource = $_GET['LeadPersonSource'];
  $LeadCreatedAt = $_GET['LeadCreatedAt'];
  $LeadManagedBy = $_GET['LeadManagedBy'];
  $LeadRequirment = $_GET['LeadRequirment'];
  $LeadPriority = $_GET['LeadPriorityLevel'];

  // manage by
  if ($LeadManagedBy == null) {
    $Managed = ""; // Empty string if $LeadManagedBy is null
  } else {
    $Managed = "AND leads.LeadPersonManagedBy = '$LeadManagedBy'";
  }

  // requirement
  if ($LeadRequirment == null) {
    $ProjectConditios = ""; // Empty string if $LeadRequirment is null
  } else {
    $ProjectConditios = "AND lead_requirements.LeadRequirementDetails = '$LeadRequirment'";
  }

  if (AuthAppUser("UserType") == "Admin" || AuthAppUser("UserType") == "Digital") {
    $LEAD_SQLS = "SELECT * FROM leads LEFT JOIN lead_requirements ON leads.LeadsId = lead_requirements.LeadMainId WHERE CompanyID = '$companyID' AND LeadPriorityLevel LIKE '%$LeadPriority%' AND LeadPersonFullname LIKE '%$LeadPersonFullName%' AND LeadPersonPhoneNumber LIKE '%$LeadPersonPhoneNumber%' AND LeadPersonStatus LIKE '%$LeadPersonStatus%' AND LeadPersonSource LIKE '%$LeadPersonSource%' $ProjectConditios $Managed AND LeadPersonCreatedAt LIKE '%$LeadCreatedAt%' GROUP BY leads.LeadsId ORDER BY leads.LeadsId DESC";
  } else {
    $LOGIN_UserId = AuthAppUser("UserId");
    $LEAD_SQLS = "SELECT * FROM leads LEFT JOIN lead_requirements ON leads.LeadsId = lead_requirements.LeadMainId WHERE $ProjectConditios CompanyID = '$companyID' AND LeadPriorityLevel LIKE '%$LeadPriority%' AND LeadPersonManagedBy = '$LOGIN_UserId' AND LeadPersonFullname LIKE '%$LeadPersonFullName%' AND LeadPersonPhoneNumber LIKE '%$LeadPersonPhoneNumber%' AND LeadPersonStatus LIKE '%$LeadPersonStatus%' AND LeadPersonSource LIKE '%$LeadPersonSource%' AND LeadPersonCreatedAt LIKE '%$LeadCreatedAt%' GROUP BY LeadsId ORDER BY LeadsId DESC";
  }
} elseif (isset($_GET['sub_status'])) {
  $sub_status = $_GET['sub_status'];
  if (isset($_GET['date'])) {
    $currentDate = date("Y-m-d");
    $Date = "lead_followups.LeadFollowUpDate='$currentDate' and";
  } else {
    $Date = "";
  }
  if (AuthAppUser("UserType") == "Admin" || AuthAppUser("UserType") == "Digital") {
    if ($sub_status == "FRESH LEAD") {
      $LEAD_SQLS = "SELECT LeadsId , LeadSalutations,LeadPersonFullname,LeadPersonPhoneNumber,LeadPersonEmailId,LeadPersonCreatedAt,LeadPersonManagedBy,LeadPersonStatus,LeadPriorityLevel,LeadPersonNotes,LeadPersonSource,LeadPersonSubStatus,LeadPersonCreatedBy  FROM leads WHERE LeadPersonStatus like '%$sub_status%' and CompanyId='$companyID' GROUP BY LeadsId ORDER BY LeadsId DESC ";
    } elseif ($sub_status == "Facebook") {
      $LEAD_SQLS = "SELECT LeadsId , LeadSalutations,LeadPersonFullname,LeadPersonPhoneNumber,LeadPersonEmailId,LeadPersonCreatedAt,LeadPersonManagedBy,LeadPersonStatus,LeadPriorityLevel,LeadPersonNotes,LeadPersonSource,LeadPersonSubStatus,LeadPersonCreatedBy  FROM leads WHERE LeadPersonSource like '%$sub_status%' and CompanyId='$companyID' GROUP BY LeadsId ORDER BY LeadsId DESC ";
    } elseif ($sub_status == "WEBSITE_API") {
      $LEAD_SQLS = "SELECT LeadsId , LeadSalutations,LeadPersonFullname,LeadPersonPhoneNumber,LeadPersonEmailId,LeadPersonCreatedAt,LeadPersonManagedBy,LeadPersonStatus,LeadPriorityLevel,LeadPersonNotes,LeadPersonSource,LeadPersonSubStatus,LeadPersonCreatedBy  FROM leads WHERE LeadPersonSource like '%$sub_status%' and CompanyId='$companyID' GROUP BY LeadsId ORDER BY LeadsId DESC ";
    } else {
      $LEAD_SQLS = "SELECT * FROM leads, lead_followups WHERE leads.LeadsId=lead_followups.LeadFollowMainId and $Date leads.LeadPersonStatus like '%$sub_status%' and leads.CompanyID='$companyID' GROUP BY leads.LeadsId ORDER BY LeadsId DESC ";
    }
  } else {
    $UserId = AuthAppUser("UserId");
    if ($sub_status == "FRESH LEAD") {
      $LEAD_SQLS = "SELECT LeadsId , LeadSalutations,LeadPersonFullname,LeadPersonPhoneNumber,LeadPersonEmailId,LeadPersonCreatedAt,LeadPersonManagedBy,LeadPersonStatus,LeadPriorityLevel,LeadPersonNotes,LeadPersonSource,LeadPersonSubStatus,LeadPersonCreatedBy  FROM leads WHERE LeadPersonStatus like '%$sub_status%' and CompanyId='$companyID' and LeadPersonManagedBy='$UserId' GROUP BY LeadsId ORDER BY LeadsId DESC ";
    } elseif ($sub_status == "Facebook") {
      $LEAD_SQLS = "SELECT LeadsId , LeadSalutations,LeadPersonFullname,LeadPersonPhoneNumber,LeadPersonEmailId,LeadPersonCreatedAt,LeadPersonManagedBy,LeadPersonStatus,LeadPriorityLevel,LeadPersonNotes,LeadPersonSource,LeadPersonSubStatus,LeadPersonCreatedBy  FROM leads WHERE LeadPersonSource like '%$sub_status%' and CompanyId='$companyID' and LeadPersonManagedBy='$UserId' GROUP BY LeadsId ORDER BY LeadsId DESC ";
    } elseif ($sub_status == "WEBSITE_API") {
      $LEAD_SQLS = "SELECT LeadsId , LeadSalutations,LeadPersonFullname,LeadPersonPhoneNumber,LeadPersonEmailId,LeadPersonCreatedAt,LeadPersonManagedBy,LeadPersonStatus,LeadPriorityLevel,LeadPersonNotes,LeadPersonSource,LeadPersonSubStatus,LeadPersonCreatedBy  FROM leads WHERE LeadPersonSource like '%$sub_status%' and CompanyId='$companyID' and LeadPersonManagedBy='$UserId' GROUP BY LeadsId ORDER BY LeadsId DESC ";
    } else {
      $LEAD_SQLS = "SELECT * FROM leads, lead_followups WHERE leads.LeadsId=lead_followups.LeadFollowMainId and $Date leads.LeadPersonStatus like '%$sub_status%' and leads.LeadPersonManagedBy='$UserId' and leads.CompanyID='$companyID' GROUP BY leads.LeadsId ORDER BY LeadsId DESC ";
    }
  }
} else {
  if (AuthAppUser("UserType") == "Admin" || AuthAppUser("UserType") == "Digital") {
    $LEAD_SQLS = "SELECT LeadsId , LeadSalutations,LeadPersonFullname,LeadPersonPhoneNumber,LeadPersonEmailId,LeadPersonCreatedAt,LeadPersonManagedBy,LeadPersonStatus,LeadPriorityLevel,LeadPersonNotes,LeadPersonSource,LeadPersonSubStatus,LeadPersonCreatedBy FROM leads where CompanyID='$companyID' ORDER BY LeadsId DESC ";
  } else {
    $UserId = AuthAppUser("UserId");
    $LEAD_SQLS = "SELECT LeadsId , LeadSalutations,LeadPersonFullname,LeadPersonPhoneNumber,LeadPersonEmailId,LeadPersonCreatedAt,LeadPersonManagedBy,LeadPersonStatus,LeadPriorityLevel,LeadPersonNotes,LeadPersonSource,LeadPersonSubStatus,LeadPersonCreatedBy  FROM leads where LeadPersonManagedBy='$UserId' and CompanyID='$companyID' ORDER BY LeadsId DESC ";
  }
}
$TotalItems = TOTAL($LEAD_SQLS);
