
var $j = jQuery.noConflict();

var http = createRequestObject();
var areal = Math.random() + "";
var real = areal.substring(2,6);

function createRequestObject() {
	var xmlhttp;
	try {
	var xmlhttp = null;if (window.XMLHttpRequest) { xmlhttp = new XMLHttpRequest();}else{  if (window.ActiveXObject) {     xmlhttp = new ActiveXObject('Msxml2.XMLHTTP');  } }

// xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
  catch(e) {
    try { 
    var xmlhttp = null;if (window.XMLHttpRequest) { xmlhttp = new XMLHttpRequest();}else{  if (window.ActiveXObject) {     xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');  } }
    	//xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch(f) { xmlhttp=null; }
  }
  if(!xmlhttp&&typeof XMLHttpRequest!="undefined") {
  	xmlhttp=new XMLHttpRequest();
  }
	return  xmlhttp;
}


function sendRequest() {
	
	var rnd = Math.random();
	var name = escape(document.getElementById("name").value);
	var email = escape(document.getElementById("email").value);
	var subject = escape(document.getElementById("subject").value);
	var body = document.getElementById("body").value;

	try{
    http.open('POST',  'php/contactform.php');
    http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = handleResponse;
		http.send('name='+name+'&email='+email+'&subject='+subject+'&body='+body+'&rnd='+rnd);
	}
	catch(e){}
	finally{
	jQuery('#contactform').slideUp("slow").hide();
	jQuery('#contactWrapper').append('<div class="success"><h4>Email Successfully Sent!</h4><br><p>Thank you for using our contact form <strong>'+name+'</strong>! Your email was successfully sent and we&#39;ll be in touch with you soon.</p></div>');
	}
}

function sendRequest_popup() {
	
	var rnd = Math.random();
	var name = escape(document.getElementById("name_popup").value);
	var email = escape(document.getElementById("email_popup").value);
	var subject = escape(document.getElementById("subject_popup").value);
	var body = escape(document.getElementById("body_popup").value);

	try{
    http.open('POST',  'php/contactform.php');
    http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = handleResponse_popup;
		http.send('name='+name+'&email='+email+'&subject='+subject+'&body='+body+'&rnd='+rnd);
	}
	catch(e){}
	finally{
	jQuery('#contactform_popup').slideUp("slow").hide();
	jQuery('#contactWrapper_popup').append('<div class="success"><h4>Email Successfully Sent!</h4><br><p>Thank you for using our contact form <strong>'+name+'</strong>! Your email was successfully sent and we&#39;ll be in touch with you soon.</p></div>');
	}
}


function sendRequest_news() {
	
	var rnd = Math.random();
	if(document.getElementById("name_news") instanceof Object){
	var name = escape(document.getElementById("name_news").value);}
	else{
	var name ='noname';	
	}
	var email = escape(document.getElementById("email_news").value);

	try{
    http.open('POST',  'php/newsletter.php');
    http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = handleResponse_news;

	http.send('name_news='+name+'&email_news='+email+'&rnd_news='+rnd);

	}
	catch(e){
	}
	finally{
	jQuery('#newsletterform').slideUp("slow").hide();
	jQuery('.intro-form-wrap').append('<div class="success"><h4>Subscription Successfully Sent!</h4><br><p>Thank you for using our newsletter, <strong>'+name+'</strong>! Your email has been registered.</p></div>');
	
	}
}


function validate_email(address) {
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   if(reg.test(address) == false) {
      return false;
   }
   else
   return true;
}

function validate_phone(phone){
	 var reg = /^[\:\-\.\_\(\) 0-9]+$/
        	if(reg.test(phone) == false) {
      return false;
   }
   else
   return true;
}

function check_values() {
	//Form
	var valid = '';

	
	var $j = jQuery.noConflict();
	
	var name = '';
	var email = '';
	var subject = '';
	var body = '';
	
	if(typeof $j('#contactform #name').val() != "undefined" )
	{
	 name = document.getElementById("name").value;
	}
	if(typeof $j('#contactform #email').val() != "undefined" )
	{
	 email = document.getElementById("email").value;
	}
	if(typeof $j('#contactform #subject').val() != "undefined" )
	{
	 subject = document.getElementById("subject").value;
	}
	if(typeof $j('#contactform #body').val() != "undefined" )
	{
	 body = document.getElementById("body").value;
	}

	
	var errors=0;
     if($j('#contactform #name').val()!=undefined)
	 if($j('#contactform #name').val()=='') {
	 	var hasClass=$j('#contactform #name').parent().find(".error").hasClass("error");
	 	if(!hasClass)
	 	    $j('#contactform #name').parent().append('<label for="contactname" generated="true" class="error">Please enter your name</label>');
			$j('#contactform #name').focus();
			//return false;
			errors++;
		}
		else
		$j('#contactform #name').parent().find(".error").remove();
		
		if($j('#contactform #email').val()!=undefined)
		if(validate_email($j('#contactform #email').val())==false ) {
		var hasClass=$j('#contactform #email').parent().find(".error").hasClass("error");
	 	if(!hasClass)
	 	    $j('#contactform #email').parent().append('<label for="contactname" generated="true" class="error">Please enter a valid email address</label>');	
			$j('#contactform #email').focus();
			//return false;
			errors++;
		}
		else
		$j('#contactform #email').parent().find(".error").remove();
		
		
		if($j('#contactform #subject').val()!=undefined)
		if($j('#contactform #subject').val()==''){
		var hasClass=$j('#contactform #subject').parent().find(".error").hasClass("error");
	 	if(!hasClass)
	 	    $j('#contactform #subject').parent().append('<label for="contactname" generated="true" class="error">You need to enter a subject!</label>');	
			$j('#contactform #subject').focus();
			//return false;
			errors++;
		}
		else
		$j('#contactform #subject').parent().find(".error").remove();
		
		if($j('#contactform #body').val()!=undefined)
		if($j('#contactform #body').val()==''){
		var hasClass=$j('#contactform #body').parent().find(".error").hasClass("error");
	 	if(!hasClass)
	 	    $j('#contactform #body').parent().append('<label for="contactname" generated="true" class="error">You need to enter a message!</label>');	
			$j('#contactform #body').focus();
			//return false;
			errors++;
		}
		else
		$j('#contactform #body').parent().find(".error").remove();
		
	

	if(errors==0) {
			document.getElementById("submit").disabled=true;
			document.getElementById("submit").value='Please Wait..';
			sendRequest();
	}
}

function check_values_popup() {
	//Form
	var valid = '';

	
	var $j = jQuery.noConflict();
	var name = document.getElementById("name_popup").value;
	var email = document.getElementById("email_popup").value;
	var subject = document.getElementById("subject_popup").value;
	var body = document.getElementById("body_popup").value;
	
	var errors=0;
     if($j('#contactform_popup #name_popup').val()!=undefined)
	 if($j('#contactform_popup #name_popup').val()=='') {
	 	var hasClass=$j('#contactform_popup #name_popup').parent().find(".error").hasClass("error");
	 	if(!hasClass)
	 	    $j('#contactform_popup #name_popup').parent().append('<label for="contactname" generated="true" class="error">Please enter your name</label>');
			$j('#contactform_popup #name_popup').focus();
			//return false;
			errors++;
		}
		else
		$j('#contactform_popup #name_popup').parent().find(".error").remove();
		
		if($j('#contactform_popup #email_popup').val()!=undefined)
		if(validate_email($j('#contactform_popup #email_popup').val())==false ) {
		var hasClass=$j('#contactform_popup #email_popup').parent().find(".error").hasClass("error");
	 	if(!hasClass)
	 	    $j('#contactform_popup #email_popup').parent().append('<label for="contactname" generated="true" class="error">Please enter a valid email address</label>');	
			$j('#contactform_popup #email_popup').focus();
			//return false;
			errors++;
		}
		else
		$j('#contactform_popup #email_popup').parent().find(".error").remove();
		
		
		if($j('#contactform_popup #subject').val()!=undefined)
		if($j('#contactform_popup #subject_popup').val()==''){
		var hasClass=$j('#contactform_popup #subject_popup').parent().find(".error").hasClass("error");
	 	if(!hasClass)
	 	    $j('#contactform_popup #subject_popup').parent().append('<label for="contactname" generated="true" class="error">You need to enter a subject!</label>');	
			$j('#contactform_popup #subject_popup').focus();
			//return false;
			errors++;
		}
		else
		$j('#contactform_popup #subject_popup').parent().find(".error").remove();
		
		if($j('#contactform_popup #body_popup').val()!=undefined)
		if($j('#contactform_popup #body_popup').val()==''){
		var hasClass=$j('#contactform_popup #body_popup').parent().find(".error").hasClass("error");
	 	if(!hasClass)
	 	    $j('#contactform_popup #body_popup').parent().append('<label for="contactname" generated="true" class="error">You need to enter a message!</label>');	
			$j('#contactform_popup #body_popup').focus();
			//return false;
			errors++;
		}
		else
		$j('#contactform_popup #body_popup').parent().find(".error").remove();
		
	

	if(errors==0) {
			document.getElementById("submit_popup").disabled=true;
			document.getElementById("submit_popup").value='Please Wait..';
			sendRequest_popup();
	}
}

function check_values_news() {
	//Form
	var valid = '';
	var $j = jQuery.noConflict();
	
	var name = '';
	var email = '';
	
	if(typeof $j('#newsletterform #name_news').val() != "undefined" )
	{
	 name = document.getElementById("name_news").value;
	 }
	 if(typeof $j('#newsletterform #email_news').val() != "undefined" )
	 {
	 email = document.getElementById("email_news").value;
	}

	var errors=0;
	
     if($j('#newsletterform #name_news').val()!=undefined)
	 if($j('#newsletterform #name_news').val()=='') {
	 	var hasClass=$j('#newsletterform #name_news').parent().find(".error").hasClass("error");
	 	if(!hasClass)
	 	    $j('#newsletterform #name_news').parent().append('<label for="contactname" generated="true" class="error">Please enter your name</label>');
			$j('#newsletterform #name_news').focus();
			//return false;
			errors++;
		}
		else
		$j('#newsletterform #name_news').parent().find(".error").remove();
		
		if($j('#newsletterform #email_news').val()!=undefined)
		if(validate_email($j('#newsletterform #email_news').val())==false ) {
		var hasClass=$j('#newsletterform #email_news').parent().find(".error").hasClass("error");
	 	if(!hasClass)
	 	    $j('#newsletterform #email_news').parent().append('<label for="contactname" generated="true" class="error">Please enter a valid email address</label>');	
			$j('#newsletterform #email_news').focus();
			//return false;
			errors++;
		}
		else
		$j('#newsletterform #email_news').parent().find(".error").remove();


	if(errors==0) {
			document.getElementById("submit").disabled=true;
			document.getElementById("submit").value='Please Wait..';
			sendRequest_news();
	}
}

function handleResponse() {
	try{
    if((http.readyState == 4)&&(http.status == 200)){
    	var response = http.responseText;
      document.getElementById("confirmation").innerHTML = response;
      document.getElementById("confirmation").style.display ="";
		}
  }
	catch(e){}
	finally{}
}
function handleResponse_popup() {
	try{
    if((http.readyState == 4)&&(http.status == 200)){
    	var response = http.responseText;
      document.getElementById("confirmation_popup").innerHTML = response;
      document.getElementById("confirmation_popup").style.display ="";
		}
  }
	catch(e){}
	finally{}
}

function handleResponse_news() {
	try{
    if((http.readyState == 4)&&(http.status == 200)){
    	var response = http.responseText;
      document.getElementById("confirmation").innerHTML = response;
      document.getElementById("confirmation").style.display ="";
		}
  }
	catch(e){}
	finally{}
}

function isUndefined(a) {
   return typeof a == 'undefined';
}

function trim(a) {
	return a.replace(/^s*(S*(s+S+)*)s*$/, "$1");
}

function isEmail(a) {
   return (a.indexOf(".") > 0) && (a.indexOf("@") > 0);
}


