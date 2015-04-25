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



// Create the SVG
var svg = d3.select("#board").append("svg")
.attr("width", panelWidth+paddingRight+paddingLeft)
.attr("height", panelHeight+paddingTop+paddingBottom)
//.on("mousedown", mousedown)
//.on("mouseup", mouseup)
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
                .attr("r", "5")
                .attr("class", "dot label"+selectedClass)
                .style("cursor", "pointer")
                .call(drag);
    }
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
        if(selectedClass == null)   window.alert("Please select class");
        else{
            if (plotOption == 1) {
                //plot a point
                // Append a new point
                addNewPoint(this);
                console.log(this);
            }
            else if(plotOption == 3){
                //plot point of line

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
    d3.select(this).attr("transform", "translate(" + x + "," + y + ")");
    console.log(x+", "+y+" => ("+pixelToDataScaleX(x)+", "+pixelToDataScaleY(y)+")");
}

var drawPointByDrag = null;

function mousedown(){
    var p = this;
    console.log("mousedown");
    if(isPlot && plotOption == 2){
        drawPointByDrag = setInterval(function(){ 
                                        console.log("plot");
                                        console.log(svg);
                                        addNewPoint(svg);
                                    }, 500);
    }
}

function mouseup(){
    console.log("mouseup");
    if(plotOption == 2){
        clearInterval(drawPointByDrag);
    }
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

