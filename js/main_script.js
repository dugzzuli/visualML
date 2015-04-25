$(function () {
	$('.dropdown-toggle').dropdown();
	$('#myTab a:last').tab('show');
	$('.pinpoint').hide();

	$(".toolbutton").click(function(){
		if($(this).hasClass('current')){
			$(this).removeClass('current');
			isPlot = false;
		}
		else{
			$(".toolbutton").removeClass('current');
			$(this).addClass('current');
			isPlot = true;
		}
		if($('.current').hasClass('pinbutton')){
			plotOption = 1;
			$('.pinpoint').show();
		}
		else{
			$('.pinpoint').hide();
		}
	});

	$(".aClass").click(function(){
		var changedText = $(this).text()+' ';
		var colorPoint = $('<i class="fa fa-circle" style="color:red;"></i>');
		selectedClass = "A";
		if($(this).hasClass('CB')){
			colorPoint = $('<i class="fa fa-circle" style="color:green;"></i>');
			selectedClass = "B";
		}
		else if($(this).hasClass('CC')){
			colorPoint = $('<i class="fa fa-circle" style="color:blue;"></i>');
			selectedClass = "C";
		}
		else if($(this).hasClass('CD')){
			colorPoint = $('<i class="fa fa-circle" style="color:orange;"></i>');
			selectedClass = "D";
		}
		else if($(this).hasClass('CE')){
			colorPoint = $('<i class="fa fa-circle" style="color:purple;"></i>');
			selectedClass = "E";
		}
		else if($(this).hasClass('CU')){
			colorPoint = $('<i class="fa fa-circle" style="color:grey;"></i>');
			selectedClass = "U";
		}
		$("#dropdownMenu2").text(changedText);
		$("#dropdownMenu2").prepend(colorPoint);
		var drop = $('<span class="caret"></span>');
		$("#dropdownMenu2").append(drop);
	});
})