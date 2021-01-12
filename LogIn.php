<?php
/**
 * @file 
 * 
 * @brief  This part shows an loginpage and handles the ajax request VideoStream SteedsHoger
 * 
 * @details 
 * 
 * @author 		Hugo van der Wel / Jordi van Nistelrooij
 * @email 		info@websensystems.nl
 * @website		https://steedshogermalden.nl
 * @version 	1.0.1
 * @date 		2021-01-12
 * @copyright 	None of these scripts may be copied or modified without permission of the authors
 * 
 * @note        2021-01-13  Added more error heandling on response.
 *                          Added discription on how to get access.
 * @todo        Add Payment method
 * @bug
 */

if(!defined("SHVideoStreamMain")){
    echo "Direct access not allowed";
    exit();
}
include('./includes/header.php');
?>



<div class="big" style=width:100%>
<link rel='stylesheet' href='style_Videos.css' type='text/css' media='all'>
<script src="https://wes-server.nl/cdn/jquery/jquery.min.js"></script>
<script defer src="https://wes-server.nl/cdn/fontawesome/js/solid.min.js"></script>
<script defer src="https://wes-server.nl/cdn/fontawesome/js/fontawesome.min.js"></script>
<link rel="stylesheet" href="https://wes-server.nl/cdn/bootstrap/css/bootstrap.min.css">
<script src="https://wes-server.nl/cdn/bootstrap/js/bootstrap.bundle.min.js"></script>
<center>

<div class="container">
    <div class=row>
        <div class='col-md-1'></div>
        <div class='col-md'>

            <p class="mt-4 h3">Steeds Hoger Kids presenteert</p>
            <h1 class="m-5 display-1"> The Next Level </h1>
            <a class="btn" data-toggle="collapse" href="#collapseDescription" role="button" aria-expanded="false" aria-controls="collapseDescription">
                
                <button class="btn btn-block" type="button">
                    Klik hier voor een beschrijving van het stuk
                <i class="fas fa-caret-down "></i>
                </button>

                
            </a>
            <div class="collapse" id="collapseDescription">
                <div class="card card-body">
                    Claire en Bente moeten nablijven. Terwijl ze in het straflokaal wachten op
                    de komst van de schoolleider wordt hun nieuwsgierigheid gewekt door een
                    grote kist. Deze kist blijkt de ingang van een computergame te zijn. Bente
                    en Claire komen terecht in Levelland. De Game-Queen regeert hier met
                    harde hand. De meiden kunnen het spel alleen verlaten door zes levels te
                    spelen. Waar de level-masters ze het liefst alleen maar willen helpen,
                    maakt de Game-Queen het de meiden alleen maar lastiger. Zal het ze ooit
                    lukken de uitgang te vinden?
                </div>
            </div>
            <img src="/img/kidsFoto2020.jpg" alt="groepsfoto Kids groep die The Next Level heeft gespeeld" width="810" class="mb-5 rounded">
            <p class="mb-5 h3">Vul uw code hieronder in om de film van de uitvoering te zien</p>



            <div class='VideoCodeInputWrapper form-group'>
                <div class="input-group mb-3">    
                    <div class="input-group-prepend">
                        <span class="input-group-text VideoCodepreIcon"><i class="fas fa-theater-masks fa-lg"></i></span>
                    </div>
                    <input autofocus id='VideoCodeInput' class='VideoCodeInputField form-control ' placeholder='Videocode' /> 
                    <div class="input-group-append">
                        <span onClick='CheckCode()' class='btn btn-outline-secondary VideoCodeSendButton'>Code invoeren <i class="fas fa-arrow-right fa-lg"></i></span><br/>
                    </div>
                    
                </div>
                <span id='VideoCodeResponse' class='alert' role='alert'></span>
                
            </div>
            <p style='text-align: left;'>Om de kosten van onze voorstellingen terug te verdienen bieden we deze stream voor een kleine vergoeding aan. Voor het aanvragen van een code kunt u mailen naar <a href=mailto:info@steedshogermail.nl>info@steedshogermail.nl</a>. Na de betaling ontvangt u de code om in te loggen per mail.
            De code geeft toegang tot de voledige video van de voorstelling "The Next Level" van onze Kids. Met de betaling helpt u ook onze vereniging in deze moeilijk tijden. Daarvoor, bijvoorbaat, onze grote dank!</p>
        </div>
        <div class='col-md-1'></div>
    </div>
</div>
</center>

<script>

/**
 * This functions check the given code.
 * 
 * 
 */
function CheckCode(){
    $.ajax({
		url: 'CodeCheck.php',
		type: 'POST',
		data: {
			Code: $('#VideoCodeInput').val()
		},
		success: function (data) {
			response = JSON.parse(data);
			if (response.Status === true) {
                $('#VideoCodeResponse').removeClass("alert-danger");
                $('#VideoCodeResponse').addClass("alert-success");
                $('#VideoCodeResponse').html(response.Response);
               setTimeout(function(){location.href = location.href}, 2000);
			} else {
                $('#VideoCodeResponse').removeClass("alert-success");
                $('#VideoCodeResponse').addClass("alert-danger");
                $('#VideoCodeResponse').html(response.Response);
			}
        },
        error: function (request, status, error) {
            $('#VideoCodeResponse').removeClass("alert-success");
            $('#VideoCodeResponse').addClass("alert-danger");
            $('#VideoCodeResponse').html("Iets ging er niet goed. Probeer het later nog eens.");
            
        }
    });
}

</script>

