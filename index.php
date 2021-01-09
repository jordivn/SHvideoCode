<?php
/**
 * @file index.php
 * 
 * @brief Landingpage VideoStream SteedsHoger
 * 
 * @details This page should welcome the viewer and give an keylogin screen, or the video if the viewer was already loggedin.
 * 
 * @author 		Hugo Schut / Jordi van Nistelrooij
 * @email 		info@websensystems.nl
 * @website		https://steedshogermalden.nl
 * @version 	1.0.0
 * @date 		2021-01-09
 * @copyright 	Non of these scripts maybe copied or modified without permission of the authors
 * 
 * @note
 * @todo
 * @bug
 */

define("SHVideoStreamMain",true);
require_once("../includes/MySQL.php");
session_start();
$boolUserLoggedIn = false;

if(isset($_SESSION["ID"])){
    $objQueryResponse = $DB->query("SELECT * FROM `VideoSessions` WHERE `SessionID` = '".$_SESSION["ID"]."' AND `IP` = '".$_SERVER["REMOTE_ADDR"]."'");
    if($objQueryResponse->num_rows > 0){
        $boolUserLoggedIn = true;
    }
}


if($boolUserLoggedIn){
    include_once("VideoEmbed.php");
}else{
    include_once("../includes/header.php");
    include_once("LogIn.php");
    include_once("../includes/footer.php");
}
?>