$(document).ready(function(){

	//on click signup, hide login and show registration form
	$("#signup").click(function(){
		$("#first").slideUp("slow",function(){
			$("#second").slideDown("slow");
		});
	});

	$("#signin").click(function(){
		$("#second").slideUp("slow",function(){
			$("#first").slideDown("slow");
		});
	});

});