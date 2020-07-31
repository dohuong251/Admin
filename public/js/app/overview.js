$( document ).ready(function() {
    var active_chart = new ApexCharts(document.querySelector('#daily_active_user_chart'), getOptionsChart(active_count,filter_days));
    active_chart.render();

    var new_user_chart = new ApexCharts(document.querySelector('#daily_new_user_chart'), getOptionsChart(new_user_count,filter_days));
    new_user_chart.render();

    var country_chart = new ApexCharts(document.querySelector("#top_country_chart"), getOptionCountryChart());
    country_chart.render();

    var start = moment(start_date,'YYYY-MM-DD');
    var end = moment(end_date,'YYYY-MM-DD');

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

});

function cb(start, end) {
    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    $('.e-start-date').val(start.format('YYYY-MM-DD'));
    $('.e-end-date').val(end.format('YYYY-MM-DD'));

}

function getOptionCountryChart() {
    var options = {
        series: [{
            data: countries_percent
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: true,
            }
        },
        dataLabels: {
            enabled: true
        },
        xaxis: {
            labels:{
                show:false
            },
            categories: countries_name,
        }
    };
    return options;
}

function getOptionVersionChart() {

}

function getOptionsChart($data,$categories) {
    var options = {
        chart: {
            type: 'line'
        },
        series: [
            {
                name: '',
                data: $data
            }
        ],
        xaxis: {
            labels:{
                show:false
            },
            categories: $categories
        }
    }
    return options;
}
