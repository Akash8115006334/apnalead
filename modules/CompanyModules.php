<?php
function CompanyPrimaryDetails($ID, $CompanyColumn)
{
    $CompanyUser = CHECK("SELECT $CompanyColumn FROM config_companies WHERE company_id ='$ID'");
    if ($CompanyUser != null) {
        $GetCompanyDetails = FETCH("SELECT $CompanyColumn FROM config_companies WHERE company_id='$ID'", "$CompanyColumn");
        if ($CompanyColumn == "company_logo") {
            return STORAGE_URL . "/company/$ID/logo/" . $GetCompanyDetails;
        }
        if ($GetCompanyDetails == null) {
            return "";
        } else {
            return $GetCompanyDetails;
        }
    }
}
