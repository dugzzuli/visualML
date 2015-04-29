function DTResult(boundary, datadot){

	resetPlotPanel();

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

function DBResult(data){
	resetPlotPanel();
	ClusteringResult(data);
}

function KMResult(data, centroids){
	resetPlotPanel();
	ClusteringResult(data);
	KMCentroid(centroids);
}

function KMCentroid(centroids){
	var centroids_count = centroids.length;
	for(var i=0; i < centroids_count; i+=1){
		var x = dataToPixelScaleX(centroids[i][0])-5;
		var y = dataToPixelScaleY(centroids[i][1])-5;
		svg.append("rect")
            .attr("class", "centroids runResult")
            .attr("x", x)
            .attr("y", y)
            .attr("width", 10)
            .attr("height", 10)
            .attr("fill", colorCollection(i));
	}
}

function ClusteringResult(data){
	var data_count = data.length;
	for(var i=0; i < data_count; i+=1){
		var x = dataToPixelScaleX(data[i].x);
	    var y = dataToPixelScaleY(data[i].y);
	    var fillColor = null;
	    if(data[i].predict == "U"){
	    	fillColor = "grey";
	    }
	    else{
	    	fillColor = colorCollection(data[i].predict);
	    }
        svg.append("circle")
            .attr("transform", "translate(" + x + "," + y + ")")
            .attr("coordinate", "translate(" + data[i].x + "," + data[i].y + ")")
            .attr("r", "5")
            .attr("fill", fillColor)
            .attr("class", "datadot dot")
            .attr("data-label",""+data[i].label)
            .style("cursor", "pointer")
            .style("stroke", "black");
    
	}

}