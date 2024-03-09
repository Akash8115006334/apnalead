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
    $url = "https://graph.facebook.com/v19.0/me?fields=id%2Cname%2Cadaccounts%7Baccount_id%2Cname%2Caccount_status%2Ccampaigns%7Bid%2Cname%2Cstatus%2Ccreated_time%2Cstart_time%2Cadsets%7Bid%2Cname%2Ccreated_time%2Cstart_time%2Cstatus%2Cads%7Bid%2Cname%2Ccreated_time%2Cleads%7D%7D%7D%7D&access_token=$fb_access_token";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $resp = curl_exec($ch);
    if ($e = curl_error($ch)) {
      echo $e;
    } else {
      $decoded = json_decode($resp);
      if (isset($decoded->adaccounts)) {
        if ($decoded->adaccounts != null) {
          $adsAccounts = $decoded->adaccounts->data;
          if ($adsAccounts != null) {
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
                                $fullName = ['fullName', 'full_name', 'fname', 'f_name', 'FULL_NAME'];
                                $phoneNumberList = ['phone_number', 'phonenumber', 'mobile_number', 'PHONE'];
                                $emailList = ['email_id', 'emailid', 'email', 'primary_emailid', 'primaryemail', 'EMAIL'];
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

                              // $Phone = str_replace("+91", "", );
                              $Phone = VALID_PHONE_NUMBER($PhoneNumber);
                              $FaceBookLeads = [
                                "LeadsName" => $FirstName . " " . $MiddelName . " " . $LastName . " " . $FullName,
                                "LeadsEmail" => $EmailId,
                                "LeadsPhone" => $Phone,
                                "LeadsCity" => "Null",
                                "LeadsSource" => "Facebook",
                                "UploadedOn" => CURRENT_DATE_TIME,
                                "LeadStatus" => "UPLOADED",
                                "LeadsUploadBy" => "null",
                                "LeadsUploadedfor" => "NULL",
                                "LeadsAddress" => "Null",
                                "LeadsProfession" => "Null",
                                "LeadProjectsRef" => "Null",
                                "LeadsWhatsappPhoneNumber" => "Null",
                                "LeadProjectsRef" => "$fb_project_Id",
                                "CompanyID" => $companyId,
                                "Fb_ad_id" => $fb_ads_id,
                                "Upload_Source" => "FACEBOOK"
                              ];

                              $check = CHECK("SELECT LeadsPhone FROM lead_uploads WHERE LeadsPhone='$Phone'AND CompanyID='$companyId'");
                              if ($check != true) {
                                $checkLeads = CHECK("SELECT LeadPersonPhoneNumber FROM leads WHERE LeadPersonPhoneNumber='$Phone' and CompanyID='$companyId'");
                                if ($checkLeads != true) {
                                  $Save = INSERT("lead_uploads", $FaceBookLeads);
                                  $leadUploadId = FETCH("SELECT leadsUploadId FROM lead_uploads ORDER BY leadsUploadId DESC", "leadsUploadId");
                                  if (!empty($leadUploadId)) {
                                    foreach ($leadsFieldDataForFbUploadTable as  $keys => $data) {
                                      $FaceBookLeads = [
                                        "Lead_field_data" => $data,
                                        "Lead_field_value" => $leadsFieldValuesForFbUploadTable[$keys],
                                        "leadsUploadId" => $leadUploadId,
                                        "CreatedAt" => CURRENT_DATE_TIME,
                                        "CreatedBy" => "facebook API",
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
            }
          }
        }
      }
      curl_close($ch);
    }
  }
}
$AllCompanies = _DB_COMMAND_("SELECT * FROM config_companies WHERE company_status='1'", true);
if ($AllCompanies != null) {

  //fetch all companies for distribution
  foreach ($AllCompanies as $company) {
    $companyId = $company->company_id;
    echo "@CompanyId: $companyId --- ";

    //check companies distribution is enabled or not
    $check = CHECK("SELECT Autodistribute FROM config_facebook_accounts WHERE Autodistribute='true' and CompanyID='$companyId'");

    //distribution is enabled
    if ($check == true) {
      echo "@Distribution: ---------------- <b>Enabled</b>";

      //fetch all new uploaded leads for a particular company
      $LeadsSQL = "SELECT CompanyID, LeadProjectsRef FROM lead_uploads WHERE LeadStatus='UPLOADED' and CompanyID='$companyId' ORDER BY LeadProjectsRef ASC";
      $FetchAllUploadedLeads = _DB_COMMAND_($LeadsSQL, true);

      //TempArray of Users and Leads Distribution Calculations
      $TEMP_USERS = [];
      $TOTAL_LEADS = TOTAL($LeadsSQL);

      //check leads are not uploaded
      if ($FetchAllUploadedLeads != null) {
        echo "------------@Leads: ------<b>Uploaded</b>------- ";

        //get total users and leads details 
        echo "[--<br>";
        foreach ($FetchAllUploadedLeads as $UploadedLead) {
          $companyId = $UploadedLead->CompanyID;
          $ProjecRefId = $UploadedLead->LeadProjectsRef;

          //disrtibute leads equally to users
          $UserSql = "SELECT User_main_Id FROM user_project_type, company_users WHERE user_project_type.User_main_Id=company_users.company_alloted_user_id and company_user_role='TeamMember' and User_project_main_Id='$ProjecRefId' AND CompanyId='$companyId' ORDER BY rand()";
          $UserProjectExits = CHECK($UserSql);
          if ($UserProjectExits == true) {
            $UserId = FETCH($UserSql, "User_main_Id");
            $LeadPersonManagedBy = $UserId;
          } else {
            $UserSql = "SELECT User_main_Id FROM user_project_type, company_users WHERE user_project_type.User_main_Id=company_users.company_alloted_user_id and company_user_role='TeamMember' and User_project_main_Id='$ProjecRefId' AND CompanyId='$companyId' ORDER BY rand()";
            $UserId = FETCH($UserSql, "User_main_Id");
            $LeadPersonManagedBy = $UserId;
          }

          //get users list and counts
          if (!in_array($LeadPersonManagedBy, $TEMP_USERS)) {
            array_push($TEMP_USERS, $LeadPersonManagedBy);
          }
        }
      }

      //All Users fetched successfully
      foreach ($TEMP_USERS as $User) {
        echo "@U->$User<br>";
      }
      echo "--- }<br>";
      //all users and leads
      $AllUsers = _DB_COMMAND_("SELECT company_alloted_user_id FROM company_users WHERE company_user_role='TeamMember' AND company_user_status='1' AND company_main_id='$companyId'", true);
      if ($AllUsers != null) {
        $TotalLeds = 0;
        foreach ($AllUsers as $Users) {
          $LeadsCount = TOTAL("SELECT * FROM leads where LeadPersonManagedBy='" . $Users->company_alloted_user_id . "'");
          echo "@UserId: (" . $Users->company_alloted_user_id . ") ------ @TotalLeads: " . $LeadsCount . " Leads --<br>";
          $TotalLeds += $LeadsCount;
        }
        echo "@TOTAL-LEADS: " . $TotalLeds . " Leads ---<br>";
      } else {
        echo "@No User Found!<br>";
      }

      //Leads Per User
      $TOTAL_USERS = COUNT($TEMP_USERS);
      $LEAD_PER_USER = round($TOTAL_LEADS / $TOTAL_USERS);
      echo "@TOTAL-USERS: $TOTAL_USERS---<br>";
      echo "@LEAD-PER-USER: $LEAD_PER_USER---<br>";
      echo $TEMP_USERS[0];


      //All Uploaded Leads
      echo "[--<br>";
      echo "@DISTRIBUTION-STARTED: -------------------------------------------------------<br>";
      //start disrtibuting leads as per project define
      for ($Start = 0; $Start < $TOTAL_USERS; $Start++) {
        $LEAD_LIMIT = ($Start + 1) * $LEAD_PER_USER;
        $LeadPersonManagedBy = $TEMP_USERS[$Start];
        $LOOP_LEVEL = $Start + 1;

        echo "@LOOP-START-$LOOP_LEVEL: LEADS-LIMIT:$LEAD_LIMIT----USER-ID: $LeadPersonManagedBy -----<br>";
        //fetch all new uploaded leads for a particular company
        $LeadsSQL = "SELECT * FROM lead_uploads WHERE LeadStatus='UPLOADED' and CompanyID='$companyId' ORDER BY LeadProjectsRef ASC limit $LEAD_LIMIT";
        $FetchAllUploadedLeads = _DB_COMMAND_($LeadsSQL, true);
        if ($FetchAllUploadedLeads != null) {
          foreach ($FetchAllUploadedLeads as $UploadedLead) {
            $LeadsCity = $UploadedLead->LeadsCity;
            $companyId = $UploadedLead->CompanyID;
            $ProjecRefId = $UploadedLead->LeadProjectsRef;
            $leadsUploadId = $UploadedLead->leadsUploadId;

            echo "----------------@UserId: $LeadPersonManagedBy --- ";

            //save leads
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
              "LeadProjectId" => $UploadedLead->LeadProjectsRef,
              "CompanyID" => $companyId,
              "Distribute_Type" => "Auto",
            );

            //check phone number exits or not
            $CheckPhoneNumberExists = CHECK("SELECT LeadPersonPhoneNumber FROM leads where LeadPersonPhoneNumber='" . $UploadedLead->LeadsPhone . "' and CompanyID='$companyId'");


            //phone number not exists
            if ($CheckPhoneNumberExists == false) {

              $save = INSERT("leads", $data);
              $LeadMainId = FETCH("SELECT LeadsId FROM leads where LeadPersonPhoneNumber='" . $UploadedLead->LeadsPhone . "' and CompanyID='$companyId'", "LeadsId");
              $LeadRequirements = array(
                "LeadMainId" => $LeadMainId,
                "LeadRequirementDetails" => $UploadedLead->LeadProjectsRef,
                "LeadRequirementStatus" => "1",
                "LeadRequirementCreatedAt" => CURRENT_DATE_TIME,
                "LeadRequirementNotes" => "",
                "LeadCompanyId" => $companyId
              );
              $Save = INSERT("lead_requirements", $LeadRequirements);
              $Update = UPDATE("UPDATE lead_uploads SET LeadStatus='TRANSFERRED' WHERE leadsUploadId='$leadsUploadId' and CompanyID='$companyId'");

              //saved new phone number
              echo "@LEAD-PHONE-NUMBER:(" . $UploadedLead->LeadsPhone . ") --- @Doesn't exist & Saved --- <br>";

              //phone number exits
            } else {
              echo "@LEAD-PHONE-NUMBER:(" . $UploadedLead->LeadsPhone . ") --- @Exist--- <br>";
            }
          }
        }
        echo "@LOOP-END: DISTRIBUTION-DONE: LOOP-$LOOP_LEVEL------ FOR Users: $LeadPersonManagedBy------- LEADS: $LEAD_LIMIT Leads ------ DISTRIBUTED-TO: $LeadPersonManagedBy UserId---------- IN-TOTAL-USERS: $TOTAL_USERS Users<br>";
      }
      echo "@DISTRIBUTION-ENDED: -------------------------------------------------------<br>";
      echo "--] <br>|-------------------------|<br>";
      echo "@LeadDistributed: -- {<br>";
    } else {
      echo "@Distribution: Disabled";
    }
    echo "<br>";
  }
} else {
  echo "<b>@No Active Companies Found!</b><br>";
}

if (isset($_GET['empty'])) {
  echo "<br>--------------------------------------------<br>";
  $RemoveRecords = [
    "fb_lead_uploads", "leads", "lead_followups", "lead_followup_durations", "lead_requirements", "lead_uploads"
  ];

  foreach ($RemoveRecords as $SQL) {
    $SqlQuery = "TRUNCATE " . $SQL;
    $Query = SELECT($SqlQuery);
    if ($Query == true) {
      echo "@" . $SQL . "--Removed<br>";
    }
  }
}
