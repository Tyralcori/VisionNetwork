<div class="leftMenu" role="main">
    <div class="container">
        <label>Stationname:</label><br/>
        {$redbox.tech.current.server_getHostname}

        <br/><br/>

        <label>IPs:</label><br/>
        {assign var=ips value=","|explode:$redbox.tech.current.server_getIP}
        {foreach from=$ips item=ip}
        {assign var=ipSplit value="="|explode:$ip}
        {$ipSplit.0}: {$ipSplit.1}<br>
        {/foreach}

        <br/>

        <label>Cores:</label><br/>
        {foreach from=$redbox.tech.current.server_getLoadAVG item=core key=key}
        Core {$key+1} used {$core.0} ({$core.1}%)<br>
        {/foreach}

        <br/>

        <label>System:</label><br/>
        {$redbox.tech.current.server_getSystem}

        <br/><br/>

        <label>Uptime:</label><br/>
        {$redbox.tech.current.server_uptime|round:"2"} hours

        <br/><br/>

        <label>Server speed (online):</label><br/>
        {($redbox.tech.current.server_getSpeed/1024)|round:"2"} kb/s

        <br/><br/>

        <label>Memory:</label><br/>
        Memory: {$redbox.tech.current.server_getMemory.all} MB<br/>
        Used: {$redbox.tech.current.server_getMemory.used} MB<br/>
        Free: {$redbox.tech.current.server_getMemory.free} MB<br/>
    </div>
</div>
<div class="rightMenu" role="main">
    <!-- SIDE -->
    {include "REDBOX/ELEMENTS/sidebarTECH.php"}
    <!-- SIDE -->   
</div>