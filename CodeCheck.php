<?php
/** 
 * @file        CodeCheck.php
 * 
 * @brief       VideoStream SteedsHoger - CodeCheck script. Does an db check of the given code.
 * 
 * @details     This file checks if an given code exsist. If so, it register the connected pc in de sessiontable and set an cookie.
 * 
 * @author 		Hugo van der Wel / Jordi van Nistelrooij
 * @email 		info@websensystems.nl
 * @website		https://steedshogermalden.nl
 * @version 	1.0.1
 * @date 		2021-01-09
 * @copyright 	None of these scripts may be copied or modified without permission of the authors
 * 
 * @note
 *  2021-01-10  Added real_escape_string for $_POST["Code"]
 *  2021-01-13  Added safe() for real_escape_string
 *              Added more info on error message
 *              Incresed length of sessionID to 12
 *  
 * @todo        Add control of the times code is used.
 *              Add control of code lifetime.
 * @bug
 */

require_once("../includes/MySQL.php");

/**
 * Function for creating random strings
 * 
 */
function randomString(int $intChars = 6, bool $boolSmall = true, bool $boolCase = true, bool $boolNumbers = true, bool $boolSpecial = true): string{
    $_strSeed = "";

    if($boolSmall) $_strSeed .= 'abcdefghijklmnopqrstuvwxyz';
    if($boolCase) $_strSeed .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if($boolNumbers) $_strSeed .= '0123456789';
    if($boolSpecial) $_strSeed .= '!@#$%&*';

    $_arraySeed = str_split($_strSeed);
    shuffle($_arraySeed); // probably optional since array_is randomized; this may be redundant
    $_strRandomString = '';
    foreach (array_rand($_arraySeed, $intChars) as $k) $_strRandomString .= $_arraySeed[$k];
    unset($_arraySeed, $_strSeed,$k);
    return $_strRandomString;
}

if(isset($_POST["Code"])){
    
    $_POST["Code"] = $DB->safe($_POST["Code"]);
    $objQueryResponse = $DB->query("SELECT * FROM `VideoCodes` WHERE `Code` = '".$_POST["Code"]."'");
    if($objQueryResponse->num_rows > 0){
        //code goed
        session_start();
        $DB->query("DELETE FROM `VideoSessions` WHERE TIMESTAMPDIFF(DAY, `LoggedIn`,NOW()) > 1");
        $arrayVideoCode = $objQueryResponse->fetch_assoc();
        $DB->query("UPDATE `VideoCodes` SET `Used`=(`Used`+1), `LastUsed` = NOW() where `Code`='".$_POST["Code"]."'");
        $_SESSION["ID"] = randomString(12);
        $DB->query("INSERT INTO `VideoSessions` VALUES(NULL,'".$_POST["Code"]."','".$_SERVER["REMOTE_ADDR"]."','".$_SESSION["ID"]."',NOW())");
        echo json_encode(array("Status" => true, "Response" => "Code geaccepteerd. U wordt nu doorverwezen naar de voorstelling."));
    }else{
        //code fout
        echo json_encode(array("Status" => false, "Response" => "Code is niet bekend. Controleer het gebruik van hoofdletters. Waneer het niet lukt kunt u contact opnemen met info@steedshogermalden.nl."));
    }
}else{
    echo json_encode(array("Status" => false, "Response" => "Iets ging er niet goed. Probeer het later nog een keer."));
}

 ?>

