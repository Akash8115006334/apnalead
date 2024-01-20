<?php
require __DIR__ . "/../../acm/SysFileAutoLoader.php";

$GetFacebookPages = _DB_COMMAND_("SELECT * FROM config_facebook_accounts", true);
if ($GetFacebookPages != null) {
  foreach ($GetFacebookPages as $Facebook) {
    $Id = $Facebook->id;
    $fb_page_name = $Facebook->fb_page_name;
    $fb_adaccounts_id = $Facebook->fb_adaccounts_id;
    $fb_campaigns_id = $Facebook->fb_campaigns_id;
    $fb_campaigns_name = $Facebook->fb_campaigns_name;
    $fb_adsets_id = $Facebook->fb_adsets_id;
    $fb_adsets_name = $Facebook->fb_adsets_name;
    $fb_ads_id = $Facebook->fb_ads_id;
    $fb_ads_name = $Facebook->fb_ads_name;
    $fb_access_token = $Facebook->fb_access_token;
    $fb_project_Id = $Facebook->fb_project_Id;
    $companyId = $Facebook->CompanyID;
    $ch = curl_init();
    $url = "https://graph.facebook.com/v17.0/me?fields=id%2Cname%2Cadaccounts%7Baccount_id%2Cname%2Caccount_status%2Ccampaigns%7Bid%2Cname%2Cstatus%2Ccreated_time%2Cstart_time%2Cadsets%7Bid%2Cname%2Ccreated_time%2Cstart_time%2Cstatus%2Cads%7Bid%2Cname%2Ccreated_time%2Cleads%7D%7D%7D%7D&access_token=$fb_access_token";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $resp = curl_exec($ch);
    if ($e = curl_error($ch)) {
      echo $e;
    } else {
      $decoded = json_decode($resp);
      $adsAccounts = $decoded->adaccounts->data;
      foreach ($adsAccounts as $adAccount) {
        if ($adAccount->account_id == $fb_adaccounts_id) {
          $adsCampaigns = $adAccount->campaigns->data;
          foreach ($adsCampaigns as $adsCampaign) {
            if ($adsCampaign->id == $fb_campaigns_id) {
              $adsSets = $adsCampaign->adsets->data;
              foreach ($adsSets as $adSet) {
                if ($adSet->id == $fb_adsets_id) {
                  $ads = $adSet->ads->data;
                  foreach ($ads as $ad) {
                    if ($ad->id == $fb_ads_id) {
                      $leads = $ad->leads->data;
                      foreach ($leads as $lead) {
                        foreach ($lead->field_data as $leadsFieldData) {
                          $firstNameList = ['first_name', 'fname', 'FirstName', 'f_name'];
                          $middelNameList = ['middel_name', 'mname', 'MiddelName', 'm_name'];
                          $lastNameList = ['lname', 'LastName', 'last_name', 'l_name'];
                          $fullName = ['fullName', 'full_name', 'fname', 'f_name'];
                          $phoneNumberList = ['phone_number', 'phonenumber', 'mobile_number',];
                          $emailList = ['email_id', 'emailid', 'email', 'primary_emailid', 'primaryemail'];
                          if (in_array($leadsFieldData->name, $firstNameList)) {
                            foreach ($leadsFieldData->values as $leadsFieldValues) {
                              $FirstName = $leadsFieldValues;
                            }
                          }
                          if (in_array($leadsFieldData->name, $middelNameList)) {
                            foreach ($leadsFieldData->values as $leadsFieldValues) {
                              $MiddelName  = $leadsFieldValues;
                            }
                          }
                          if (in_array($leadsFieldData->name, $lastNameList)) {
                            foreach ($leadsFieldData->values as $leadsFieldValues) {
                              $LastName  = $leadsFieldValues;
                            }
                          }
                          if (in_array($leadsFieldData->name, $fullName)) {
                            foreach ($leadsFieldData->values as $leadsFieldValues) {
                              $FullName  = $leadsFieldValues;
                            }
                          }
                          if (in_array($leadsFieldData->name, $phoneNumberList)) {
                            foreach ($leadsFieldData->values as $leadsFieldValues) {
                              $PhoneNumber = $leadsFieldValues;
                            }
                          }
                          if (in_array($leadsFieldData->name, $emailList)) {
                            foreach ($leadsFieldData->values as $leadsFieldValues) {
                              $EmailId  = $leadsFieldValues;
                            }
                          }
                          //Save Lead Field Name And Their Values In Array
                          foreach ($leadsFieldData->values as $leadsFieldValues) {
                            $leadsFieldValuesForFbUploadTable[] = $leadsFieldValues;
                            $leadsFieldDataForFbUploadTable[] = $leadsFieldData->name;
                          }
                        }
                        $isLeadExists = CHECK("SELECT LeadsPhone FROM lead_uploads WHERE LeadsPhone='$PhoneNumber'");
                        if ($isLeadExists != true) {
                          if (empty($FirstName)) {
                            $FirstName = "";
                          }
                          if (empty($MiddelName)) {
                            $MiddelName = "";
                          }
                          if (empty($LastName)) {
                            $LastName = "";
                          }
                          if (empty($FullName)) {
                            $FullName = "";
                          }
                          if (empty($EmailId)) {
                            $EmailId = "";
                          }
                          if (empty($PhoneNumber)) {
                            $PhoneNumber = "";
                          }
                          $FaceBookLeads = [
                            "LeadsName" => $FirstName . " " . $MiddelName . " " . $LastName . " " . $FullName,
                            "LeadsEmail" => $EmailId,
                            "LeadsPhone" => $PhoneNumber,
                            "LeadsCity" => "Null",
                            "LeadsSource" => "Facebook",
                            "UploadedOn" => CURRENT_DATE_TIME,
                            "LeadStatus" => "UPLOADED",
                            "LeadsUploadBy" => "null",
                            "LeadsUploadedfor" => "1",
                            "LeadsAddress" => "Null",
                            "LeadsProfession" => "Null",
                            "LeadProjectsRef" => "Null",
                            "LeadsWhatsappPhoneNumber" => "Null",
                            "LeadProjectsRef" => "$fb_project_Id",
                            "CompanyID" => $companyId,
                          ];
                          $Save = INSERT("lead_uploads", $FaceBookLeads);
                          $leadUploadId = FETCH("SELECT leadsUploadId FROM lead_uploads ORDER BY leadsUploadId DESC", "leadsUploadId");
                          if (!empty($leadUploadId)) {
                            foreach ($leadsFieldDataForFbUploadTable as  $keys => $data) {
                              $FaceBookLeads = [
                                "Lead_field_data" => $data,
                                "Lead_field_value" => $leadsFieldValuesForFbUploadTable[$keys],
                                "leadsUploadId" => $leadUploadId
                              ];
                              $Save = INSERT("fb_lead_uploads", $FaceBookLeads);
                            }
                            //Make Empty Array To Store New Data and Value
                            unset($leadsFieldValuesForFbUploadTable);
                            unset($leadsFieldDataForFbUploadTable);
                          }
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
      curl_close($ch);
    }
  }
  //transfer leads
  //   //TRANSFER LEADS to users
  //   //Distribute Leads
  $FetchAllUploadedLeads = _DB_COMMAND_("SELECT * FROM lead_uploads WHERE LeadStatus='UPLOADED'", true);

  if ($FetchAllUploadedLeads != null) {
    foreach ($FetchAllUploadedLeads as $UploadedLead) {
      $LeadsCity = $UploadedLead->LeadsCity;
      $companyId = $UploadedLead->CompanyID;
      $UserId = FETCH("SELECT * FROM user_project_type, company_users WHERE user_project_type.User_main_Id=company_users.company_alloted_user_id and company_user_role NOT IN ('Admin', 'Digital') and User_project_main_Id='" . $UploadedLead->LeadProjectsRef . "' AND CompanyId='$companyId' ORDER BY rand() LIMIT 1", "User_main_Id");
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
        "LeadPersonNotes" => "",
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
    }
  }
}
