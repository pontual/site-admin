<!-- HEADER -->
<div data-role="header" data-position="fixed" data-tap-toggle="false" style="overflow: hidden;">
    
    <div data-role="navbar">
        <ul>
            <li>
                <a href="#menu" data-rel="panel" class="ui-btn-left ui-btn ui-btn-icon-left ui-icon-bars" onclick="$('body,html').animate({scrollTop:0},150);">Menu</a>
            </li>

            <li>
                <!-- SEARCH -->
                <form action="busca.php" method="GET" data-ajax="false">
                    <input name="q" id="search" value="" placeholder="Busca" type="search" data-mini="true">
                </form>
            </li>
        </ul>
    </div>
</div> <!-- END Header -->
