<?php

/**
 * @file KeyGen.php
 * 
 * @brief CodeGenerator
 * 
 * @details 
 * 
 * @author 		Jordi van Nistelrooij
 * @email 		info@websensystems.nl
 * @website		https://steedshogermalden.nl
 * @version 	1.0.0
 * @date 		2021-01-09
 * @copyright 	None of these scripts may be copied or modified without permission of the authors
 * 
 * @note        Not used in production envoirement
 * @todo
 * @bug
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once("../includes/MySQL.php");

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

for($i=0; $i < 200; $i++){
    $code = randomString(8, true, true, true, false);
    echo "Code " . $i . ": " . $code . "<br/>";
    $DB->query("INSERT INTO `VideoCodes` (`Code`) VALUES('". $code ."')");
}

?>