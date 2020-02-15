<meta charset="UTF-8">
<title>Natural Farms Sales Form</title>
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">

<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

<link rel="icon" href="img/logo.png" type="image/gif" sizes="16x16">

<link rel="stylesheet" href="css/signature-pad.css">

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput.min.js"></script>
<link rel="stylesheet" href="css/datepicker.css" />
<link rel="stylesheet" href="css/style.css">

<link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script src="js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script type="text/javascript">
$(document).ready(function() {
	$('#validate1').on('submit', function (event) {
		event.preventDefault();
		if (validateForm() !== true){
			return false;
		}
		event.currentTarget.submit();
    });
	$('#validate2').on('submit', function (event) {
		event.preventDefault();
		if (validateForm() !== true){
			return false;
		}
		event.currentTarget.submit();
    });
});

jQuery(function($){
//	$("#date").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
	$("input[type=tel]").mask("999-999-9999");
	$("input[type=text].postalcode").mask("a9a 9a9");
	$("input[type=text].cc_number").mask("9999-9999-9999-9999");
	$("input[type=text].cc_month").mask("99");
	$("input[type=text].cc_year").mask("99");
	$("input[type=text].cc_ccv").mask("999");
});

    function validateForm() {
		var elems = document.getElementsByClassName("mandatory");
		var i;
		for (i=0; i<elems.length; i++){
			var p = elems[i].parentNode.querySelector("p");
			if (p){
				p = p.textContent;
			}
			else {
				p = elems[i].textContent;
			}
			if (elems[i] && (elems[i].value === "" || elems[i].value === "yyyy-mm-dd")) {
				alert("Please fill in the field: " + p + ": " + elems[i].name);
				elems[i].focus();
				return false;
			}
		}
		return true;
	}
	
$(document).ready(function() {
//alert(document.getElementById("site").offsetHeight);
	sendHeight();

	window.addEventListener('message', function(event) { 
		//alert(event.data);
	    	var rep = document.getElementById('start-repname-id');
	    	if (rep) {
				rep.value = event.data;
		    }
	});
});

function sendHeight(){
	height = $('#site').height();
	if (inIframe()) {
		window.parent.postMessage(height, "http://www.lafermeaunaturel.com");
	}
}

function inIframe() {
    try {
        return window.self !== window.top;
    } catch (e) {
        return true;
    }
}

function deleteAction(type, id) {

	if(confirm("Delete action cannot be reverted. Do you really want to do this?")) {
		var xmlhttp = new XMLHttpRequest();
	
	    xmlhttp.onreadystatechange = function() {
	        if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
	           if (xmlhttp.status == 200) {
	        	   alert(xmlhttp.responseText);
	               window.location.reload();
	           }
	           else if (xmlhttp.status == 400) {
	              alert('There was an error 400');
	           }
	           else {
	               alert('something else other than 200 was returned');
	           }
	        }
	    };
	
	    xmlhttp.open("GET", "actions/delete.php?" + type + "=" + id, true);
	    xmlhttp.send();
	}
	else {
		return false;
	}
}

function prefill1(){
	var ln = document.getElementById("prefillLastName").value;
	var fn = document.getElementById("prefillFirstName").value;
	var nff = document.getElementById("prefillNFF").value;

	document.getElementById("signedconsumer1").value = fn + " " + ln;
	prefill2();

	document.getElementById("cartCustomerName").innerHTML = fn + " " + ln + " (NFF: " + nff + ")";
}

function prefill2(){
	var ln = document.getElementById("prefillLastName2").value;
	var fn = document.getElementById("prefillFirstName2").value;

	if ((ln + "" + fn) === ""){
		document.getElementById("signedconsumersection2").style.display = "none";
	}
	else {
		document.getElementById("signedconsumersection2").style.display = "block";
	}
	
	document.getElementById("signedconsumer2").value = fn + " " + ln;
}
function fillDate(lThis) {
	document.getElementById("signeddate").value = lThis.value;
}
function fillAddress() {
	var ci = document.getElementById("city").value;
	var pr = document.getElementById("province").value;

	document.getElementById("signedaddress").value = ci + ", " + pr;
	prefill2();
}

function printDiv(divName) {
    var parentDiv = document.getElementById(divName);
	var modal = parentDiv.querySelector('.open');
	var printContents = modal.innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
    location.reload();
}

function printRawDiv(divName) {
    var modal = document.getElementById(divName);
	var printContents = document.getElementById(modal.id).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}

function changeView(hideId, showId) {
	document.getElementById(hideId).style.display = "none";
	$("#"+hideId).removeClass("open");
	document.getElementById(showId).style.display = "block";
	$("#"+showId).addClass("open");
}

function toggleMenu() {
	if (document.getElementById("content").classList.contains("expand-content"))
	{
		document.getElementById("content").classList.remove("expand-content");
		document.getElementById("sidebar").children[1].classList.remove("collapse-menu");
		document.getElementById("header").children[0].style.display = "block";
		createCookie("openmenu", "yes", 365);
	}
	else
	{
		document.getElementById("content").classList.add("expand-content");
		document.getElementById("sidebar").children[1].classList.add("collapse-menu");
		document.getElementById("header").children[0].style.display = "none";
		createCookie("openmenu", "no", 365);
	}
}

