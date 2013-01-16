/*
 Created on : 10.01.13, 17:32
 Author     : mwegmann
 Description:
 */

$(document).ready(function(){
    var loadGradesGraph = function(){
        showRotator();

        json = jsonCallGrades();
        json.success(function(data) {
            var dataSlices = [];
            var ticks = [];
            $.each(data, function (entryindex, entry) {
                dataSlices.push(entry['Grade']);
                ticks.push(entry['Abbr']);
            });

            $('#gradesGraph').css("height", (dataSlices.length*40)); // Dynamische Höhe

            $('#gradesGraph').jqplot([dataSlices], {
                    title: {
                        text: 'Noten',
                        fontSize: 16
                    },
                    seriesDefaults:{
                        renderer: $.jqplot.BarRenderer,
                        pointLabels: { show: true },
                        xaxis: 'x2axis',
                        rendererOptions: {
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

    setTimeout(function() {
        loadGradesGraph();
    }, 500);
});