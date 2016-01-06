$(document).ready(function() {
	$("#menu").click(function() {
		if ( $("nav").css("display") === "none" ) {
			$("nav").show();
		} else{
			$("nav").hide();
		}
	});
});