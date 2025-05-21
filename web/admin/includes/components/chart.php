<div class="chart-box">       
  <script type="text/javascript">
    google.load("visualization", "1.1", {packages:["bar"]});
    google.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([['Rock Altar Admin Data', 'Count'], 
        <?php 
          foreach (get_chart_data() as $key => $value) {
            echo "['{$key}', {$value}],";
          }
        ?>
      ]);

      var options = {
        chart: {
          title: '',
          subtitle: ''
        },
        legend: { position: "none" },
      };

      var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
      chart.draw(data, options);
    }
  </script>
                          
  <div id="columnchart_material"></div>   
</div>