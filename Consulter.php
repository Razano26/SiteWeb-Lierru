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
                ['Essence', 'Quantité']
                <?php
                    $query = $pdo->query("SELECT essence, count(essence) from Arbre GROUP by essence;");
                    $resultat = $query->fetchAll();

                    foreach ($resultat as $key => $variable){
                        echo(",['".$resultat[$key]['essence']."',".$resultat[$key]['count(essence)']."]");
                    }
                ?>
                ]);

                var options = {
                title: 'Proportion d\'arbre en fonction de leur essence ',
                backgroundColor:"transparent"
                };

                var chart = new google.visualization.PieChart(document.getElementById('ESSARB'));

                chart.draw(data, options);
            }
        </script>

        <script type="text/javascript">
            google.charts.load("current", {packages:["corechart"]});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Année', 'Quantité']
                <?php
                    $query = $pdo->query("SELECT annee_comptage, comptage_sanglier from compter;");
                    $resultat = $query->fetchAll();

                    foreach ($resultat as $key => $variable){
                        echo(",['".$resultat[$key]['annee_comptage']."',".$resultat[$key]['comptage_sanglier']."]");
                    }
                ?>
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1]);

            var options = {
                title: "Nombre de sangliers comptés par an",
                backgroundColor:"transparent",
                bar: {groupWidth: "95%"},
                legend: { position: "none" },
            };
            var chart = new google.visualization.BarChart(document.getElementById("SANGPANN"));
            chart.draw(view, options);
            }
        </script>

        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                ['Date', 'Temperature ']
                <?php
                    $query = $pdo->query("SELECT annee_mois, temp from relever_meteo, Donnees_externes where relever_meteo.id_meteo=Donnees_externes.id_meteo;");
                    $resultat = $query->fetchAll();

                    foreach ($resultat as $key => $variable){
                        echo(",['".$resultat[$key]['annee_mois']."',".$resultat[$key]['temp']."]");
                    }
                ?>
                ]);

                var options = {
                title: 'Temperature au cours du temps',
                curveType: 'function',
                backgroundColor:"transparent",
                legend: { position: 'bottom' }
                };

                var chart = new google.visualization.LineChart(document.getElementById('TEMP'));

                chart.draw(data, options);
            }
        </script>

        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                ['Date', 'Souffle en Km/h']
                <?php
                    $query = $pdo->query("SELECT annee_mois, vent from relever_meteo, Donnees_externes where relever_meteo.id_meteo=Donnees_externes.id_meteo;");
                    $resultat = $query->fetchAll();

                    foreach ($resultat as $key => $variable){
                        echo(",['".$resultat[$key]['annee_mois']."',".$resultat[$key]['vent']."]");
                    }
                ?>
                ]);

                var options = {
                title: 'Souffle au cours du temps',
                curveType: 'function',
                backgroundColor:"transparent",
                legend: { position: 'bottom' }
                };

                var chart = new google.visualization.LineChart(document.getElementById('VENT'));

                chart.draw(data, options);
            }
        </script>

        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                ['Date', 'Temperature']
                <?php
                    $query = $pdo->query("SELECT date_rel, temperature from Mesurer;");
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

        <script type="text/javascript">
            google.charts.load("current", {packages:["corechart"]});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Année', 'Quantité']
                <?php
                    $query = $pdo->query("SELECT periode,prelevement_sanglier FROM prelever ORDER BY periode;");
                    $resultat = $query->fetchAll();

                    foreach ($resultat as $key => $variable){
                        echo(",['".$resultat[$key]['periode']."',".$resultat[$key]['prelevement_sanglier']."]");
                    }
                ?>
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1]);

            var options = {
                title: "Nombre de sangliers comptés par an",
                backgroundColor:"transparent",
                bar: {groupWidth: "95%"},
                legend: { position: "none" },
            };
            var chart = new google.visualization.BarChart(document.getElementById("SANGPANN2"));
            chart.draw(view, options);
            }
        </script>


        <ul class="flex-container">
            <li class="flex-item"><div id="ESSARB" style="width: 600px; height: 400px;"></div></li>
            <li class="flex-item"><div id="SANGPANN" style="width: 600px; height: 400px;"></div></li>
            <li class="flex-item"><div id="TEMP" style="width: 600px; height: 400px;"></div></li>
            <li class="flex-item"><div id="VENT" style="width: 600px; height: 400px;"></div></li>
            <li class="flex-item"><iframe src="longgraph.php" width="600" height="400" ></iframe></li>
            <li class="flex-item"><div id="SANGPANN2" style="width: 600px; height: 400px;"></div></li>
        </ul>

    </body>
</html>