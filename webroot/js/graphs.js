/*
 Created on : 10.01.13, 17:32
 Author     : mwegmann
 Description:
 */
var dataSlices;
var ticks;
$(document).ready(function(){
    var loadGradesGraph = function(){
        showRotator();

        json = jsonCallGrades();
        json.success(function(data) {
            dataSlices = [];
            ticks = [];
            $.each(data, function (entryindex, entry) {
                dataSlices.push(entry['Grade']);
                ticks.push(entry['Abbr']);
            });

            dataSlices.reverse();
            ticks.reverse();

            var graphHeight = dataSlices.length*40;
            var contentHeight =  $('#content').height();
            if(graphHeight > contentHeight) graphHeight = contentHeight-10;

            $('#gradesGraph').css("height", graphHeight); // Dynamische Höhe

            $('#gradesGraph').jqplot([dataSlices], {
                    seriesColors: ["#fada5b", "#FFE169" ],
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

    var loadCreditsGraph = function() {
        var s1 = [['a',6], ['b',8], ['c',14], ['d',20]];
        var s2 = [['a', 8], ['b', 12], ['c', 6], ['d', 9]];

        var json = jsonCallCredits();
        json.success(function(data) {
            var dataSlices = [];

            $.each(data, function (entryindex, entry) {
                dataSlices.push([entry['Abbr'], entry['Credits']]);
            });

            $('#gradesGraph').jqplot([dataSlices], {
                seriesDefaults: {
                    // make this a donut chart.
                    renderer:$.jqplot.DonutRenderer,
                    rendererOptions:{
                        // Donut's can be cut into slices like pies.
                        sliceMargin: 3,
                        // Pies and donuts can start at any arbitrary angle.
                        startAngle: -90,
                        showDataLabels: true,
                        // By default, data labels show the percentage of the donut/pie.
                        // You can show the data 'value' or data 'label' instead.
                        dataLabels: 'label'
                    }
                },
                grid: {
                    borderWidth: 0,
                    background: 'transparent',
                    shadow: false
                }
            });
        }).error(function(ignore) { })

        hideRotator();
    }

    var jsonCallGrades = function(type){
        return $.getJSON('ajax/grades.json.php');
    }

    var jsonCallCredits = function(type){
        return $.getJSON('ajax/grades.json.php?type=credits');
    }

    setTimeout(function() {
        loadGradesGraph();
    }, 500);

    $('#gradesGraph').bind('jqplotDataClick',
        function (ev, seriesIndex, pointIndex, data) {
            console.log(data);
            console.log(ticks[data[data[1]-1]]);
            $('#gradesView tr.selectedCourse').removeClass("selectedCourse");
            $('#gradesView').find("td:contains("+ticks[data[1]-1]+")").parent().addClass("selectedCourse");
            //.html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
        }
    );
});