<?php
    function getBanner(){
        ?>
        
            <div class="closed_banner" id="closedbefore_banner" style="visibility: hidden;">
                <p>Unsere Warteschlange ist zur Zeit geschlossen. Bitte versuch es später erneut!</p>
            </div>
            <div class="status_banner" id="maintenance_banner" style="visibility: hidden;">
                <p>Wir haben aktuell technische Probleme. Es kann zu etwas längeren Wartezeiten kommen</p>
            </div>
            <div class="status_banner" id="showclosed_banner" style="visibility: hidden;">
                <p>Die Show ist noch nicht geöffnet, aber die virtuelle Warteschlange ist bereits verfügbar!</p>
            </div>
            <div class="closed_banner" id="closedafter_banner" style="visibility: hidden;">
                <p>Die Warteschlange ist nicht mehr geöffnet!</p>
            </div>

        <?php
    }
?>
