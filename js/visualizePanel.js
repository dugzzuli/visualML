var panelWidth = $("#board").width()-60;
var panelHeight = 500;
var paddingBottom = 30;
var paddingLeft = 40;
var paddingTop = 20;
var paddingRight = 20;

var isClassification = true;
var selectedClass = "A";
var oldSelectedClass = "A";

var maxX = 1000;
var maxY = 1000;

var isPlot = false;
var plotOption = 1;
var plotOption1_addPoint = false;
var timer_drawpoint = 0;
var plot3_radius = 50;

var class_label = ["A", "B", "C", "D", "E"];
var class_color = {"A":"red", "B":"green", "C":"blue", "D":"orange", "E":"purple", "U":"grey"};

var historyForUndo = [];
var historyTemp = [];

var colorCollection = d3.scale.category20(); 

// Create the SVG
var svg = d3.select("#board").append("svg")
            .attr("width", panelWidth+paddingRight+paddingLeft)
            .attr("height", panelHeight+paddingTop+paddingBottom)
            .attr("id", "plotPanel")
            .on("mousedown", mousedown)
            .on("mouseup", mouseup)
            .on("click", click);

//define x scale
//Create the Scale we will use for the x Axis
var xScale = d3.scale.linear()
                    .domain([0, maxX])
                    .range([0, panelWidth]);
var xAxis = d3.svg.axis()
                .scale(xScale);


//define y scale
//Create the Scale we will use for the y Axis
var yScale = d3.scale.linear()
                    .domain([maxY, 0])
                    .range([0, panelHeight]);
var yAxis = d3.svg.axis()
                .orient("left")
                .scale(yScale);

initialPlotPanel();


//useful scale convert function
var pixelToDataScaleX = d3.scale.linear()
                    .domain([paddingLeft, paddingLeft+panelWidth])
                    .range([0, maxX]);

var dataToPixelScaleX = d3.scale.linear()
                    .domain([0, maxX])
                    .range([paddingLeft, paddingLeft+panelWidth]);

var pixelToDataScaleY = d3.scale.linear()
                    .domain([paddingTop, paddingTop+panelHeight])
                    .range([maxY, 0]);

var dataToPixelScaleY = d3.scale.linear()
                    .domain([0, maxY])
                    .range([paddingTop+panelHeight, paddingTop]);


function initialPlotPanel(){
    // Add a background
    svg.append("rect")
        .attr("width", panelWidth+paddingRight+paddingLeft)
        .attr("height", panelHeight+paddingTop+paddingBottom)
        .style("stroke", "#000")
        .style("fill", "#FFFFFF")

    //Create an SVG group Element for the Axis elements and call the xAxis function
    var xAxisGroup = svg.append("g")
                    .attr("class", "axis")
                    .attr("transform", "translate("+paddingLeft+"," + (paddingTop + panelHeight) + ")")
                    .call(xAxis);

    //Create Y axis
    var yAxisGroup = svg.append("g")
                    .attr("class", "axis")
                    .attr("transform", "translate(" + paddingLeft + ","+paddingTop+")")
                    .call(yAxis);
}


function initialAlgoParameterAndData(){
    if(isClassification){
        selectedClass = oldSelectedClass;
    }
    else{
        selectedClass = "U";
    }
    adjustScreenForAlgoChange();
}

function adjustScreenForAlgoChange(){
    clearResult();
    if(isClassification){
        svg.selectAll("circle.datadot")
            .attr("fill", function(){
                return class_color[d3.select(this).attr("data-label")];
            })
            .attr("class", "datadot dot")
            .style("stroke", "black");
    }
    else{
        svg.selectAll("circle.datadot")
            .attr("fill", class_color[selectedClass])
            .attr("class", "datadot dot")
            .style("stroke", "black");
    }
    
}

function addNewPoint(p){
    var point = d3.mouse(p);
    var x = point[0];
    var y = point[1];
    return addNewPointWithPosition(x, y);
}

function addNewPointWithPositionScale(x, y){
    return addNewPointWithPosition(dataToPixelScaleX(x), dataToPixelScaleY(y));    
}

function addNewPointWithPosition(x, y){
    if(x >= paddingLeft && x < paddingLeft+panelWidth && y > paddingTop && y <= paddingTop+panelHeight){
        if(plotOption == 1) updatePinPoint(pixelToDataScaleX(x), pixelToDataScaleY(y));
        var newPoint = svg.append("circle")
                .attr("transform", "translate(" + x + "," + y + ")")
                .attr("coordinate", "translate(" + pixelToDataScaleX(x) + "," + pixelToDataScaleY(y) + ")")
                .attr("r", "5")
                .attr("fill", class_color[selectedClass])
                .attr("class", "datadot dot")
                .attr("data-label",""+selectedClass)
                .style("cursor", "pointer")
                .call(drag);
        return newPoint;
    }
}

function addNewPointOption1Place(x, y){
    var newPoint = addNewPointWithPositionScale(x, y);
    historyTemp = [newPoint];
    historyForUndo.push(historyTemp);
}

function clearResult(){
    svg.selectAll(".runResult").remove();
}

function resetPlotPanel(){
    svg.selectAll("*").remove();
    initialPlotPanel();
}

