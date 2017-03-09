$(document).ready(function () {
    var url = $( "#container" ).data( "url" );
    var options = {
        chart: {
            renderTo: 'container',
            type: 'spline'
        },
        series: [{}],
        title: {
            text: 'Visitors On Site This Year',
            x: -20 //center
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: 'Visitors'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },

    };

    var jqxhr = $.getJSON(url, function (data) {
        var d = new Date();
        var n = d.getFullYear();
        options.series[0].name = n;
        options.series[0].data = data;
        var chart = new Highcharts.Chart(options);
    });
    jqxhr.success(function() {
        document.getElementById("msg").innerHTML = "";
    });
    jqxhr.fail(function() {
        document.getElementById("msg").innerHTML = "Analytics EMPTY!";
        document.getElementById("msg").className = "label label-danger";
        document.getElementById("gaStats").className += " collapsed-box";
        document.getElementById("minus").className = "fa fa-plus";
    });

});

$(document).ready(function () {
    var url = $( "#container1" ).data( "url" );
    var options = {
        chart: {
            renderTo: 'container1',
            type: 'column'
        },
        series: [{}],
        title: {
            text: 'Visitors On Site This Month',
            x: -20 //center
        },
        yAxis: {
            title: {
                text: 'Visitors'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        xAxis: {
            tickInterval: 1,
            labels: {
                enabled: true,
                formatter: function() {
                    return this.value.toString().substring(0, 10);
                },
            }
        },


    };

    var jqxhr = $.getJSON(url, function (data) {
        var d = new Date();
        var month = new Array();
        month[0] = "Jan";
        month[1] = "Feb";
        month[2] = "Mar";
        month[3] = "Apr";
        month[4] = "May";
        month[5] = "Jun";
        month[6] = "Jul";
        month[7] = "Aug";
        month[8] = "Sep";
        month[9] = "Oct";
        month[10] = "Nov";
        month[11] = "Dec";
        console.log(data);
        var n = month[d.getMonth()];
        options.series[0].name = n;
        options.series[0].data = data;
        options.xAxis.categories=[];
        jQuery.each(data, function() {

            console.log(this[0]);
            options.xAxis.categories.push(this[0]);
        });
        var chart = new Highcharts.Chart(options);

    });
    jqxhr.success(function() {
        document.getElementById("msg").innerHTML = "";
    });
    jqxhr.fail(function() {
        document.getElementById("msg").innerHTML = "Analytics EMPTY!";
        document.getElementById("msg").className = "label label-danger";
        document.getElementById("gaStats").className += " collapsed-box";
        document.getElementById("minus").className = "fa fa-plus";
    });

});