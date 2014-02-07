<div id="views">
    <div class="container">
        VIEWS:
        <div style="width:600px;height:1000px;">
            <br/><br/><label>Visitcounter</label>
            <canvas id="visitCount" height="300" width="600"></canvas> 
            <br/><br/><label>Most called sites this week</label>
            <canvas id="siteCallsWeek" height="300" width="600"></canvas>             
            <br/><br/><label>Most called sites all times</label>
            <canvas id="siteCallsAll" height="300" width="600"></canvas> 
        </div>
    </div>
<script>

    var visitCount = {
        labels: ["Calls", "By user", "By IP"],
        datasets: [
            {
                fillColor: "rgba(220,220,220,0.5)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                data: [0,{$redbox.seo.userVisits.week.byUser.0.count}, {$redbox.seo.userVisits.week.byIP.0.count}]
            },
            {
                fillColor: "rgba(151,187,205,0.5)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "red",
                data: [0,{$redbox.seo.userVisits.all.byUser.0.count}, {$redbox.seo.userVisits.all.byIP.0.count}]
            }
        ]

    };

    new Chart(document.getElementById("visitCount").getContext("2d")).Line(visitCount);
    
    var siteCallsWeek = {
	labels : ["{$redbox.seo.sites.week.LOWEST.0.site}","{$redbox.seo.sites.week.HIGHEST.0.site}"],
        datasets: [
            {					
                fillColor : "rgba(220,220,220,0.5)",
                strokeColor : "rgba(220,220,220,1)",
		data : [{$redbox.seo.sites.week.LOWEST.0.count},{$redbox.seo.sites.week.HIGHEST.0.count}]
            },
            {
                fillColor : "rgba(151,187,205,0.5)",
		strokeColor : "rgba(151,187,205,1)",
		data : [{$redbox.seo.sites.week.LOWEST.0.count},{$redbox.seo.sites.week.HIGHEST.0.count}]
            }
	]
    };
    new Chart(document.getElementById("siteCallsWeek").getContext("2d")).Line(siteCallsWeek);
    
    var siteCallsAll = {
	labels : ["{$redbox.seo.sites.all.LOWEST.0.site}","{$redbox.seo.sites.all.HIGHEST.0.site}"],
        datasets: [
            {					
                fillColor : "rgba(220,220,220,0.5)",
                strokeColor : "rgba(220,220,220,1)",
		data : [{$redbox.seo.sites.all.LOWEST.0.count},{$redbox.seo.sites.all.HIGHEST.0.count}]
            },
            {
                fillColor : "rgba(151,187,205,0.5)",
		strokeColor : "rgba(151,187,205,1)",
		data : [{$redbox.seo.sites.all.LOWEST.0.count},{$redbox.seo.sites.all.HIGHEST.0.count}]
            }
	]
    };
    new Chart(document.getElementById("siteCallsAll").getContext("2d")).Line(siteCallsAll);
</script>
</div>