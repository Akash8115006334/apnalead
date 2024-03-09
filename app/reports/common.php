<?php


$AllLeads = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and CompanyID='" . CompanyId . "'");
$AllLeadsToday = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and Date(LeadPersonCreatedAt)='" . date("Y-m-d") . "'");
$AllLeadsYesterday = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and Date(LeadPersonCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

$AllFresh = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and LeadPersonStatus like '%FRESH LEAD%' and CompanyID='" . CompanyId . "'");
$AllFreshToday = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and LeadPersonStatus like '%FRESH LEAD%' and Date(LeadPersonCreatedAt)='" . date("Y-m-d") . "'");
$AllFreshYesterday = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and LeadPersonStatus like '%FRESH LEAD%' and Date(LeadPersonCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

$AllOutOfCoverage = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and LeadPersonStatus like '%Out Of Coverage Area%' and LeadPersonStatus like 'Out Of Coverage Area%' and CompanyID='" . CompanyId . "'");
$AllOutOfCoverageToday = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and LeadPersonStatus like '%Out Of Coverage Area%' and LeadPersonStatus like 'Out Of Coverage Area%' and Date(LeadPersonCreatedAt)='" . date("Y-m-d") . "'");
$AllOutOfCoverageYesterday = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and LeadPersonStatus like '%Out Of Coverage Area%' and LeadPersonStatus like 'Out Of Coverage Area%' and Date(LeadPersonCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

$AllSwitchOff = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and LeadPersonStatus like '%Switch Off%' and LeadPersonStatus like 'Switch Off%' and CompanyID='" . CompanyId . "'");
$AllSwitchOfToday = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and LeadPersonStatus like '%Switch Off%' and LeadPersonStatus like 'Switch Off%' and Date(LeadPersonCreatedAt)='" . date("Y-m-d") . "'");
$AllSwitchOfYesterday = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and LeadPersonStatus like '%Switch Off%' and LeadPersonStatus like 'Switch Off%' and Date(LeadPersonCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

$AllNumberDoesNot = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and LeadPersonStatus like '%Number Dose not Exist%' and LeadPersonStatus like 'Number Dose not Exist%' and CompanyID='" . CompanyId . "'");
$AllNumberDoesNotToday = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and LeadPersonStatus like '%Number Dose not Exist%' and LeadPersonStatus like 'Number Dose not Exist%' and Date(LeadPersonCreatedAt)='" . date("Y-m-d") . "'");
$AllNumberDoesNotYesterday = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and LeadPersonStatus like '%Number Dose not Exist%' and LeadPersonStatus like 'Number Dose not Exist%' and Date(LeadPersonCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

$AllOutOfValidity = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and LeadPersonStatus like '%Out of Validity%' and LeadPersonStatus like 'Out of Validity%' and CompanyID='" . CompanyId . "'");
$AllOutOfValidityToday = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and LeadPersonStatus like '%Out of Validity%' and LeadPersonStatus like 'Out of Validity%' and Date(LeadPersonCreatedAt)='" . date("Y-m-d") . "'");
$AllOutOfValidityYesterday = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and LeadPersonStatus like '%Out of Validity%' and LeadPersonStatus like 'Out of Validity%' and Date(LeadPersonCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

$AllNotPicked = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and LeadPersonStatus like '%Not Picked%'  and LeadPersonStatus like 'Not Picked%' and CompanyID='" . CompanyId . "'");
$AllNotPickedToday = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and LeadPersonStatus like '%Not Picked%'  and LeadPersonStatus like 'Not Picked%' and Date(LeadPersonCreatedAt)='" . date("Y-m-d") . "'");
$AllNotPickedYesterday = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$Req_UserId' and LeadPersonStatus like '%Not Picked%'  and LeadPersonStatus like 'Not Picked%' and Date(LeadPersonCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");
