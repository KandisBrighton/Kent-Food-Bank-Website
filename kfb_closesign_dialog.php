<script>
    $(function()
    {
        $( "#kfb_closesign_dialog").dialog({height: 350, width: 350, autoOpen: false});
//
    });


    function kfb_closesign_popup()
    {


        //alert("showpopup()");


        $("#kfb_closesign_dialog" ).dialog("open");
        //alert("last popup()");

        $("#kfb_closesign_dialog").css({"visibility":"visible","display":"none"});
        $("#test1").css({"visibility":"visible","display":"block"});
        $("#kfb_closesign_dialog").fadeIn();

        var show = $("#loginform").dialog( "option", "show" );

    }

    function hidepopup()
    {
        $("#kfb_closesign_dialog").fadeOut();
        $("#kfb_closesign_dialog").css({"visibility":"hidden","display":"none"});
        $("#kfb_closesign_dialog").dialog("close");
    }


</script>


<div id="kfb_closesign_dialog" title="Operating hours" style="display: none" class = "kfb_closesign_dialog">
    <center>

    <img style="display: inline;" id="closed_sign_dialog" src="kfb_images/closed_sign_no_background.png" class= "kfb_closedsign_dialog" alt="KFB closed sign">

    </center>
</div>


	<div class="pageblock">
							<img style="display: inline;" id="closed_sign" src="kfb_images/closed_sign_no_background.png" class= "kfb_closedsign_image" alt="KFB logo" onclick="kfb_closesign_popup()">
						   <span class= "kfb_hours_of_operatrion">Alliance Center: Closed for the day</span>
						   <div class="separator-2"></div>
							  
						  <ul>
							  <li>On Wednesdays the Alliance Center is open between the hours of 10am - 1pm.</li>
							  <li>Tomorrow, and every Thursday, the Alliance Center is open to seniors (55+) between the hours of 10am - 1pm</li><BR>
						   </ul>	
						   <img style="display: inline;" id="closed_sign" src="kfb_images/closed_sign_no_background.png" class= "kfb_closedsign_image" alt="KFB logo" onclick="kfb_closesign_popup()">
						   <span class = "kfb_hours_of_operatrion">Birch Creek Annex: Closed for the day</span>
						  <div class="separator-2"></div>
						  <ul>
							  <li>Birch Creek Annex is open every Monday between the hours of 10am - 1pm</li><BR>
						   </ul>	
							  
						   <a href="http://kaneses.greenrivertech.net/kfb_services.php">See our full schedule...</a> 
					  
					</div>

