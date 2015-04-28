var isPlot = false;
var plotOption = 1;
var panelWidth = $("#board").width()-60;
var panelHeight = 500;
var paddingBottom = 30;
var paddingLeft = 40;
var paddingTop = 20;
var paddingRight = 20;

var selectedClass = null;

var maxX = 1000;
var maxY = 1000;

var dataSet = [];
var currentIndexOfData = 0;

var timer_drawpoint = 0;
var plot3_radius = 50;



// Create the SVG
var svg = d3.select("#board").append("svg")
.attr("width", panelWidth+paddingRight+paddingLeft)
.attr("height", panelHeight+paddingTop+paddingBottom)
.attr("id", "plotPanel")
.on("mousedown", mousedown)
.on("mouseup", mouseup)
.on("click", click);

// Add a background
svg.append("rect")
.attr("width", panelWidth+paddingRight+paddingLeft)
.attr("height", panelHeight+paddingTop+paddingBottom)
.style("stroke", "#000")
.style("fill", "#FFFFFF")

//define x scale
//Create the Scale we will use for the x Axis
var xScale = d3.scale.linear()
                    .domain([0, maxX])
                    .range([0, panelWidth]);

//Create the Axis
var xAxis = d3.svg.axis()
                .scale(xScale);


//Create an SVG group Element for the Axis elements and call the xAxis function
var xAxisGroup = svg.append("g")
                    .attr("class", "axis")
                    .attr("transform", "translate("+paddingLeft+"," + (paddingTop + panelHeight) + ")")
                    .call(xAxis);

//define y scale
//Create the Scale we will use for the y Axis
var yScale = d3.scale.linear()
                    .domain([maxY, 0])
                    .range([0, panelHeight]);
//Create the Axis
var yAxis = d3.svg.axis()
                .orient("left")
                .scale(yScale);

//Create Y axis
var yAxisGroup = svg.append("g")
                    .attr("class", "axis")
                    .attr("transform", "translate(" + paddingLeft + ","+paddingTop+")")
                    .call(yAxis);

//useful scale convert function
var pixelToDataScaleX = d3.scale.linear()
                    .domain([paddingLeft, paddingLeft+panelWidth])
                    .range([0, maxX]);

var DataToPixelScaleX = d3.scale.linear()
                    .domain([0, maxX])
                    .range([paddingLeft, paddingLeft+panelWidth]);

var pixelToDataScaleY = d3.scale.linear()
                    .domain([paddingTop, paddingTop+panelHeight])
                    .range([maxY, 0]);

var DataToPixelScaleY = d3.scale.linear()
                    .domain([0, maxY])
                    .range([paddingTop+panelHeight, paddingTop]);

function addNewPoint(p){
    var point = d3.mouse(p);
    var x = point[0];
    var y = point[1];
    if(x >= paddingLeft && x < paddingLeft+panelWidth && y > paddingTop && y <= paddingTop+panelHeight){
        console.log(x+", "+y+" => ("+pixelToDataScaleX(x)+", "+pixelToDataScaleY(y)+")");
        svg.append("circle")
                .attr("transform", "translate(" + x + "," + y + ")")
                .attr("coordinate", "translate(" + pixelToDataScaleX(x) + "," + pixelToDataScaleY(y) + ")")
                .attr("r", "5")
                .attr("class", "datadot dot label"+selectedClass)
                .attr("data-label",""+selectedClass)
                .style("cursor", "pointer")
                .call(drag);
    }
   
}

function addNewPointWithPosition(x, y){
    if(x >= paddingLeft && x < paddingLeft+panelWidth && y > paddingTop && y <= paddingTop+panelHeight){
        console.log(x+", "+y+" => ("+pixelToDataScaleX(x)+", "+pixelToDataScaleY(y)+")");
        svg.append("circle")
                .attr("transform", "translate(" + x + "," + y + ")")
                .attr("coordinate", "translate(" + pixelToDataScaleX(x) + "," + pixelToDataScaleY(y) + ")")
                .attr("r", "5")
                .attr("class", "datadot dot label"+selectedClass)
                .attr("data-label",""+selectedClass)
                .style("cursor", "pointer")
                .call(drag);
    }
}

function clearAllDataPoint(){
    svg.selectAll("circle").remove();
}

function click() {
    // Ignore the click event if it was suppressed
    if (d3.event.defaultPrevented) return;

    // Extract the click location    
    // var point = d3.mouse(this),
    // p = {
    //     x: point[0],
    //     y: point[1]
    // };
    if(isPlot){
        if (plotOption == 1) {
            if(selectedClass == null)   window.alert("Please select class");
            else{
                //plot a point
                // Append a new point
                addNewPoint(this);
                console.log(this);
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
                while(num_point < 10){
                    randx = (Math.random() * (plot3_radius * 2 + 1)) + (x - plot3_radius);
                    randy = (Math.random() * (plot3_radius * 2 + 1)) + (y - plot3_radius);
                    if(Math.pow((randx - x), 2) + Math.pow((randy - y), 2) <= plot3_radius*plot3_radius && randx >= paddingLeft && randx < paddingLeft+panelWidth && randy > paddingTop && randy <= paddingTop+panelHeight){
                        addNewPointWithPosition(randx,randy);
                        num_point += 1;
                    }
                    
                }
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
    console.log(x+", "+y+" => ("+pixelToDataScaleX(x)+", "+pixelToDataScaleY(y)+")");
}

var drawPointByDrag = null;

function mousedown(){
    var p = this;
    console.log("mousedown");
    if(isPlot && plotOption == 2){
        if(selectedClass == null)   window.alert("Please select class");
        else{
            timer_drawpoint = Date.now();
            svg.on("mousemove", mousemovePlot2);
        }
    }
}

function mousemovePlot2(){
    if(Date.now() - timer_drawpoint>=100){
        timer_drawpoint = Date.now();
        addNewPoint(this);
    }

}

function mouseup(){
    console.log("mouseup");
    if(isPlot && plotOption == 2){
        svg.on("mousemove", null);
        timer_drawpoint = 0;
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

