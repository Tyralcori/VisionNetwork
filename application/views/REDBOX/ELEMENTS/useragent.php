<div id="useragents">
    <div class="container">
        Useragents:
        <br/><br/>
        <label>Week</label><br/>
        Most used:
        <br/>{$redbox.userAgent.week.HIGHEST.0.userAgent} in {$redbox.userAgent.week.HIGHEST.0.count} Times
        <br/><br/>
        Less used:
        <br/>{$redbox.userAgent.week.LOWEST.0.userAgent} in {$redbox.userAgent.week.LOWEST.0.count} Times
        
        <br/><br/>
        <label>All times</label><br/>
        Most used:
        <br/>{$redbox.userAgent.all.HIGHEST.0.userAgent} in {$redbox.userAgent.all.HIGHEST.0.count} Times
        <br/><br/>
        Less used:
        <br/>{$redbox.userAgent.all.LOWEST.0.userAgent} in {$redbox.userAgent.all.LOWEST.0.count} Times
    </div>
</div>