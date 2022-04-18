<?php 

    include 'layout/header.php';

            if (isset($_GET['error'])) { ?>

                <div class="error">
                    <span class="closebtn" data-behaviour="showhide">&times;</span>
                    <?php echo $_GET['error']; ?>
                </div>

            <?php }
            if (isset($_GET['hint'])) {
                $hint = $_GET['hint'];
                if($hint === "logout"){ ?>
                    <div class="hint">
                        <span class="closebtn" data-behaviour="showhide">&times;</span>
                        Du hast die Warteschlange verlassen.
                    </div>
                <?php } 
                else if($hint === "new_user"){ ?>
                    <div class="hint">
                        <span class="closebtn" data-behaviour="showhide">&times;</span>
                        Du hast die Warteschlange betreten!
                    </div>
                <?php }
                else if($hint === "existing_user"){ ?>
                    <div class="hint">
                        <span class="closebtn" data-behaviour="showhide">&times;</span>
                        Willkommen zurück!
                    </div>
                <?php }
                else{ ?>
                    <div class="hint">
                        <span class="closebtn" data-behaviour="showhide">&times;</span>
                        <?php echo $hint ?>
                    </div>
                <?php }
            }

            require 'main.php';
            connectmysql();

            ?>
                <div class="reloadingpart" id="placeinlinereload">
            <?php

            if($current_status != "open"){
                if($current_status === "closedbefore"){
                    echo'<div class="closed_banner">
                        <p>Unsere Warteschlange ist zur Zeit geschlossen. Bitte versuch es später erneut!</p>
                    </div>';
                } else if($current_status === "maintenance"){
                    echo'<div class="status_banner">
                        <p>Wir haben aktuell technische Probleme. Es kann zu etwas längeren Wartezeiten kommen</p>
                    </div>';
                } else if($current_status === "closedbefore"){
                    echo'<div class="closed_banner">
                        <p>Die Warteschlange ist noch nicht geöffnet. Versuch es später erneut!</p>
                    </div>';
                } else if($current_status === "closedafter"){
                    echo'<div class="closed_banner">
                        <p>Die Warteschlange ist nicht mehr geöffnet!</p>
                    </div>';
                }
            }

            $guestid = checkforcookie();
            if($guestid === null){
                ?>

                <p>Solltest du einen neuen Platz in der Warteschlange benötigen, klicke hier:</p>
                <br>
                <p><a href="new_guest.php" class="button">Neuer Platz in der Warteschlange</a></p>
                <br>
                <br>
                <p>Solltest du bereits eine Gast-ID erhalten haben, gebe diese bitte hier ein und klicke dann den Button:</p>
                <br>
                <form method="post" action="existinguser.php">
                    <input type="text" name="guestid">
                    <input type="submit" value="Absenden" accesskey="s" name="submit">
                </form>

                <?php
            } else {
                ?>
                    <p>Deine ID: <kbd><?php echo $guestid;?> </kbd> | Deine Gruppe: <kbd><?php echo get_data_from_guest($guestid, "groupid");?> </kbd></p>
                    <p>Gruppen vor dir: </p>
                <?php
                if(get_data_from_guest($guestid, "groupid") > $current_group){
                    ?>

                    <div class="placeinline_wrap"> 
                        <div class="placeinline">
                            <?php echo (get_data_from_guest($guestid, "groupid")-$current_group); ?> 
                        </div>
                    </div>
                    <h3>Vorraussichtliche Eintrittszeit: <?php echo substr(get_data_from_group(get_data_from_guest($guestid, "groupid"), "time"), 0 ,-3); ?></h3>
                    <p><small><b>Tipp</b>: Mache einen Screenshot um deine ID nicht zu vergessen</small></p>

                    <?php
                } else if (get_data_from_guest($guestid, "groupid") == $current_group){
                    ?>
                    
                    <div class="placeinline_wrap finished"> 
                        <div class="placeinline">
                            <p>DU BIST AN DER REIHE!</p>
                            <p><small>(<?php echo get_data_from_guest($guestid, "guestcount");?> Personen)</small></p>
                        </div>
                    </div> 
                    <p><a href="feedback.php" class="button">ICH WAR IN DER SHOW</a></p>
                    
                    <?php
                } else {
                    ?>
                    <div class="placeinline_wrap toolate"> 
                        <div class="placeinline">
                            <p>Etwas lief schief. Melde dich am Eingang! (ERROR <?php echo get_data_from_guest($guestid, "groupid");?> >= <?php echo $current_group;?>)</p>
                        </div>
                    </div>
                    <?php
                }
                ?>
                    </div>
                    <p><a href="leavequeue.php" class="button">Aus der Warteschlange austreten</a></p>
                <?php
            }
            close_connection();
        include 'layout/footer.php';
    ?>


<script> 
document.addEventListener("DOMContentLoaded", function (event) {
    //Show hide
    let showHideElements = [...document.querySelectorAll('[data-behaviour="showhide"]')];

    showHideElements.forEach((element) => {
        element.addEventListener("click", (e) => {
            e.preventDefault();
            element.parentNode.classList.toggle("hidden")
        })
    });
});

$(document).ready(function(){
setInterval(function(){
      $("#placeinlinereload").load(location.href + " #placeinlinereload" );
}, 10000);
});
</script>
