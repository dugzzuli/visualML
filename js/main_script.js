$(function () {
	$('.dropdown-toggle').dropdown();
	$('#myTab a:first').tab('show');
	$('.pinpoint').hide();
	$('.mpara').hide();
	$('.modalDT').show();
	var rightModal = "modalDT";
	$(".toolbutton").click(function(){
		if($(this).hasClass('current')){
			$(this).removeClass('current');
			isPlot = false;
		}
		else{
			$(".toolbutton").removeClass('current');
			$(this).addClass('current');
			isPlot = true;
			svg.on("mousemove", null);
			console.log(isPlot);
		}
		if($('.current').hasClass('pinbutton')){
			plotOption = 1;
			$('.pinpoint').show();
		}
		else{
			$('.pinpoint').hide();
		}
		if($('.current').hasClass('pencilbutton')){
			plotOption = 2;
			console.log(plotOption);
		}
		if($('.current').hasClass('brushbutton')){
			plotOption = 3;
			cursorForPlot3();
		}
	});

	$(".clearbutton").click(function(){
		clearAllDataPoint();
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

	$("#classifyButton").click(function () {
			var url = "controllers/mainController.php";
			var postData = {};
			postData.Algorithm = "DecisionTree";
			postData.inputData = [];
			postData.minpts = 3;
			
			$('#plotPanel > circle').each(function () {
				//console.log(this);
				pos = $(this).attr("coordinate");
				pos = pos.substr(10);
				pos = pos.substr(0,pos.length-1);
				pos = pos.split(",");
				posx = pos[0];
				posy = pos[1];
				label = $(this).attr("data-label");
				data = {};
				data.x = posx;
				data.y = posy;
				data.label = label;
				data.predict = "U";
				postData.inputData.push(data);
			});
			console.log(postData);
			$.ajax({
				method: "POST",
				url: url,
				data: postData
			}).done(function (jsonReturnData) { 
				// Result handler
				console.log(jsonReturnData);
				// returnData = JSON.parse(jsonReturnData);
				// if (returnData.status == "error") {
				//  	alert("Error");
				// }
				// else{
				// 	console.log(returnData.result);
				// }
			});
		}
	);

	$("#sidebar .dropdown-submenu").click(function(){
		rightModal = $(this).data('modal');
		console.log(rightModal);
		$('.mpara').hide();
		$('.'+rightModal).show();
	});

	$("#setDefault").click(function(){
		//console.log(rightModal);
		//console.log($('.'+rightModal).children('input'));
		$.each($('.'+rightModal).children('input'),function(k,v){
			v.value=v.defaultValue;
		});
	});
})