var createCookie = function(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    else {
        expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

function getCookie(c_name) {
    if (document.cookie.length > 0) {
        c_start = document.cookie.indexOf(c_name + "=");
        if (c_start != -1) {
            c_start = c_start + c_name.length + 1;
            c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1) {
                c_end = document.cookie.length;
            }
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return "";
}

function sendOrderEmail(id, name, email) {
	if(confirm("Are you sure you want to send an email to the customer containing the all his/her orders?")) {
		var xmlhttp = new XMLHttpRequest();
	
	    xmlhttp.onreadystatechange = function() {
	        if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
	           if (xmlhttp.status == 200) {
	        	   alert("Email successfully sent!");
	           }
	           else if (xmlhttp.status == 400) {
	              alert('There was an error 400');
	           }
	           else {
	               alert('something else other than 200 was returned');
	           }
	        }
	    };
	
	    xmlhttp.open("GET", "order/emailOrders.php?id="+id+"&email="+email+"&name="+name, true);
	    xmlhttp.send();
	}
	else {
		return false;
	}
}

function addEventToCalendar(name, date, ref, color){
	var eventObject = {
			title: name // use the element's text as the event title
		};
	
	// assign it the date that was reported
	eventObject.start = new Date(date);
	eventObject.url = ref;
	eventObject.backgroundColor = color;
		
	// render the event on the calendar
	// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
	$('#fullcalendar').fullCalendar('renderEvent', eventObject, true);
}

function contextMenu(e, lThis) {
	e.preventDefault();
	$(lThis.id + 'ctx').css("left",e.pageX);
	$(lThis.id + 'ctx').css("top",e.pageY);
	$(".cntnr").hide(100);        
	$(lThis.id + 'ctx').fadeIn(200,startFocusOut(lThis));
}

function hideContextMenu() {
	$(".cntnr").hide(100);
}

function startFocusOut(lThis){
  $(lThis).on("click",function(){
  	$(lThis.id + 'ctx').hide();        
  	$(lThis).off("click");
  });
}

function confirmOrder(pos, id) {
	var xmlhttp = new XMLHttpRequest();
	
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
           if (xmlhttp.status == 200) {
               var idPrefix = '';
               if (pos === 1)
            	   idPrefix = '#f';
               else if (pos === 2)
            	   idPrefix = '#s';
               else if (pos === 3)
            	   idPrefix = '#t';
               var elId = idPrefix + id;
               var el = document.getElementById(elId).querySelector('span');
        	   el.innerHTML = "(C)" + el.innerHTML.substring(3);
           }else {
               alert('There was an error');
           }
           hideContextMenu()
        }
    };

    xmlhttp.open("GET", "actions/orderStatusChange.php?id="+id+"&pos="+pos+"&status=confirm", true);
    xmlhttp.send();
}

function deliverOrder(pos, id) {
	var xmlhttp = new XMLHttpRequest();
	
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
           if (xmlhttp.status == 200) {
        	   var idPrefix = '';
               if (pos === 1)
            	   idPrefix = '#f';
               else if (pos === 2)
            	   idPrefix = '#s';
               else if (pos === 3)
            	   idPrefix = '#t';
               var elId = idPrefix + id;
               var el = document.getElementById(elId).querySelector('span');
        	   el.innerHTML = "(D)" + el.innerHTML.substring(3);
           }else {
               alert('There was an error');
           }
           hideContextMenu()
        }
    };

    xmlhttp.open("GET", "actions/orderStatusChange.php?id="+id+"&pos="+pos+"&status=deliver", true);
    xmlhttp.send();
}

jQuery(function($) {
	  jQuery('a[href*="#"]:not([href="#"])').click(function() {
	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
	      var target = $(this.hash);
	      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
	      if (target.length) {
	        jQuery('html, body').animate({
	          scrollTop: target.offset().top - 100
	        }, 800);
	        //return false;
	      }
	    }
	  });
	});

$(document).ready(function(){
	if (document.getElementById("breadcrumb")){
		document.getElementById("breadcrumb").innerHTML = '<a href="#" title="Toggle Menu" class="close-menu" onclick="toggleMenu()"><i class="icon-list"></i></a>' +  document.getElementById("breadcrumb").innerHTML
	}

	if (document.getElementById("content")){
		if (getCookie("openmenu") == "yes")
		{
			document.getElementById("content").classList.remove("expand-content");
			document.getElementById("sidebar").children[1].classList.remove("collapse-menu");
			document.getElementById("header").children[0].style.display = "block";
			createCookie("openmenu", "yes", 365);
		}
		else
		{
			document.getElementById("content").classList.add("expand-content");
			document.getElementById("sidebar").children[1].classList.add("collapse-menu");
			document.getElementById("header").children[0].style.display = "none";
			createCookie("openmenu", "no", 365);
		}
	}
});	
</script>

<?php 
if(file_exists('inc/config.php'))
	include 'inc/config.php';
if(file_exists('../inc/config.php'))
		include '../inc/config.php';

?>