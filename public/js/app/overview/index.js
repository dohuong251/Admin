$( document ).ready(function() {

    var active_chart = new ApexCharts(document.querySelector('#visit_chart'), getOptionsChart(visitor_data,visitor_categories));
    visitor_chart.render();

    var new_user_chart = new ApexCharts(document.querySelector('#review_article_chart'), getOptionsChart(review_data,review_categories));
    review_chart.render();

});

function getOptionsChart($data,$categories) {
    var options = {
        chart: {
            type: 'area'
        },
        series: [
            {
                name: '',
                data: $data
            }
        ],
        colors:['#4366ED'],
        xaxis: {
            categories: $categories
        }
    }
    return options;
}
