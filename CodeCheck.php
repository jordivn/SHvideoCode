<?php
/**
 * @file 
 * 
 * @brief  VideoStream SteedsHoger
 * 
 * @details     This file checks if an given code exsist. If so, it register the connected pc in de sessiontable and set an cookie.
 * 
 * @author 		Hugo Schut / Jordi van Nistelrooij
 * @email 		info@websensystems.nl
 * @website		https://steedshogermalden.nl
 * @version 	1.0.0
 * @date 		2021-01-09
 * @copyright 	Non of these scripts maybe copied or modified without permission of the authors
 * 
 * @note
 *  2021-01-10  Added real_escape_string for $_POST["Code"]
 * @todo        
 * @bug
 */

require_once("../includes/MySQL.php");


/**
 * Function for creating random strings
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
    $_POST["Code"] = $DB->real_escape_string($_POST["Code"]);
    $objQueryResponse = $DB->query("SELECT * FROM `VideoCodes` WHERE `Code` = '".$_POST["Code"]."'");
    if($objQueryResponse->num_rows > 0){
        //code goed
        session_start();
        $DB->query("DELETE FROM `VideoSessions` WHERE TIMESTAMPDIFF(DAY, `LoggedIn`,NOW()) > 1");
        $arrayVideoCode = $objQueryResponse->fetch_assoc();
        $intUsed = $arrayVideoCode["Used"] + 1;
        $DB->query("UPDATE `VideoCodes` SET `Used`=(`Used`+1), `LastUsed` = NOW() where `Code`='".$_POST["Code"]."'");
        $_SESSION["ID"] = randomString();
        $DB->query("INSERT INTO `VideoSessions` VALUES(NULL,'".$_POST["Code"]."','".$_SERVER["REMOTE_ADDR"]."','".$_SESSION["ID"]."',NOW())");
        echo json_encode(array("Status" => true, "Response" => "Code geaccepteerd."));
    }else{
        //code fout
        echo json_encode(array("Status" => false, "Response" => "Code is niet bekend."));
    }
}

 ?>

 