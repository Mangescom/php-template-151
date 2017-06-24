<html>

<head>
	<title><?= htmlspecialchars($title)?></title>
	<meta charset="utf-8" /> 
	<meta name="viewport" content="width=device-width,initial-scale=1">
	
	<link href="../css/mainstyle.css" rel="stylesheet">
	<link href="../css/display.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Baloo+Bhaina" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/design.js"></script>
	<script> 
	    var timerStart = Date.now();
	    
	    setTimeout(function(){
            $("#loading").animate({opacity: '1'}, 1000);
        }, 100);
        
        var timer;
	    window.onresize = function(){ 
			if(window.innerWidth >= 650 ){
	        clearTimeout(timer);
	        timer=setTimeout(function(){ location.reload(); }, 500)};
	    } 
	    
	    window.addEventListener('scroll', function() { scroll(); });
	    
	    function hideLoader(){
    	    if(Date.now()-timerStart > 800){
    	        $("#loading").animate({marginTop: '-100%', opacity: '0'}, 1000);
    	        setTimeout(function(){
                    $("#mainbody").animate({opacity: '1'}, 100);
                }, 1000);
                setTimeout(function(){
                    $("#loading").hide();
                }, 1200);
    	    }
            else{
                $("#loading").hide();
                document.getElementById("mainbody").style.opacity = "1";
            }
        };
    </script>
	
</head>

<body onload="hideLoader()">
    
    <!--Preloading screen to cover gif loading-->
    <div id="loading" style="opacity:0">
    <figure id="loader">
        <div class="loading-bar"></div>
        <div class="loading-bar"></div>
        <div class="loading-bar"></div>
        <div class="loading-bar"></div>
        <div class="loading-bar"></div>
        <h1 style="color:white">They see me loadin...<h1>
    </figure>
    </div>
    
    <figure id="mainbody" style="opacity: 0;">
		
	<!--Navigation-->	
	<a href="/"><img id="logo" src="../img/logo.png" /></a>
		
	<ul id="navigation">
	    <a id="navi-trigger" onclick="showMenu();"><i class="fa fa-bars" aria-hidden="true"></i></a>
	    
	    <figure id="mobile-nav">
	    	<li><a href='/'>Home</a></li>
			<li><a href="blog">Blog</a></li>
    		<li><a href="videos">Videos</a></li>
    		<li><a>
    		    <form id="search" method="post" action="search">
    		        <input name="search" id="searchfield" type="search" placeholder="Search" autocomplete="off"/>
    		        &nbsp;&nbsp;<i onclick="search();" class="fa fa-search"></i>
    		    </form>
    		    <i id="searchbutton" onclick="search();" class="fa fa-search"></i>
		    </a></li>
    		
    		<?php
				echo '<li><a href="/account"><i class="fa fa-user"></i></a></li>';
				
				if(isset($_SESSION["email"])) {
					$name = $_SESSION["email"];
				}		
				else {
					$name = "";
				}				
			?>
		</figure>
	</ul>
	
	<!--Content gets rendered here-->
	<div id="fullscreen"></div>
	<img id="hipster" src="img/logo2.png" />
    
</html>
