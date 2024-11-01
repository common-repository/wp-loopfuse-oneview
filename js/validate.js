// JavaScript Document
function validateData()
 {
	var formName	=	document.getElementById('formname').value;
	var formId	    =	document.getElementById('formid').value;
	var formAction	=	document.getElementById('formaction').value;
	
	if(trim(formName) == ''){
		alert('Please enter Form Name.It cannot be left empty.');
		document.getElementById('formname').focus(); 
		return false;
	}
	if(trim(formId) == ''){
		alert('Please enter Form Id.It cannot be left empty.');
		document.getElementById('formid').focus(); 
		return false;
	}
	/*if(trim(formAction) == ''){
		alert('Please enter Form Action.It cannot be left empty.');
		document.getElementById('formaction').focus(); 
		return false;
	}
	return true;
 }*/

function trim(str)  {
   s = str.replace(/^(\s)*/, '');
    s = s.replace(/(\s)*$/, '');
    return s;
}
	 