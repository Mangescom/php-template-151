//scroll effect
function paraScroll(){
    var ypos,background,foreground;
	ypos = window.pageYOffset;
	background = document.getElementById('background');
	foreground = document.getElementById('mainarea');
	background.style.top = ypos * .5 + 'px';
}


//change navigation style
function scroll() {
    paraScroll();
    var trigger = document.getElementById("navi-trigger");
    var navi = document.getElementById("navigation");
	var height = document.getElementById('background').clientHeight;
	if (window.scrollY >= height - 80) {
		navi.style.backgroundColor = '#474b57';
		navi.style.boxShadow = '3px 3px 15px black';
		trigger.style.backgroundColor = '#474b57';
		trigger.style.boxShadow = '3px 3px 15px black';
	} else {
		navi.style.backgroundColor = 'transparent';			
		navi.style.boxShadow = 'none';
		trigger.style.backgroundColor = 'transparent';			
		trigger.style.boxShadow = 'none';
	}
}

//functionality
function hideLoader(){
    if(Date.now()-timerStart > 300){
        $("#loading").animate({marginTop: '-100%', opacity: '0'}, 1000);
        setTimeout(function(){
            $("#mainbody").animate({opacity: '1'}, 100);
        }, 1000);
    }
    else{
        $("#loading").hide();
        document.getElementById("mainbody").style.opacity = "1";
    }
}

//show or hide search field
function search() {
	var searchfield = document.getElementById('search');
	var searchbutton = document.getElementById('searchbutton');
	if(searchfield.style.display == 'block'){
		searchfield.style.display = 'none';
		searchbutton.style.display = 'block';
	}else{
		searchfield.style.display = 'block';	
		searchbutton.style.display = 'none';
	}
}

//show or hide mobile menu	
function showMenu() {
    var navi = document.getElementById("mobile-nav");
    var nav = document.getElementById("navigation");
    var bg = document.getElementById("background");
    var trigger = document.getElementById("navi-trigger");
    var height = "";
    
    if(navi.style.display == "block"){
        trigger.style.boxShadow = '3px 3px 15px black';
        navi.style.display = "none";
        nav.style.height = "auto";
        nav.style.backgroundColor = "transparent";
        bg.style.height = height;
        scroll();
    }
    
    else{
        height = bg.offsetHeight;
        trigger.style.boxShadow = 'none';
        navi.style.display = "block";
        nav.style.height = "100%";
        nav.style.backgroundColor = "rgb(71, 75, 87)";
        bg.style.height = "0px";
    }
}

