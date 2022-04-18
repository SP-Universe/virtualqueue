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

            $guestid = checkforcookie();
            $guestgroup = get_data_from_guest($guestid, "groupid");

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
                $guestcount = get_data_from_guest($guestid, "guestcount");
                ?>
                    <p>Deine ID: <kbd><?php echo $guestid;?></kbd> | Gruppe: <kbd><?php echo $guestgroup;?> </kbd></p>
                    <p>Du hast dich mit <?php echo $guestcount; if($guestcount > 1){echo ' Personen';}else{echo ' Person';}?> angestellt</p>
                    
                <?php
                if(get_data_from_guest($guestid, "groupid") > $current_group){
                    ?>
                    <p>Gruppen vor dir: </p>
                    <div class="placeinline_wrap"> 
                        <div class="placeinline">
                            <?php echo (get_data_from_guest($guestid, "groupid")-$current_group); ?> 
                        </div>
                    </div>
                    <h3>Vorraussichtliche Eintrittszeit: <?php echo substr(get_data_from_group(get_data_from_guest($guestid, "groupid"), "time"), 0 ,-3); ?></h3>

                    <p><a href="leavequeue.php" class="button">Aus der Warteschlange austreten</a></p>

                    <?php
                } else if (get_data_from_guest($guestid, "groupid") == $current_group){
                    
                    ?>
                    
                    <div class="placeinline_wrap finished"> 
                        <div class="placeinline">
                            <p>DU BIST AN DER REIHE!</p>
                            <p><small>(<?php echo get_data_from_guest($guestid, "guestcount");?> Personen)</small></p>
                        </div>
                    </div>

                    <p><a href="leavequeue.php" class="button">Aus der Warteschlange austreten</a></p>
                    
                    <?php
                } else {
                    ?>

                    <div class="placeinline_wrap toolate"> 
                        <div class="placeinline">
                            <h3>VIELEN DANK FÜR DEINEN BESUCH!</h3>
                            <p>Wir würden uns sehr über eine Spende in den Spendenschädel und eine Bewertung freuen:</p>
                            <a href="feedback.php" class="button">SHOW BEWERTEN</a>
                            <div class="socials">
                                <a href="https://www.instagram.com/halloweenhaus.schmalenbeck/"><img class="title_image" src="images/logo_instagram.png" alt="Instagram"></a>
                                <a href="https://www.youtube.com/channel/UCmtPYNrj6xp-ed77zzSzUIQ"><img class="title_image" src="images/logo_youtube.png" alt="Youtube"></a>
                            </div>
                        </div>
                    </div>
                    <a href="leavequeue.php" class="button">Zur Startseite</a>

                    <?php
                }
                ?>
                    </div>
                    
                <?php
            }
            close_connection();
        include 'layout/footer.php';
    ?>


<script> 
var audioplayed = false;
var guestgroup;
var currentgroup;

document.addEventListener("DOMContentLoaded", function (event) {
    //Show hide
    let showHideElements = [...document.querySelectorAll('[data-behaviour="showhide"]')];

    showHideElements.forEach((element) => {
        element.addEventListener("click", (e) => {
            e.preventDefault();
            element.parentNode.classList.toggle("hidden")
        })
    });

    currentgroup = "<?php echo"$current_group";?>";
    guestgroup = "<?php echo "$guestgroup";?>";
});

$(document).ready(function(){
setInterval(function(){
    $("#placeinlinereload").load(location.href + " #placeinlinereload" );
    
    currentgroup = "<?php echo"$current_group";?>";
    if(guestgroup == currentgroup){
        if(!audioplayed){
            console.log("Hello world!");
            var audio = new Audio('sound/laugh.wav');
            audio.muted = false;
            audio.play();
            audioplayed = true;
        }
    }
}, 10000);
});
</script>
