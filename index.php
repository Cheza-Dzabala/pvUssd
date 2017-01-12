<?php

include 'english/index.php';

// Reads the variables sent via POST from our gateway
$sessionId   = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text        = $_POST["text"];

$array = explode("*", $text);

// Check The Values of Text Input and assign variables appropriately
if ($array[0] == "1") //Patient Selects English
{
    if ($array[1] == "1") //Patient Selects Register
    {
        if ($array[2] == "2") //Patient Does Not Own The Number in use
        {
            $new_full_name = $array[3];
            $new_phone_number = $array[4];
            $new_pin_number = $array[5];
        }
        else if ($array[2] == "1") //Patient Owns The Number in use
        {
            $new_full_name = $array[3];
            $new_pin_number = $array[4];
        }
    }
    else if ($array[1] == "2") //Patient Reports An ADR
    {


    }
}
else if ($array[0] == "2")
{

}

/*Level 0*/
if ( $text == "" ) {
    // This is the first request. Note how we start the response with CON
    $response  = "CON Welcome to A.D.R.I.S \n";
    $response .= "1. English \n";
    $response .= "2. Chichewa";
}


/* First Level Logic */
else if ( $text == "1" ) {
    $response = $englishResponse;
}

else if($text == "2") {
    // Business logic for first level response
    // This is a terminal request. Note how we start the response with END
    //$response = "END Your phone number is $phoneNumber";
    $response = "CON Sankhani Chochita?";
    $response .= "1. Lembestani";
    $response .= "2. Fotokozani Zizindikilo Zoopsya";
    $response .= "3. Fusani";
}

/*Second Level Logic*/

//Registering Second Level
else if($text == "1*1") {
    // This is a second level response where the user selected 1 in the first instance
    // This is a terminal request. Note how we start the response with END
    $response = $registerResponse;
}

//ADR Reporting Second Level
else if($text == "1*2")
{
    $response = "CON Is This The Phone Number You Registered With? \n";
    $response .= "1. Yes";
    $response .= "2. No";
}


//Third Level Logic

/*Registering*/
//Phone Number Is Users
else if ($text == "1*1*1")
{
    $response = "CON Please Enter Your Full Name";
}

//Phone Numbers Isn't Users
else if ($text == "1*1*2"){
    $response = "CON Please Enter Your Full Name";
}

/*ADR REPORTING*/
else if($text == "1*2*1")
{
    $response = "CON Please Enter Your 4 Digit PIN";
}

else if($text == "1*2*2")
{
    $response = "CON Please Enter Your Phone Number";
}


else if($text == "1*1*1*$new_full_name")
{
    $response = "CON Please enter your new 4 digit pin";
}

else if ($text == "1*1*1*$new_full_name*$new_pin_number"){
    $response = "END Thank you for registering on A.D.R.I.S";
}



else if ($text == "1*1*2*$new_full_name"){
    $response = "CON Please enter your Phone Number";
}

else if ($text == "1*1*2*$new_full_name*$new_phone_number"){
    $response = "CON Please enter your new 4 digit pin";
}

else if ($text == "1*1*2*$new_full_name*$new_phone_number*$new_pin_number"){
    $response = "END Thank you for registering on A.D.R.I.S";
}




/**
else if($text == "1*1*$symptoms"){
//This is another level response
$response = "END captured symptoms $symptoms";
}
 * */
// Print the response onto the page so that our gateway can read it
header('Content-type: text/plain');
echo $response;
// DONE!!!
?>