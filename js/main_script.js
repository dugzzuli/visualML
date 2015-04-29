$(function () {
	$('.dropdown-toggle').dropdown();
	$('#myTab a:first').tab('show');
	$('.pinpoint').hide();
	$(".loader").hide();
	$('.mpara').hide();
	$('.modalDT').show();
	$('#placePoint').hide();
	var rightModal = "modalDT";
	$(".toolbutton").click(function(){
		if($(this).hasClass('current')){
			$(this).removeClass('current');
			isPlot = false;
			cursorForPlot();
		}
		else{
			$(".toolbutton").removeClass('current');
			$(this).addClass('current');
			isPlot = true;
			console.log(isPlot);
		}
		if($('.current').hasClass('pinbutton')){
			plotOption = 1;
			cursorForPlot();
			$("#tpx").val("");
			$("#tpy").val("");
			currentPointForPlot1 = null;
			$('.pinpoint').show();
		}
		else{
			$('.pinpoint').hide();
		}
		if($('.current').hasClass('pencilbutton')){
			plotOption = 2;
			cursorForPlot();
		}
		if($('.current').hasClass('brushbutton')){
			plotOption = 3;
			cursorForPlot();
		}
	});

	$(".undobutton").click(function(){
		undoPlotStep();
	});

	$(".clearbutton").click(function(){
		clearHistory();
		resetPlotPanel();
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
			$(".loader").show();
			var url = "controllers/mainController.php";
			var postData = {};
			postData.Algorithm = rightModal;
			if(rightModal=="modalDT"){
				postData.minpts = $('#modalDT1').val();
			}
			else if(rightModal=="modalKM"){
				postData.k = $('#modalKM1').val();
			}	
			else if(rightModal=="modalDB"){
				postData.eps = $('#modalDB1').val();
				postData.minPts = $('#modalDB2').val();
			}
			else if(rightModal=="modalLR"){
				//No Parameters
			}	
			else if(rightModal=="modalNB"){
				//No Parameters
			}	
			var jsonData = [];
			$('#plotPanel > circle.datadot').each(function () {
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
				jsonData.push(data);
			});
			postData.inputData = JSON.stringify(jsonData);
			console.log(postData);
			$.ajax({
				method: "POST",
				url: url,
				data: postData
			}).done(function (jsonReturnData) { 
				// Result handler
				console.log(jsonReturnData);
				returnData = JSON.parse(jsonReturnData);
				results = returnData.result.results;
				resultHTML = '<table class="table">';
				console.log(results);
				for(var key in results){
					console.log(key);
					resultHTML += '<tr>';
					resultHTML += '<td>';
					resultHTML += key;
					resultHTML += '</td>';
					resultHTML += '<td>';
					resultHTML += results[key];
					resultHTML += '</td>';
					resultHTML += '</tr>';
				}
				//resultHTML += '<tr><td></td><td></td></tr>';
				resultHTML += '</table>';
				var resultContent = $(resultHTML);
				$('#results').empty();
				$('#results').append(resultContent);
				clearHistory()
				//plot panel: show result
				if(rightModal=="modalDT"){
					DTResult(returnData.result.boundary, returnData.result.data);
				}
				else if(rightModal == "modalDB"){
					if(returnData.result.results["Total Clusters"] > 20){
						alert("Cannot show results, too many clusters.");
					}
					else{
						DBResult(returnData.result.clusters);
					}
				}
				else if(rightModal=="modalKM"){
					KMResult(returnData.result.belongs_to, returnData.result.centroids);
				}
				allToolbuttonOut();
				$(".loader").hide();	

			});
		}
	);

	$("#sidebar .dropdown-submenu").click(function(){
		rightModal = $(this).data('modal');
		console.log(rightModal);
		$('.mpara').hide();
		$('.'+rightModal).show();
		$('#selectClassPanel').show();
		if(rightModal=="modalKM" || rightModal=="modalDB" || rightModal=="modalLR" || rightModal=="modalRT"){
			$('#selectClassPanel').hide();
			isClassification = false;
			initialAlgoParameterAndData();
		}
		else{
			isClassification = true;
			initialAlgoParameterAndData();
		}

	});

	$("#setDefault").click(function(){
		//console.log(rightModal);
		//console.log($('.'+rightModal).children('input'));
		$.each($('.'+rightModal).children('input'),function(k,v){
			v.value=v.defaultValue;
		});
	});

	$('#addPoint').click(function(){
		$(this).hide();
		$('#placePoint').show();
		$('.pinpoint input').val('');
		plotOption1_addPoint = true;
	});

	$('#placePoint').click(function(){
		px = $('#tpx').val();
		py = $('#tpy').val();
		if(!isNaN(Number(px))&&!isNaN(Number(py))&&Number(px)>=0&&Number(px)<1000&&Number(py)>=0&&Number(py)<1000){
			px = Math.floor(px * 100) / 100;
			py = Math.floor(py * 100) / 100;
			addNewPointOption1Place(px, py)
			$('#tpx').val('');
			$('#tpy').val('');
			// $(this).hide();
			// $('#addPoint').show();
			// plotOption1_addPoint = false;
		}
		else{
			alert('ค่า x และ y ต้องน้อยกว่า 1,000 และไม่ติดลบ');
			$('#tpx').val('');
			$('#tpy').val('');
		}
		
	});
})

function changePlotOption1ToDefault(){
	plotOption1_addPoint = false;
	$('#placePoint').hide();
	$('#addPoint').show();
}

function allToolbuttonOut(){
	$(".toolbutton").removeClass('current');
	isPlot = false;
	cursorForPlot();
}

function updatePinPoint(x, y){
	$("#tpx").val(x.toFixed(2));
	$("#tpy").val(y.toFixed(2));
}
