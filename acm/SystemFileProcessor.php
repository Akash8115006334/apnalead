<?php

/**
 * @SystemFileProcessor
 * 
 * here all system files will be loaded
 *
 */


//php modules
$PHP_MODULES = array(
    "DateTime.php",
    "WorkingOnDates.php",
    "EncDec.php",
    "UrlActivity.php",
    "GetIPAddress.php",
    "DeviceType.php",
    "DeviceInfo.php",
    "DataActivity.php",
    "DataReturns.php",
    "FormValidations.php",
    "CountryPhoneCodes.php",
    "AllCurrencyTypes.php",
    "UserProperties.php",
    "DeveloperConstants.php",
);
foreach ($PHP_MODULES as $Modules) {
    require  __DIR__ . "/SysModules/PHP_Modules/$Modules";
};

//files modules
$FILES_MODULES = array(
    "DocumentDetails.php",
    "GetFilesFromDirectory.php",
    "UploadHandler.php"
);
foreach ($FILES_MODULES as $Modules) {
    require  __DIR__ . "/SysModules/FILE_Modules/$Modules";
};


//process modules
$PROCESS_MODULES = array(
    "FormRequestHandler.php",
    "FormRequestValidator.php",
    "Handler.php",
    "PushAlerts.php"
);
foreach ($PROCESS_MODULES as $Modules) {
    require  __DIR__ . "/SysModules/PROCESS_Modules/$Modules";
};

//crud modules
$CRUD_MODULES = array(
    "Select.php",
    "Checker.php",
    "Insert.php",
    "Update.php",
    "Delete.php",
    "Suggest.php",
    "SysValues.php",
    "DBOperations.php",
    "CRUDOperations.php"
);
foreach ($CRUD_MODULES as $Modules) {
    require  __DIR__ . "/SysModules/CRUD_Modules/$Modules";
};

//project modules
$CONFIG_MODULES = array(
    "Configurations.php"
);
foreach ($CONFIG_MODULES as $Modules) {
    require  __DIR__ . "/SysModules/CONFIG_Modules/$Modules";
};

//activity modules
$ACTIVITY_MODULES = array(
    "AppLogsDB.php"
);
foreach ($ACTIVITY_MODULES as $Modules) {
    require  __DIR__ . "/SysModules/ACTIVITY_Modules/$Modules";
};

//payment modules
$PAYMENTS_MODULES = array(
    "Payments.php"
);
foreach ($PAYMENTS_MODULES as $Modules) {
    require  __DIR__ . "/SysModules/PAYMENT_Modules/$Modules";
};

//complaint modules
$COMPLAINT_MODULES = array(
    "Complaints.php"
);
foreach ($COMPLAINT_MODULES as $Modules) {
    require  __DIR__ . "/SysModules/COMPLAINT_Modules/$Modules";
};

//html modules
$HTML_MODULES = array(
    "Form.php",
    "HTMLTags.php",
    "HTMLFunctions.php"
);
foreach ($HTML_MODULES as $Modules) {
    require  __DIR__ . "/SysModules/HTML_Modules/$Modules";
};

//Invoice modules
$INVOICE_MODULES = array(
    "invoices.php",
);
foreach ($INVOICE_MODULES as $Modules) {
    require  __DIR__ . "/SysModules/INVOICE_Modules/$Modules";
};

//leads modules
$LEAD_MODULES = array(
    "Calls.php",
    "Leads.php"
);
foreach ($LEAD_MODULES as $Modules) {
    require  __DIR__ . "/SysModules/LEAD_Modules/$Modules";
};

//e-commerce modules
$E_COMM_MODULES = array(
    "ProductModules.php",
    "CartModules.php",
    "OrderModules.php",
    "PriceAndCharges.php"
);
foreach ($E_COMM_MODULES as $Modules) {
    require  __DIR__ . "/SysModules/E_COMMERCE_Modules/$Modules";
};

//user modules
$USER_MODULES = array(
    "users.php"
);
foreach ($USER_MODULES as $Modules) {
    require  __DIR__ . "/SysModules/USER_Modules/$Modules";
};

//employement modules
$EMPLOYEMENT_MODULES = array(
    "Attandance.php",
    "EmploymentFuns.php"
);
foreach ($EMPLOYEMENT_MODULES as $Modules) {
    require  __DIR__ . "/SysModules/EMPLOYEMENT_Modules/$Modules";
};

//enquiry modules
$ENQUIRY_MODULES = array(
    "Enquiries.php"
);
foreach ($ENQUIRY_MODULES as $Modules) {
    require  __DIR__ . "/SysModules/ENQUIRY_Modules/$Modules";
};

//expanse modules
$EXPANSE_MODULES = array(
    "Expanse.php"
);
foreach ($EXPANSE_MODULES as $Modules) {
    require  __DIR__ . "/SysModules/EXPANSE_Modules/$Modules";
};


//mails modules
$MAIL_MODULES = array(
    "Mail.php"
);
foreach ($MAIL_MODULES as $Modules) {
    require  __DIR__ . "/SysModules/MAIL_Modules/$Modules";
};


//sms modules
$SMS_MODULES = array(
    "SMS.php"
);
foreach ($SMS_MODULES as $Modules) {
    require  __DIR__ . "/SysModules/SMS_Modules/$Modules";
};

//warranty modules
$WARRANTY_MODULES = array(
    "warranty.php"
);
foreach ($WARRANTY_MODULES as $Modules) {
    require  __DIR__ . "/SysModules/WARRANTY_Modules/$Modules";
};

//project modules
$PROJECT_MODULES = array(
    "Projects.php"
);
foreach ($PROJECT_MODULES as $Modules) {
    require  __DIR__ . "/SysModules/PROJECT_Modules/$Modules";
};
