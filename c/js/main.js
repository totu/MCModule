$(document).ready(function() {
	$('#c').mousedown(function() {
		window.location = "../c/";
	});
	$('#h').mousedown(function() {
		window.location = "..";
	});
	$('#l').mousedown(function() {
		window.location = "../l/";
	});
	$('#new_c').mousedown(function() {
		window.location = "./create.php";
	});
	$('.mo').mousedown(function() {
		var cid = $('#id' + $(this).attr('id')[$(this).attr('id').length-1]).val();
		$.cookie('cid', cid);
		if ($(this).attr('id')[$(this).attr('id').length-2] == 'm') window.location = "./modify.php";
		if ($(this).attr('id')[$(this).attr('id').length-2] == 'd') window.location = "./delete.php";
		if ($(this).attr('id')[$(this).attr('id').length-2] == 's') window.location = "./statistic.php";
	});
});
