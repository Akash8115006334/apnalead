<?php
if (isset($_POST['SaveCustomerRecord'])) {
    $createdby = AuthAppUser("UserId");
    $checkPhone = CHECK("SELECT LeadPersonPhoneNumber FROM leads WHERE LeadPersonPhoneNumber='" . $_POST['UserPhoneNumber'] . "' and CompanyID='" . CompanyId . "'");
    if ($checkPhone) {
        LOCATION("warning", "Phone Number is already taken", APP_URL . "/Billing/add_invoice/");
    } else {
        $data = [
            "LeadPersonFullname" => $_POST['UserFullName'],
            "LeadSalutations" => $_POST['UserSolutation'],
            "LeadPersonPhoneNumber" => $_POST['UserPhoneNumber'],
            "LeadPersonEmailId" => $_POST['UserEmailId'],
            "LeadPersonAddress" => $_POST['CustomerStreetAddress'] . " " . $_POST['CustomerAreaLocality'] . " " . $_POST['CustomerCity'] . " " . $_POST['CustomerState'] . " " . $_POST['CustomerCountry'] . " " . $_POST['CustomerPincode'],
            "LeadPersonCreatedAt" => CURRENT_DATE_TIME,
            "LeadPersonLastUpdatedAt" => CURRENT_DATE_TIME,
            "LeadPersonCreatedBy" => $createdby,
            "LeadPersonManagedBy" => $createdby,
            "LeadPersonStatus" => $_POST['LeadPersonStatus'],
            "LeadPriorityLevel" => "HIGH",
            "LeadPersonSource" => "Self",
            "CompanyID" => CompanyId,
        ];
        $save = INSERT("leads", $data);
        $LeadsId = FETCH("SELECT LeadsId FROM leads WHERE CompanyID='" . CompanyId . "' and LeadPersonPhoneNumber='" . $_POST['UserPhoneNumber'] . "' ORDER BY LeadsId DESC LIMIT 1 ", "LeadsId");
        // save record to invoice address
        $address = [
            "CustomerLeadMainId" => $LeadsId,
            "CustomerStreetAddress" => $_POST['CustomerStreetAddress'],
            "CustomerAreaLocality" => $_POST['CustomerAreaLocality'],
            "AddressCreatedBy" => $createdby,
            "AddressCreatedAt" => CURRENT_DATE_TIME,
            "AddressUpdatedAt" => CURRENT_DATE_TIME,
            "CustomerCity" => $_POST['CustomerCity'],
            "CustomerState" => $_POST['CustomerState'],
            "CustomerCountry" => $_POST['CustomerCountry'],
            "CustomerPincode" => $_POST['CustomerPincode'],
            "CompanyID" => CompanyId,
        ];
        $save = INSERT("invoice_address", $address);
        RESPONSE("$save", "Customer Saved Successfully!", "Customer Not Saved !!");
    }
} elseif (isset($_POST['SaveService'])) {
    $service = [
        "Item_Name" => $_POST['ServiceName'],
        "HSN_Number" => $_POST['HSN_Number'],
        "ItemSalePrice" => $_POST['ServiceSalePrice'],
        "ItemSaleGST" => $_POST['ServiceApplicableTaxes'],
        "ItemNetPrice" => $_POST['ServiceNetPayable'],
        "Description" => $_POST['ServiceDescription'],
        "ItemCreatedAt" => CURRENT_DATE_TIME,
        "ItemUpdatedAt" => CURRENT_DATE_TIME,
        "ItemCreatedBy" => AuthAppUser("UserId"),
        "InvoiceType" => "Service",
        "CompanyId" => CompanyId,
    ];
    $save = INSERT("invoice_items", $service);
    RESPONSE($save, "Service Added Successfully", "Unable to add Service");
} elseif (isset($_POST['SaveProducts'])) {
    $product = [
        "Item_Name" => $_POST['ProductName'],
        "Manufracturer" => $_POST['ProductBrandName'],
        "ModalNo" => $_POST['ProductModalNo'],
        "ItemType" => $_POST['ProductType'],
        "Speciality" => $_POST['ProductCapacity'],
        "ItemLife" => $_POST['ProductLife'],
        "ItemWarranty" => $_POST['ProductWarrantyinMonths'],
        "Description" => $_POST['ProductDescription'],
        "ItemSalePrice" => $_POST['ProductSalePrice'],
        "ItemSaleGST" => $_POST['ProductApplicableTaxes'],
        "ItemNetPrice" => $_POST['ProductNetPayable'],
        "ItemMRP" => $_POST['ProductMrp'],
        "ItemCreatedAt" => CURRENT_DATE_TIME,
        "ItemUpdatedAt" => CURRENT_DATE_TIME,
        "ItemCreatedBy" => AuthAppUser("UserId"),
        "InvoiceType" => "Product",
        "CompanyId" => CompanyId,
    ];
    $save = INSERT("invoice_items", $product);
    RESPONSE($save, "Product Added Successfully", "Unable to add Product!");
} elseif (isset($_POST['UpdateService'])) {
    $ItemId = $_POST['itemId'];
    $serviceupdate = [
        "Item_Name" => $_POST['ServiceName'],
        "HSN_Number" => $_POST['HSN_Number'],
        "ItemSalePrice" => $_POST['ServiceSalePrice'],
        "ItemSaleGST" => $_POST['ServiceApplicableTaxes'],
        "ItemNetPrice" => $_POST['ServiceNetPayable'],
        "Description" => $_POST['ServiceDescription'],
        "ItemUpdatedAt" => CURRENT_DATE_TIME,
        "ItemCreatedBy" => AuthAppUser("UserId"),
    ];
    $update = UPDATE_TABLE("invoice_items", $serviceupdate, "ItemId ='$ItemId'");
    RESPONSE($update, "Service Updated Successfully", "Unable to Update Service");
} elseif (isset($_POST['UpdateProduct'])) {

    $ItemId = $_POST['itemId'];
    $productupdate = [
        "Item_Name" => $_POST['ProductName'],
        "Manufracturer" => $_POST['ProductBrandName'],
        "ModalNo" => $_POST['ProductModalNo'],
        "ItemType" => $_POST['ProductType'],
        "Speciality" => $_POST['ProductCapacity'],
        "ItemLife" => $_POST['ProductLife'],
        "ItemWarranty" => $_POST['ProductWarrantyinMonths'],
        "Description" => $_POST['ProductDescription'],
        "ItemSalePrice" => $_POST['ProductSalePrice'],
        "ItemSaleGST" => $_POST['ProductApplicableTaxes'],
        "ItemNetPrice" => $_POST['ProductNetPayable'],
        "ItemMRP" => $_POST['ProductMrp'],
        "ItemUpdatedAt" => CURRENT_DATE_TIME,
        "ItemCreatedBy" => AuthAppUser("UserId"),
    ];
    $update = UPDATE_TABLE("invoice_items", $productupdate, "ItemId ='$ItemId'");
    RESPONSE($update, "Product Updated Successfully", "Unable to Update Product");
}
