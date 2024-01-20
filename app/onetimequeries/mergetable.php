<?php
$Dir = "..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


$CompanyId = _DB_COMMAND_("SELECT * FROM config_companies ORDER By company_id ASC", true);
if ($CompanyId != null) {
    foreach ($CompanyId as $CompId) {
        // echo "save --------" . $CompId->company_id . "<br>";
        // convert in encript
        
        $CId = SECURE($CompId->company_id, "e");

        $table = [
            "CompanyMainId" => $CompId->company_id,
            "Enc_CompanyMainId" => $CId,
        ];
        $save = INSERT("encripted_companies", $table);
        echo "save --------" . $CompId->company_id . "<br>";
    }
}
