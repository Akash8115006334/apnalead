<?php

//function booleans values 
function BOOL_DATA($data = true, $true = true, $false = false)
{
 if ($data == true) {
  return $true;
 } else {
  return $false;
 }
}

//return value
function ReturnValue($data)
{
 if ($data == null) {
  return "Not Available";
 } else {
  return $data;
 }
}
