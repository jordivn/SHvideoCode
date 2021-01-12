<?php
/**
 * @file 
 * 
 * @brief  VideoStream SteedsHoger
 * 
 * @details 
 * 
 * @author 		Hugo van der Wel / Jordi van Nistelrooij
 * @email 		info@websensystems.nl
 * @website		https://steedshogermalden.nl
 * @version 	1.0.0
 * @date 		  2021-01-09
 * @copyright None of these scripts may be copied or modified without permission of the authors
 * 
 * @note      2021-01-12  Added constant check to prevent bypass.
 * @todo
 * @bug
 */
if(!defined("SHVideoStreamMain")){
  die("Direct access not allowed");
  
}

 ?>
 <body style=background-color:black;>

 <center>
<video oncontextmenu="return false;" style='width:95vw;max-height:95vh' controlsList="nodownload" controls autoplay>
  <source src="films/TheNextLevel.mp4" type="video/mp4">
Your browser does not support mp4 video's.
</video>
</center>
</body>
