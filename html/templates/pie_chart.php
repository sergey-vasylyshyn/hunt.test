<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/styles.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
<div class="main">
  <h1><a href="/">Link</a></h1>
  </br></br>

  <div id="piechart"></div>
</div>
<script type="text/javascript">
    // Load google charts
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    // Draw the chart and set the chart values
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Budget', 'Projects'],
            ['< 500', <?php echo $budgets[0]['budget_count']?>],
            ['500 - 1000', <?php echo $budgets[1]['budget_count']?>],
            ['1000-5000', <?php echo $budgets[2]['budget_count']?>],
            ['5000 >', <?php echo $budgets[3]['budget_count']?>]
        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'Project budget chart', 'width':550, 'height':400};

        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
</script>

</body>
</html>