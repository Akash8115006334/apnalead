<?php
//flash msg
function MSG($type, $msg)
{
    $_SESSION["$type"] = "$msg";
}

//function for msg and redirect same
function LOCATION($type, $msg, $url)
{
    MSG("$type", "$msg");
    header("location: $url");
}

//responser for all controllers
function RESPONSE($act, $msg, $msg2, $url = null)
{
    global $access_url;

    if ($url == null) {
        $access_url = $access_url;
    } else {
        $access_url = $url;
    }

    if ($act == true) {
        LOCATION("success", "$msg", "$access_url");
    } else {
        LOCATION("danger", "$msg2", "$access_url");
    }
}
