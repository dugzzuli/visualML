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
			initialAlgoParameterAndData()
			$(this).addClass('current');
			isPlot = true;
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
			allToolbuttonOut();
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
			if(jsonData.length == 0){
				alert("Please plot at least a point of data");
				$(".loader").hide();
			}
			else{
				postData.inputData = JSON.stringify(jsonData);
				console.log(postData);
				$.ajax({
					method: "POST",
					url: url,
					data: postData
				}).done(function (jsonReturnData) { 
					// Result handler
					console.log(jsonReturnData);
					var returnData = JSON.parse(jsonReturnData);
					var results = returnData.result.results;
					var algo = returnData.result.results.Algorithm;
					var resultHTML = '<table class="table">';
					console.log(results);
					for(var key in results){
						console.log(key);
						resultHTML += '<tr>';
						resultHTML += '<td>';
						if(algo == "K-means" && key.indexOf("C") == 0){
							 var clusterIndex = key.substring(1,2);
							 resultHTML += '<i class="fa fa-square" style="color:'+colorCollection(clusterIndex - 1)+';"></i> ';
						}
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
						KMResult(returnData.result.data, returnData.result.centroids);
					}
					else if(rightModal == "modalLR"){
						LRResult(returnData.result.value.m, returnData.result.value.c);
						addLRTest();
					}
					else if(rightModal == "modalNB"){
						NBResult(returnData.result.data);
					}
					$(".loader").hide();
					activaTab('results');
				});
			}
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


	
});

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

function activaTab(tab){
    $('#myTab a[href="#' + tab + '"]').tab('show');
};

function addLRTest(){
	var htmlText = "<h4>Test:</h4>";
	htmlText += '<div class = "form-inline">';
	htmlText += '<div class="input-group col-md-4 col-md-offset-1">'+
				  	'<span class="input-group-addon" id="LRX">X</span>'+
				  	'<input type="text" name="LRX" id="LRInputX" class="form-control">'+
				'</div>';
	htmlText += '<div class="input-group col-md-4 col-md-offset-1">'+
				  	'<span class="input-group-addon" id="LRY">Y</span>'+
				  	'<input type="text" name="LRY" id="LRInputY" class="form-control" style="color:black;" disabled>'+
				'</div>';
	htmlText += '</div>';
	$('#results').append(htmlText);

	$('#LRInputX').keydown(function (e){
	    if(e.keyCode == 13){
	        var px = $('#LRInputX').val();
	        if(!isNaN(Number(px))){
	        	var py = computeLR(px);
	        	$('#LRInputY').val(py.toFixed(2));
	        }
	        else{
	        	alert("x must be a number");
	        }
	    }
	});
}
