
$(document).ready(
function ()
{
	
	$(document).on('click',"input[type=checkbox]",function (){
		//alert($(this).attr("class"));
		var de = $(this).attr("class");
		//Change color of row.
		if($(this).prop("checked")== true)
		{
			$(".edit").css("color","black");
			$("#"+de).css("color","red");
		}
		else 
		{
			$("#"+de).css("color","black");
		}
		
	});
	//End of checkbox click
	//Delete button clicked.
	
	  $(document).on('click',"#delete",function (){
	  	if(!checker()) return 0;
	  	if($("#display input[type=checkbox]:checked").length<1){
	  		//alert("No box is checked."); 
	  	$("#delete").css("color","red");
	  	return 0;}
	  	else
	  	{
	  		//alert("Success, a box is checked.");
	  		var de = [];
			$('input[type=checkbox]').each(function() {
   			if ($(this).is(":checked")) {
   				var xs = $(this).attr("class");
       		de.push(xs.slice(3,xs.length));
   			}
			});
			
			de = de.toString();
			var bc = $("input[name=tab]:checked").val();
			ajax("output","deleterow="+de+"&table="+bc+"&fr="+$('input[name="tab"]:checked').val());
		}
	  });
	//End of  Delete clicked.
	
	//Edit clicked.
	$(document).on('click',"#Edit",function ()
	{
		if(!checker()) return 0;
		//console.log($("#display input[type=checkbox]:checked").length);
	if($("#display input[type=checkbox]:checked").length<1){
	  		//alert("No box is checked."); 
	  	$("#Edit").css("color","red");
	  	return 0;}
	  	else
	  	{
	  		
			/* 
			$('input[type=checkbox]').each(function() {
   			if ($(this).is(":checked")) {
   				var xs = $(this).attr("class");
       		de.push(xs.slice(3,xs.length));
   			}
			});
			
			de = de.toString();
			var bc = $("input[name=tab]:checked").val();
			ajax("output","deleterow="+de+"&table="+bc+"&fr="+$('input[name="tab"]:checked').val());
			*/
			//console.log("Working before the loop statement it has "+$("#display tr").length+" rows");
			var de = [];
			var vals = [];
			for(i=1;i<$("#display tr").length;i++)
			{
				//var te = "";
				if($("#display tr:eq("+i+") input[type=checkbox]").is(":checked"))
				{
					//alert(i+" IS checked");
					var xs = $("#display tr:eq("+i+") input[type=checkbox]").attr("class");
       				de.push(xs.slice(3,xs.length));
       				var vs = [];
       				for(j=0;j<4;j++)
       				{
       				vs.push($("#display tr:eq("+i+") td:eq("+j+")").text());
       				}
       				vals.push(vs.join("?"));
				}
				
			}
			de = de.toString();
			vals = vals.toString();
			var xhttp = new XMLHttpRequest();
  		xhttp.onreadystatechange = function() {
				    if (xhttp.readyState == 4 && xhttp.status == 200) {
     	document.getElementById("output").innerHTML = xhttp.responseText;
    	}
  		};
  		xhttp.open("POST", "ajax.php", true);
  		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("id="+de+"&value="+vals+"&fr="+$("input[name=tab]:checked").val());
		
		//alert("id="+de+"&value="+vals+"&fr="+$("input[name=tab]:checked").val());
		}
		
	});
	//end onf edit clicked.
	
	
	//Function form submit:
	    function formsubmit(form, id)
	    {
			var fr = $('<form id = "tblfrm" method = "POST" ></form>');
			$("body").append(fr);
			fr.append('<input type = "hidden" name = "deleterow" value = "'+id+'"/> <input type = "hidden" name="table" value = "'+form+'"/>');
			fr.submit();
			
		}
	//End of function form submit:
	
	
	//Edit button clicked.
	
	  $("#Edit").click(function (){
	  	
	  	if(!$("input[type=checkbox]").prop("checked")){ 
	  	$("#Edit").css("color","red");
	  	return 0;}
	  });
	//End of  Edit clicked.
	//Selecting table.
	$('#selecin').click(function (){
		var inu = '<span>Income:</span><input type = "radio" name = "tab" value = "income" checked/>';
		var out = "<span>OutCome:</span> <input type = 'radio' name = 'tab'  value = 'outcome' />";
		$(this).html(inu);
		$('#selecout').html(out);
		$("#selecout").removeClass('selch');
		$("#selecin").addClass('selch');
		seltab();
	});
	$('#selecout').click(function (){
		var inu = '<span>Income:</span><input type = "radio" name = "tab" value = "income"/>';
		var out = "<span>OutCome:</span> <input type = 'radio'  name = 'tab'  value = 'outcome' checked/>";
		$('#selecin').html(inu);
		$(this).html(out);
		$("#selecin, #selecout").toggleClass('selch');
		$("#selecin").removeClass('selch');
		$("#selecout").addClass('selch');
		seltab();
	});
	function seltab(){
  		ajax("output","fr="+$('input[name="tab"]:checked').val());
	}
	//End of selecting.
	function ajax(out,par)
	{
		var xhttp = new XMLHttpRequest();
  		xhttp.onreadystatechange = function() {
  			if(out){
				    if (xhttp.readyState == 4 && xhttp.status == 200) {
     	document.getElementById(out).innerHTML = xhttp.responseText;
    	}
    	}
  		};
  		xhttp.open("GET", "ajax.php?"+par, true);
  		xhttp.send();
	}
	//Adding data.
	$('#buttonupdate').click(function (){
		
		if(!checker()) return 0;
		if(!$('input[name=amount]').val())
		{
			$('input[name=amount]').css('border','2px inset red');
			$('input[name=amount]').attr('placeholder','Required');
			return 0;
		}
		else 
		{
			var xhttp = new XMLHttpRequest();
  		xhttp.onreadystatechange = function() {
  			
				    if (xhttp.readyState == 4 && xhttp.status == 200) {
     	document.getElementById("output").innerHTML = xhttp.responseText;
    	}
  		};
  		xhttp.open("POST", "ajax.php", true);
  		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("amount="+$("input[name=amount]").val()+"&description="+$("textarea[name=description]").val()+"&fr="+$("input[name=tab]:checked").val());
		}
		//event.preventDefault();
	});
	//Check if a form is selected''
	function checker()
	{
		if(!$("input[name=tab]:checked").val())
		{
			alert("Kindly select a table to use.");
			return false;
		}
		else
		{
			return true;
		}
	}
	//Logout.
	$(".pwer").click(function (){
		var fr = $('<form action = "login.php" method = "POST" ></form>');
			$("body").append(fr);
			fr.append('<input type = "hidden" name="logout" value = "logout"/>');
			fr.submit();
	});
	//Default select.
	function def (){
		 
       	var xhttp = new XMLHttpRequest();
  		xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
     	document.getElementById("output").innerHTML = xhttp.responseText;
    	}
  		};
  		xhttp.open("GET", "ajax.php?fr=income",true);
  		xhttp.send();
		
	}
	
	def();
});
