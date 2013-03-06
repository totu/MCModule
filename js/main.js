function ggl() {
	$('#google').html('<input type="textbox" name="analytics" value="UA-XXXXX-X">');
}

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
		window.location = 'create.php';
	});
	
	$('.mo').mousedown(function() {
		var cid = $('#id' + $(this).attr('id')[$(this).attr('id').length-1]).val();
		var ct = $('#t' + $(this).attr('id')[$(this).attr('id').length-1]).val();
		$.cookie('cid', cid);
		$.cookie('ct', ct);
		if ($(this).attr('id')[$(this).attr('id').length-2] == 'm') window.location = "modify.php";
		if ($(this).attr('id')[$(this).attr('id').length-2] == 'd') {
			var r=confirm('Do you really want to delete "' + $.cookie('ct') + '" campaign? Forever!?');
			if (r) {
				window.location = "deleteAPI.php";
			}
		}
		if ($(this).attr('id')[$(this).attr('id').length-2] == 's') window.location = "statistic.php";
		if ($(this).attr('id')[$(this).attr('id').length-2] == 'n') {
			var r=confirm('Sure you want to send "' + $.cookie('ct') + '"?');
			if (r) {
				window.location = "sendAPI.php";
			}
		}
	});
	
	$('.explain, .sb, .hb').mouseover(function() {
		var top = $(this).offset().top+55, left = $(this).offset().left-22;
		switch ($(this).attr('class')) {
			case 'explain':
				var msg = 'Unique (Total)';
				break;
			case 'hb':
				var msg = 'Common reasons include: <b>"Account does not exist,"</b> and <b>"Domain does not exist."</b>';
				break;
			case 'sb':
				var msg = 'Common reasons include: <b>"User over quota,"</b> and <b>"Server temporarily unavailable."</b>';
				break;
		}
		$('#explain').css({'display':'block','left':left,'top':top}).html('<p style="text-align:center;font-size:15px;padding:13px 20px 5px;margin:0;">' + msg + '</p>').append('<div class="arrow-up"></div>')})
		.mouseout(function() {
			$('#explain').css('display','none');
	});
});