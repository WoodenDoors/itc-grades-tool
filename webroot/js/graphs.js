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
            $('#gradesGraph').jqplot([dataSlices], {
                    title:'Noten',
                    seriesDefaults:{
                        renderer: $.jqplot.BarRenderer,
                        pointLabels: { show: true },
                        xaxis: 'x2axis',
                        rendererOptions: {
                            shadow: false,
                            barDirection: 'horizontal',
                            barPadding: 3,
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
                                shadow: false,
                                showGridline: false
                            }
                        },
                        xaxis: {
                            tickOptions: {
                                showGridline: false
                            }
                        },
                        x2axis: {
                            max: 1.0,
                            min: 5.0,
                            numberTicks: 5,
                            tickOptions: {
                                showGridline: false,
                                showMark: false,
                                shadow: false
                            }
                        }
                    }
                }
            );
        })
            .error(function(ignore) { alert("Deine Mamma!");  })

        hideRotator();
    };
    var jsonCallGrades = function(){
        return $.getJSON('ajax/grades.json.php');
    }

    setTimeout(function() {
        loadGradesGraph();
    }, 500);
});