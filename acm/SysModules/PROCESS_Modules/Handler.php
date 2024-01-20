<?php


//controller request
function CONTROLLER($controllername = null)
{

    if ($controllername == null) {
        $controller = "";
    } else {
        $controller = CONTROLLER . "/" . $controllername;
    }

    return $controller;
}

//Request Handler
function RequestHandler($Response, array $results)
{
    RESPONSE($Response, $results['true'], $results['false']);
}

//Handler Delete Requests
function DeleteReqHandler($valid, array $Requestings, array $feedback = [false], $return = null, $die = null)
{


    $CheckStatus = SECURE($_GET["$valid"], "d");

    if ($CheckStatus == true) {
        foreach ($Requestings as $key => $value) {
            $Response = DELETE_FROM("$key", "$value");
            $GetData = _DB_COMMAND_("SELECT * FROM $key where $value", false);
            SENDMAILS(
                "Record Removed @from ($key=>$value)",
                "Removed Record details are @$key=>$value",
                PRIMARY_EMAIL,
                $GetData
            );
        }
    } else {
        $Response = false;
    }
    if ($return == null) {
        $access_url = SECURE($_GET['access_url'], "d");
    } else {
        $access_url = $return;
    }
    $access_url = $access_url;

    if ($die == true) {
        print_r($Requestings) . "<br>";
        echo "<br>" . $access_url . "<br>";
        die($valid);
    }

    if ($Response == true) {
        MSG("success", $feedback['true']);
    } else {
        MSG("warning", $feedback['false']);
    }
    header("location: $access_url");
}
//function HandleInvalidData()
function HandleInvalidData($Data, $redirectto)
{
    if ($Data == null || $Data == '' || $Data == false || $Data == " ") {
        header("location: $redirectto");
    }
}
