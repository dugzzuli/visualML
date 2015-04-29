function DTResult(boundary, datadot){

	clearAllDataPoint();

	var boundary_count = boundary.length;
	for(var i=0; i < boundary_count; i+=1){
		if(boundary[i][4] != null){
			drawBoundary(boundary[i][0], boundary[i][1], boundary[i][2], boundary[i][3], boundary[i][4]);
		}
	}

	var data_count = datadot.length;
	for(var i=0; i < data_count; i+=1){
		DTPlotResultData(datadot[i]);
	}
}

function DTPlotResultData(data){
    var x = dataToPixelScaleX(data.x);
    var y = dataToPixelScaleY(data.y);
    var predictClassCSS = "";
    if(data.label == "U")	predictClassCSS += " unknownPredict"; 
    else if(data.label != data.predict)	predictClassCSS += " incorrectPredict";
    if(x >= paddingLeft && x < paddingLeft+panelWidth && y > paddingTop && y <= paddingTop+panelHeight){
        svg.append("circle")
            .attr("transform", "translate(" + x + "," + y + ")")
            .attr("coordinate", "translate(" + data.x + "," + data.y + ")")
            .attr("r", "5")
            .attr("fill", class_color[data.label])
            .attr("class", "datadot dot"+predictClassCSS)
            .attr("data-label",""+data.label)
            .style("cursor", "pointer")
            .style("stroke", class_color[data.predict]);
    }
}