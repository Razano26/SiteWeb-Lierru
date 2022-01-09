<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style/stylepage.css">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <link rel="stylesheet" href="style/consstyle.css">
        <title>new</title>
    </head>
    <body>
        <?php
            $dsn = 'mysql:host=localhost;dbname=PS3_V2;port=3306;charset=utf8mb4';
            $pdo = new PDO($dsn, 'root' , 'stidps3'); 
        ?>
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                ['Date', 'Temperature']
                <?php
                    $query = $pdo->query("SELECT date_rel, temperature from Mesurer order by date_rel;");
                    $resultat = $query->fetchAll();

                    foreach ($resultat as $key => $variable){
                        echo(",['".$resultat[$key]['date_rel']."',".$resultat[$key]['temperature']."]");
                    }
                ?>
                ]);

                var options = {
                title: 'Temperature au cours du temps',
                curveType: 'function',
                backgroundColor:"transparent",
                legend: { position: 'bottom' }
                };

                var chart = new google.visualization.LineChart(document.getElementById('TEMPL'));

                chart.draw(data, options);
            }
        </script>

        <div id="TEMPL" style="width: 2000px; height: 400px;"></div>
    </body>
</html>