function clearAllDataPoint(){
    svg.selectAll("circle.datadot").remove();
}

// History

function undoPlotStep(){
    if(historyForUndo.length > 0){
        var stepPoints = historyForUndo[historyForUndo.length-1];
        for(var i = 0 ; i < stepPoints.length ; i+=1 ){
            stepPoints[i].remove();
        } 
        historyForUndo.pop();
    }
}

function clearHistory(){
    historyForUndo = [];
}

function drawBoundary(x1, x2, y1, y2, label){
    if( x1 < x2 && y1 < y2){
        px1 = Math.floor(dataToPixelScaleX(x1));
        px2 = Math.floor(dataToPixelScaleX(x2));
        py1 = Math.floor(dataToPixelScaleY(y1));
        py2 = Math.floor(dataToPixelScaleY(y2));
        svg.append("rect")
            .attr("class", "boundary runResult")
            .attr("x", px1)
            .attr("y", py2)
            .attr("width", px2 - px1)
            .attr("height", py1 - py2)
            .attr("fill", class_color[label]);
    }
}

function click() {
    // Ignore the click event if it was suppressed
    if (d3.event.defaultPrevented) return;
    if(isPlot){
        if (plotOption == 1) {
            if(selectedClass == null)   window.alert("Please select class");
            else{
                //plot a point
                // Append a new point
                var newPoint = addNewPoint(this);
                if(plotOption1_addPoint)    changePlotOption1ToDefault();
                historyTemp = [newPoint];
                historyForUndo.push(historyTemp);
            }
        }
        else if(plotOption == 3){
            //plot random point in range
            if(selectedClass == null)   window.alert("Please select class");
            else{
                var point = d3.mouse(this);
                var x = point[0];
                var y = point[1];
                num_point = 0;
                historyTemp = [];
                var numPoint = readNumPoint_Plot3();
                while(num_point < numPoint){
                    randx = (Math.random() * (plot3_radius * 2 + 1)) + (x - plot3_radius);
                    randy = (Math.random() * (plot3_radius * 2 + 1)) + (y - plot3_radius);
                    if(Math.pow((randx - x), 2) + Math.pow((randy - y), 2) <= plot3_radius*plot3_radius && randx >= paddingLeft && randx < paddingLeft+panelWidth && randy > paddingTop && randy <= paddingTop+panelHeight){
                        historyTemp.push(addNewPointWithPosition(randx,randy));
                        num_point += 1;
                    }
                    
                }
                historyForUndo.push(historyTemp);
            }
        }
    }
}

// Define drag behavior
var drag = d3.behavior.drag().on("drag", dragmove);

function dragmove(d) {
    var x = d3.event.x;
    var y = d3.event.y;
    if(x < paddingLeft) x = paddingLeft;
    if(x >= paddingLeft + panelWidth)    x = paddingLeft + panelWidth - 0.007;
    if(y < paddingTop)  y = paddingTop + 0.004;
    if(y >= paddingTop + panelHeight)    y = paddingTop + panelHeight;
    d3.select(this).attr("transform", "translate(" + x + "," + y + ")")
                    .attr("coordinate", "translate(" + pixelToDataScaleX(x) + "," + pixelToDataScaleY(y) + ")");
    updatePinPoint(pixelToDataScaleX(x), pixelToDataScaleY(y));
    if(plotOption1_addPoint)    changePlotOption1ToDefault();
}

var drawPointByDrag = null;

function mousedown(){
    var p = this;
    if(isPlot && plotOption == 2){
        if(selectedClass == null)   window.alert("Please select class");
        else{
            timer_drawpoint = Date.now();
            historyTemp = [];
            svg.on("mousemove", mousemovePlot2);
        }
    }
}

function mousemovePlot2(){
    if(Date.now() - timer_drawpoint>=100){
        timer_drawpoint = Date.now();
        historyTemp.push(addNewPoint(this));
    }

}

function mouseup(){
    if(isPlot && plotOption == 2){
        svg.on("mousemove", null);
        timer_drawpoint = 0;
        if(historyTemp.length>0)    historyForUndo.push(historyTemp);
    }   
}

function cursorForPlot(){
    svg.select("#circleRandomPlot").remove();
    svg.on("mousemove", null);
    svg.on("mouseout", null);
    svg.style("cursor","default");
    if(isPlot){
        svg.style("cursor","crosshair");
        if(plotOption == 3){
            svg.append("circle")
                .attr("transform", "translate(" + 0 + "," + 0 + ")")
                .attr("r", ""+plot3_radius)
                .attr("id","circleRandomPlot")
            svg.on("mousemove", mousemove_circle);
        }
    }
}

function mousemove_circle(){
    var point = d3.mouse(this);
    var x = point[0];
    var y = point[1];
    svg.select("#circleRandomPlot").attr("transform", "translate(" + x + "," + y + ")");
}

function update_mousemove_circle(radius){
    plot3_radius = radius;
    svg.select("#circleRandomPlot").attr("r", ""+plot3_radius);
}

$('#option #class1').click(function(){
    selectedClass = "A";
});

$('#option #class2').click(function(){
    selectedClass = "B";
});

$('#option #plot1').click(function(){
    plotOption = 1;
});

$('#option #plot2').click(function(){
    plotOption = 2;
});

