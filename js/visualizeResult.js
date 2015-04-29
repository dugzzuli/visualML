function DTResult(boundary){
	var boundary_count = boundary.length;
	for(var i=0; i<boundary_count; i+=1){
		if(boundary[i][4] != null){
			drawBoundary(boundary[i][0], boundary[i][1], boundary[i][2], boundary[i][3], boundary[i][4]);
		}
	}
}