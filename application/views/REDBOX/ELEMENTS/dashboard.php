<div id="dash">
    <div class="container">
        DASHBOARD
        
        <br/><br/><label>Timeload</label>
        <div style="width:600px;height:300px;">
            <canvas id="timeLoad" height="300" width="600"></canvas>
        </div>
    </div>

    <script>

        var timeLoad = {
        labels: ["AVG", "LOWEST", "HIGHEST"],
                datasets: [
                    {
                    fillColor: "rgba(220,220,220,0.5)",
                            strokeColor: "rgba(220,220,220,1)",
                            pointColor: "rgba(220,220,220,1)",
                            pointStrokeColor: "#fff",
                            data: [{$redbox.seo.timeLoad.week.LOWEST.0.timeLoad}, {$redbox.seo.timeLoad.week.AVG.0.timeLoad}, {$redbox.seo.timeLoad.week.HIGHEST.0.timeLoad}]
                    },
                    {
                    fillColor: "rgba(151,187,205,0.5)",
                            strokeColor: "rgba(151,187,205,1)",
                            pointColor: "rgba(151,187,205,1)",
                            pointStrokeColor: "red",
                            data: [{$redbox.seo.timeLoad.all.LOWEST.0.timeLoad}, {$redbox.seo.timeLoad.all.AVG.0.timeLoad}, {$redbox.seo.timeLoad.all.HIGHEST.0.timeLoad}]
                    }
                ]
        };

        new Chart(document.getElementById("timeLoad").getContext("2d")).Line(timeLoad);
                
    </script>
</div>