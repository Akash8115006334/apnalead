<?php
//initialize files
if (isset($_POST['AdminAddPlan'])) {
    if ($_POST['plan_status'] == "Active") {
        $status = 1;
    } elseif ($_POST['plan_status'] == "Inactive") {
        $status = 0;
    }
    $ImageName = $_FILES["plan_feature_image"];

    $image = UPLOAD_FILES("./../storage/image", "Null", "$ImageName", "plan_feature_image");

    $array = [
        "plan_name" => $_POST['plan_name'],
        "plan_pay_period" => $_POST['plan_pay_period'],
        "plan_amount_per_user" => $_POST['plan_amount_per_user'],
        "plan_created_at" => CURRENT_DATE,
        "plan_created_by" => LOGIN_USER_ID,
        // "plan_applicable_from" => CURRENT_DATE,
        // "plan_updated_at" => CURRENT_DATE,
        "plan_updated_by" => LOGIN_USER_ID,
        "plan_feature_image" => $image,
        "plan_description" => $_POST['plan_description'],
        "plan_status" => $status,

    ];
    $name = $_POST['plan_name'];
    $sql = INSERT("config_plans", $array);
    RESPONSE($sql, "$name Plan Updated Successfully", "Plan  not Updated");
}
