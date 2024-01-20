<?php

if (isset($_POST['paymentId'])) {
    //=========================inserting data in billing table==================
    if ($_POST["PlanPeriod"] == "Monthly") {
        $newdate = 30;
    } elseif ($_POST["PlanPeriod"] == "Half-Yearly") {
        $newdate = 6 * 30;
    } elseif ($_POST["PlanPeriod"] == "Yearly") {
        $newdate = 12 * 30;
    }
    $userPlanStartedFrom = CURRENT_DATE;
    $userPlanEndAt = date('Y-m-d ', strtotime("+$newdate days", strtotime($userPlanStartedFrom)));
    $billing = [
        "user_billing_ref_no" => $_POST['bill_ref_no'],
        "user_billing_net_users" => $_POST['total_user'],
        "user_billing_status" => "1",
        "user_billing_plan_main_id" => $_POST["adminPlanId"],
        "user_billing_created_at" => CURRENT_DATE_TIME,
        "user_billing_month" =>   date('F,Y'),
        "user_billing_paid_at" => CURRENT_DATE_TIME,
        "user_main_id" => $_POST["user_ID"],
        "user_billing_from_date" => $userPlanStartedFrom,
        "user_billing_to_date" => $userPlanEndAt,
        "user_inactive_times" => "0",
    ];
    $UserId = $_POST["user_ID"];
    $CheckPlanExist = CHECK("SELECT * FROM user_billings WHERE user_main_id ='$UserId' and user_billing_status='1'");
    if ($CheckPlanExist == null) {
        $bill = INSERT("user_billings", $billing);
    } else {
        $bill = UPDATE_TABLE("user_billings", $billing, "user_main_id='$UserId'");
    }
    //=================inserting data in user plan table =======================
    $UserPlan = [
        "user_plan_main_id " => $_POST["adminPlanId"],
        "user_main_id" => $_POST["user_ID"],
        "user_plan_amount_per_user" => $_POST["PlanAmount"],
        "total_user" => $_POST['total_user'],
        "user_plan_pay_period" => $_POST["PlanPeriod"],
        "user_plan_started_from" => CURRENT_DATE_TIME,
        "user_plan_status" => "1",
    ];
    $CheckUserPlanExist = CHECK("SELECT * FROM user_plan WHERE user_main_id ='$UserId' and user_plan_status='1'");
    if ($CheckPlanExist == null) {
        $plan = INSERT("user_plan", $UserPlan);
    } else {
        $plan = UPDATE_TABLE("user_plan", $UserPlan, "user_main_id ='$UserId' and user_plan_status='1'");
    }

    // get the billing id
    $billing_id = _DB_COMMAND_("SELECT user_billing_id FROM user_billings ORDER BY user_billing_id DESC LIMIT 1", true);
    foreach ($billing_id as $BillID) {
        $id = $BillID->user_billing_id;
    }
    $transaction = [
        "user_txn_amount" => $_POST['FINAL_PRICE'],
        "user_txn_payment_id" => $_POST['paymentId'],
        "user_txn_ref_no" => $_SESSION["txn_ref_no"],
        "user_txn_date" => CURRENT_DATE_TIME,
        "user_txn_pay_mode" => "Online",
        "user_txn_status" => "1",
        "user_paid_at" => CURRENT_DATE_TIME,
        "user_txn_tax" => "18",
        "user_billing_main_id" => $id,
    ];
    $CheckTransactionExist = CHECK("SELECT * FROM user_transactions where user_billing_main_id='$id'");
    if ($CheckTransactionExist == null) {
        $txn = INSERT("user_transactions", $transaction);
        $access_url = "../app/receipt/index.php?billingId=$id";
        RESPONSE($txn, " Plan Purchase Successfully", "Plan  not Purchased");
    } else {
        $txn = UPDATE_TABLE("user_transactions", $transaction, "user_billing_main_id='$id'");
        $access_url = "../app/receipt/index.php?billingId=$id";
        RESPONSE($txn, " Plan Purchase Successfully", "Plan  not Purchased");
    }

    // free plan query
} elseif (isset($_POST['FreePlan'])) {
    if ($_POST["PlanPeriod"] == "Monthly") {
        $newdate = 30;
    } elseif ($_POST["PlanPeriod"] == "Half-Yearly") {
        $newdate = 6 * 30;
    } elseif ($_POST["PlanPeriod"] == "Yearly") {
        $newdate = 12 * 30;
    }
    $userPlanStartedFrom = CURRENT_DATE;
    $userPlanEndAt = date('Y-m-d ', strtotime("+$newdate days", strtotime($userPlanStartedFrom)));

    $billing2 = [
        "user_billing_ref_no" => $_POST['bill_ref_no'],
        "user_billing_net_users" => $_POST['min-user'],
        "user_billing_status" => "1",
        "user_billing_plan_main_id" => $_POST["adminPlanId"],
        "user_billing_created_at" => CURRENT_DATE_TIME,
        "user_billing_month" =>   date('F,Y'),
        "user_billing_paid_at" => CURRENT_DATE_TIME,
        "user_main_id" => $_POST["user_ID"],
        "user_billing_from_date" => $userPlanStartedFrom,
        "user_billing_to_date" => $userPlanEndAt,
        "user_inactive_times" => "0",
    ];
    $UserId = $_POST["user_ID"];
    $CheckPlanExist = CHECK("SELECT * FROM user_billings WHERE user_main_id='$UserId' and user_billing_status='1'");
    if ($CheckPlanExist == null) {
        $bill = INSERT("user_billings", $billing2);
    } else {
        $bill = UPDATE_TABLE("user_billings", $billing2, "user_main_id='$UserId'");
    }

    $UserPlan = [
        "user_plan_main_id " => $_POST["adminPlanId"],
        "user_main_id" =>  $UserId,
        "user_plan_amount_per_user" => $_POST["PlanAmount"],
        "total_user" => $_POST['min-user'],
        "user_plan_pay_period" => $_POST["PlanPeriod"],
        "user_plan_started_from" => CURRENT_DATE_TIME,
        "user_plan_status" => "1",
    ];
    $CheckUserPlanExistAgain = CHECK("SELECT * FROM user_plan WHERE user_main_id='$UserId' and user_plan_status='1'");
    if ($CheckPlanExistAgain == null) {
        $plan = INSERT("user_plan", $UserPlan);
    } else {
        $plan = UPDATE_TABLE("user_plan", $UserPlan, "user_main_id='$UserId' and user_plan_status='1'");
    }
    $access_url = "../app/Setup/1/";
    RESPONSE($bill, " Plan Purchase Successfully", "Plan  not Purchased");
}
