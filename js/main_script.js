$(function () {
	$('.dropdown-toggle').dropdown();
	$('#myTab a:first').tab('show');
	$('.pinpoint').hide();

	$(".toolbutton").click(function(){
		if($(this).hasClass('current')){
			$(this).removeClass('current');
		}
		else{
			$(".toolbutton").removeClass('current');
			$(this).addClass('current');
		}
		if($('.current').hasClass('pinbutton')){
			$('.pinpoint').show();
		}
		else{
			$('.pinpoint').hide();
		}
	});

	$(".aClass").click(function(){
		var changedText = $(this).text()+' ';
		var colorPoint = $('<i class="fa fa-circle" style="color:red;"></i>');
		if($(this).hasClass('CB')){
			colorPoint = $('<i class="fa fa-circle" style="color:green;"></i>');
		}
		else if($(this).hasClass('CC')){
			colorPoint = $('<i class="fa fa-circle" style="color:blue;"></i>');
		}
		else if($(this).hasClass('CD')){
			colorPoint = $('<i class="fa fa-circle" style="color:orange;"></i>');
		}
		else if($(this).hasClass('CE')){
			colorPoint = $('<i class="fa fa-circle" style="color:purple;"></i>');
		}
		else if($(this).hasClass('CU')){
			colorPoint = $('<i class="fa fa-circle" style="color:grey;"></i>');
		}
		$("#dropdownMenu2").text(changedText);
		$("#dropdownMenu2").prepend(colorPoint);
		var drop = $('<span class="caret"></span>');
		$("#dropdownMenu2").append(drop);
	});
})