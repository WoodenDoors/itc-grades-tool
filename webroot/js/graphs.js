/*
 Created on : 10.01.13, 17:32
 Author     : mwegmann
 Description:
 */
var dataSlices;
var ticks;
var stylesheet="default";

$(document).ready(function(){
    var loadGradesGraph = function(){
        showRotator();

        json = jsonCallGrades();
        json.success(function(data) {

            // PARSE DATA
            dataSlices = [];
            ticks = [];
            $.each(data, function (entryindex, entry) {
                dataSlices.push(entry['Grade']);
                ticks.push(entry['Abbr']);
            });
            dataSlices.reverse();
            ticks.reverse();

            // STYLE
            var contentContainer = $("#content");
            var graphColors = ["#fada5b", "#FFE169" ];
            if(stylesheet == "metro") {
                contentContainer = $(".container.metro");
                graphColors = ["#2d89f0", "#4F1ACB" ];
            }

            // HEIGHT CALC
            var graphHeight = 50+dataSlices.length*40;
            var contentHeight =  contentContainer.height();
            if(graphHeight > contentHeight) graphHeight = contentHeight-10;
            $('#gradesGraph').css("height", graphHeight); // Dynamische Höhe

            // PLOT GRAPH
            $('#gradesGraph').jqplot([dataSlices], {
                    seriesColors: graphColors,
                    title: {
                        text: 'Noten',
                        fontSize: 16
                    },
                    animate: true,
                    seriesDefaults:{
                        renderer: $.jqplot.BarRenderer,
                        pointLabels: { show: true },
                        xaxis: 'x2axis',
                        rendererOptions: {
                            varyBarColor : true,
                            shadow: false,
                            barDirection: 'horizontal',
                            barMargin: 4
                        }
                    },
                    grid: {
                        borderWidth: 0,
                        background: 'transparent',
                        shadow: false
                    },
                    axes:{
                        yaxis:{
                            renderer: $.jqplot.CategoryAxisRenderer,
                            ticks: ticks,
                            showTickMarks: false,
                            tickOptions: {
                                showMark: false,
                                shadow: false,
                                showGridline: false
                            }
                        },
                        xaxis: {
                            tickOptions: {
                                showGridline: false,
                                showMark: false,
                                shadow: false
                            }
                        },
                        x2axis: {
                            max: 1.0,
                            min: 5.0,
                            numberTicks: 5,
                            tickOptions: {
                                showGridline: false,
                                showMark: false,
                                shadow: false,
                                formatString: "%.1f"
                            }
                        }
                    }
                }
            );
        })
            .error(function(ignore) {  })

        hideRotator();
    };

    var jsonCallGrades = function(){
        return $.getJSON('ajax/grades.json.php');
    }

    var jsonCallCredits = function(){
        return $.getJSON('ajax/grades.json.php?type=credits');
    }

    $.get('ajax/getStyle.php').complete(function(data) {
        stylesheet = data.responseText;
    });

    setTimeout(function() {
        loadGradesGraph();
    }, 500);

    $('#gradesGraph').bind('jqplotDataClick',
        function (ev, seriesIndex, pointIndex, data) {
            $('#gradesView tr.selectedCourse').removeClass("selectedCourse");

            gradesViewAbbr = $('#gradesView').find("td:contains("+ticks[data[1]-1]+")");
            if(stylesheet == "metro") {
                gradesViewAbbr = $('#gradesView').find("td[title="+ticks[data[1]-1]+"]");
            }

            gradesViewAbbr.parent().addClass("selectedCourse");
            //.html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
        }
    );
});