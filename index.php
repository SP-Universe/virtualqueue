<?php 
    require 'layout/header.php';
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
            if($guestid === null){
                ?>

                <p>Klicke hier, um der virtuellen Warteschlange beizutreten:</p>
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
                    <p>Deine ID: <kbd><?php echo $guestid;?></kbd> | Gruppe: <kbd id="groupid"><?php echo $guestgroup;?> </kbd></p>
                    <p>Du hast dich mit <?php echo $guestcount; if($guestcount > 1){echo ' Personen';}else{echo ' Person';}?> angestellt</p>
                    
                <div class="placeinline_block" id="placeinline_before" style="visibility: hidden;">
                    <p>Gruppen vor dir: </p>
                    <div class="placeinline_wrap"> 
                        <div class="placeinline">
                            <p class="placeinline_number" id="placeinline_number">1</p> 
                        </div>
                    </div>
                    <h3 id="estimated_time">(OLD)Vorraussichtliche Eintrittszeit: <?php echo substr(get_data_from_group(get_data_from_guest($guestid, "groupid"), "time"), 0 ,-3); ?></h3>

                    <p><a href="leavequeue.php" class="button">Aus der Warteschlange austreten</a></p>

                </div>
                <div class="placeinline_block" id="placeinline_finished" style="visibility: hidden;">

                    <div class="placeinline_wrap finished"> 
                        <div class="placeinline">
                            <p>DU BIST AN DER REIHE!</p>
                            <p><small>(<?php echo get_data_from_guest($guestid, "guestcount");?> <?php if(get_data_from_guest($guestid, "guestcount") > 1){echo "Personen";} else {echo "Person";}?>)</small></p>
                        </div>
                    </div>

                    <p><a href="leavequeue.php" class="button">Aus der Warteschlange austreten</a></p>
                    
                </div>
                <div class="placeinline_block" id="placeinline_feedback" style="visibility: hidden;">

                    <div class="placeinline_wrap toolate"> 
                        <div class="placeinline">
                            <h3>VIELEN DANK FÜR DEINEN BESUCH!</h3>
                            <p>Wir würden uns sehr über eine Spende in den Spendenschädel und eine Bewertung freuen:</p>
                            <a href="feedback.php" class="button">SHOW BEWERTEN</a>
                            <div class="socials">
                                <a href="https://www.instagram.com/halloweenhaus.schmalenbeck/"><img class="title_image" src="app/client/src/images/logo_instagram.png" alt="Instagram"></a>
                                <a href="https://www.youtube.com/channel/UCmtPYNrj6xp-ed77zzSzUIQ"><img class="title_image" src="app/client/src/images/logo_youtube.png" alt="Youtube"></a>
                            </div>
                        </div>
                    </div>
                    <a href="leavequeue.php" class="button">Zur Startseite</a>

                </div>
                    
                <?php
            }
            close_connection();
        include 'layout/footer.php';
    ?>

    <audio id="sound">
        <source src="sound/laugh.ogg">
    </audio>

    <script> 
    var audioplayed = false;
    var guestgroup;
    var currentgroup;

    var guestgroup = "<?php echo "$guestgroup";?>";

    const sound = document.querySelector('#sound');

    const closedbeforeBannerElement = document.querySelector('#closedbefore_banner');
    const showclosedBannerElement = document.querySelector('#showclosed_banner');
    const maintenanceBannerElement = document.querySelector('#maintenance_banner');
    const closedafterBannerElement = document.querySelector('#closedafter_banner');

    const placeinlineBeforeElement = document.querySelector('#placeinline_before');
    const placeinlineFinishedElement = document.querySelector('#placeinline_finished');
    const placeinlineFeedbackElement = document.querySelector('#placeinline_feedback');

    const estimatedTimeElement = document.querySelector('#estimated_time');

    const placeinlineNumberElement = document.querySelector('#placeinline_number');

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
        
    });

    function checkforsound(data){
        currentgroup = data.current_group;
        if(guestgroup == currentgroup){
            if(!audioplayed){
                console.log("Hello world!");
                sound.play();
                audioplayed = true;
            }
        }
    }

    function showData(data) {
        if("<?php echo $guestid;?>" != "") {
            let options = {hour: "2-digit", minute: "2-digit"}; 
            var time = new Date ("1970-01-01 " + data.estimatedtime);
            if(data.current_status == "closedbefore"){
                closedbeforeBannerElement.style.visibility='visible';
                showclosedBannerElement.style.visibility='hidden';
                maintenanceBannerElement.style.visibility='hidden';
                closedafterBannerElement.style.visibility='hidden';
                estimatedTimeElement.innerText = "Warteschlange geschlossen";
            } else if(data.current_status == "showclosed"){
                closedbeforeBannerElement.style.visibility='hidden';
                showclosedBannerElement.style.visibility='visible';
                maintenanceBannerElement.style.visibility='hidden';
                closedafterBannerElement.style.visibility='hidden';
                estimatedTimeElement.innerText = "Vorraussichtliche Eintrittszeit: " + time.toLocaleTimeString('de-de', options);
            } else if(data.current_status == "maintenance"){
                closedbeforeBannerElement.style.visibility='hidden';
                showclosedBannerElement.style.visibility='hidden';
                maintenanceBannerElement.style.visibility='visible';
                closedafterBannerElement.style.visibility='hidden';
                estimatedTimeElement.innerText = "Es kann aktuell zu Verzögerungen kommen";
            } else if(data.current_status == "closedafter"){
                closedbeforeBannerElement.style.visibility='hidden';
                showclosedBannerElement.style.visibility='hidden';
                maintenanceBannerElement.style.visibility='hidden';
                closedafterBannerElement.style.visibility='visible';
                estimatedTimeElement.innerText = "Warteschlange geschlossen";
            } else {
                closedbeforeBannerElement.style.visibility='hidden';
                showclosedBannerElement.style.visibility='hidden';
                maintenanceBannerElement.style.visibility='hidden';
                closedafterBannerElement.style.visibility='hidden';
                
                estimatedTimeElement.innerText = "Vorraussichtliche Eintrittszeit: " + time.toLocaleTimeString('de-de', options);
            }

            console.log("Current Group: " + data.current_group + " | Guest Group: " + guestgroup);

            if (parseInt(data.current_group) < parseInt(guestgroup)) {
                placeinlineBeforeElement.style.visibility='visible';
                placeinlineBeforeElement.style.height='auto';
                placeinlineFinishedElement.style.visibility='hidden';
                placeinlineFinishedElement.style.height='0px';
                placeinlineFeedbackElement.style.visibility='hidden';
                placeinlineFeedbackElement.style.height='0px';
                audioplayed = false;
            } else if (parseInt(data.current_group) === parseInt(guestgroup)) {
                placeinlineBeforeElement.style.visibility='hidden';
                placeinlineBeforeElement.style.height='0px';
                placeinlineFinishedElement.style.visibility='visible';
                placeinlineFinishedElement.style.height='auto';
                placeinlineFeedbackElement.style.visibility='hidden';
                placeinlineFeedbackElement.style.height='0px';
            } else if (parseInt(data.current_group) > parseInt(guestgroup)){
                console.log("I am stupid!");
                audioplayed = false;
                placeinlineBeforeElement.style.visibility='hidden';
                placeinlineBeforeElement.style.height='0px';
                placeinlineFinishedElement.style.visibility='hidden';
                placeinlineFinishedElement.style.height='0px';
                placeinlineFeedbackElement.style.visibility='visible';
                placeinlineFeedbackElement.style.height='auto';
            }

            placeinlineNumberElement.innerText = guestgroup - data.current_group;
        }
    }

    function reloadData(){
        window.history.replaceState({}, document.title, "index.php?guestid=<?php echo $guestid;?>");
        fetch('status.php')
        .then(response => response.json())
        .then(data => {
            showData(data);
            checkforsound(data);
        });
    }

    setInterval(function(){ 
        reloadData();
    }, 5000);

    reloadData();

</script>
