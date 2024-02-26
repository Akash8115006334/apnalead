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
  //manage by
  if ($LeadManagedBy == null) {
    $Managed = "and LeadPersonManagedBy like '%$LeadManagedBy%'  ";
  } else {
    $Managed = "and LeadPersonManagedBy='$LeadManagedBy'";
  }
  // requirement
  if ($LeadRequirment == null) {
    $ProjectConditios = "and  LeadRequirementDetails like '%$LeadRequirment%' and";
  } else {
    $ProjectConditios = " and LeadRequirementDetails='$LeadRequirment' and";
  }

  if (AuthAppUser("UserType") == "Admin" || AuthAppUser("UserType") == "Digital") {
    $LEAD_SQLS = "SELECT * FROM leads, lead_requirements where leads.LeadsId=lead_requirements.LeadMainId $ProjectConditios  CompanyID='$companyID' and LeadPriorityLevel like '%$LeadPriority%' and LeadPersonFullname like '%$LeadPersonFullName%'  and LeadPersonPhoneNumber like '%$LeadPersonPhoneNumber%' and LeadPersonStatus like '%$LeadPersonStatus%' and LeadPersonSource like '%$LeadPersonSource%' $Managed  and LeadPersonCreatedAt like '%$LeadCreatedAt%' GROUP BY LeadsId ORDER BY LeadsId DESC";
  } else {
    $LOGIN_UserId = AuthAppUser("UserId");
    $LEAD_SQLS = "SELECT * FROM leads, lead_requirements where leads.LeadsId=lead_requirements.LeadMainId $ProjectConditios  CompanyID='$companyID'and LeadPriorityLevel like '%$LeadPriority%' and LeadPersonManagedBy='$LOGIN_UserId' and LeadPersonFullname like '%$LeadPersonFullName%'  and LeadPersonPhoneNumber like '%$LeadPersonPhoneNumber%' and LeadPersonStatus like '%$LeadPersonStatus%' and LeadPersonSource like '%$LeadPersonSource%' and LeadPersonCreatedAt like '%$LeadCreatedAt%'  GROUP BY LeadsId ORDER BY LeadsId DESC";
  }
} elseif (isset($_GET['LeadRequirment'])) {
  $LeadRequirment = $_GET['LeadRequirment'];
  $LeadFollowStatus = $_GET['LeadFollowStatus'];
  $LeadPersonFullname = $_GET['LeadPersonFullname'];
  $LeadPersonPhoneNumber = $_GET['LeadPersonPhoneNumber'];
  $LeadPersonSource = $_GET['LeadPersonSource'];
  $LeadPersonManagedBy = $_GET['LeadPersonManagedBy'];
  $LeadFromDate = $_GET['from'];
  $LeadToDate = $_GET['to'];
  if ($LeadPersonManagedBy == null) {
    $Managed = "leads.LeadPersonManagedBy like '%$LeadPersonManagedBy%' and";
  } else {
    $Managed = "leads.LeadPersonManagedBy='$LeadPersonManagedBy' and";
  }
  if ($LeadRequirment == null) {
    $ProjectConditios = " lead_requirements.LeadRequirementDetails like '%$LeadRequirment%' and";
  } else {
    $ProjectConditios = " lead_requirements.LeadRequirementDetails='$LeadRequirment' and";
  }
  if ($LeadFromDate != null) {
    $dateCondition = " and leads.LeadPersonCreatedAt BETWEEN '$LeadFromDate 00:00:00 AM' AND '$LeadToDate 23:59:59 PM'";
  } else {
    $dateCondition = "";
  }
  if (AuthAppUser("UserType") == "Admin" || AuthAppUser("UserType") == "Digital") {
    $LEAD_SQLS = "SELECT * FROM leads, lead_requirements WHERE leads.LeadsId=lead_requirements.LeadMainId $dateCondition and $Managed leads.LeadPersonSource like '%$LeadPersonSource%'  and $ProjectConditios   leads.LeadPersonPhoneNumber like '%$LeadPersonPhoneNumber%' and leads.LeadPersonFullname like '%$LeadPersonFullname%'  and leads.LeadPersonStatus LIKE '%$LeadFollowStatus%' and leads.CompanyID='$companyID' GROUP BY leads.LeadsId ORDER BY leads.LeadsId DESC ";
  } else {
    $UserId = AuthAppUser("UserId");
    $LEAD_SQLS = "SELECT * FROM leads, lead_requirements where leads.LeadsId=lead_requirements.LeadMainId $dateCondition and $Managed leads.LeadPersonSource like '%$LeadPersonSource%'  and $ProjectConditios  leads.LeadPersonPhoneNumber like '%$LeadPersonPhoneNumber%' and leads.LeadPersonFullname like '%$LeadPersonFullname%'  and leads.LeadPersonStatus LIKE '%$LeadFollowStatus%' and leads.LeadPersonManagedBy='$UserId' and leads.CompanyID='$companyID' GROUP BY leads.LeadsId ORDER BY lesd.LeadsId DESC  ";
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
