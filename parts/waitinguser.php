<?php
    function getLayoutForWaitingUser($guestid, $guestgroup){
        $guestcount = get_data_from_guest($guestid, "guestcount");
        ?>
            <p>Deine ID: <kbd><?php echo $guestid;?></kbd> | Gruppe: <kbd id="groupid"><?php echo $guestgroup;?> </kbd></p>
            <p>Du hast dich mit <?php echo $guestcount; if($guestcount > 1){echo ' Personen';}else{echo ' Person';}?> angestellt</p>
            
        <?php waitingUser($guestid); ?>
        <?php finishedUser($guestid); ?>
        <?php feedbackUser($guestid); ?>
            
        <?php
    }

    //WAITING USER LAYOUT:
    function waitingUser($guestid){
        ?>
            <div class="placeinline_block" id="placeinline_before" style="visibility: hidden;">
                <p>Gruppen vor dir: </p>
                <div class="placeinline_wrap"> 
                    <div class="placeinline">
                        <p class="placeinline_number" id="placeinline_number">1</p> 
                    </div>
                </div>
                <h3 id="estimated_time">(OLD)Vorraussichtliche Showzeit: <?php echo substr(get_data_from_group(get_data_from_guest($guestid, "groupid"), "time"), 0 ,-3); ?></h3>
                <p>(Bitte 5 Minuten vor Showstart am Eingang einfinden)</p>
                <p>
                    <a href="leavequeue.php" class="button">Aus der Warteschlange austreten</a>
                </p>

            </div>
        <?php
    }

    //FINISHED USER LAYOUT:
    function finishedUser($guestid){
        ?>
            <div class="placeinline_block" id="placeinline_finished" style="visibility: hidden;">

                <div class="placeinline_wrap finished"> 
                    <div class="placeinline">
                        <p>DU BIST AN DER REIHE!</p>
                        <p><small>(<?php echo get_data_from_guest($guestid, "guestcount");?> <?php if(get_data_from_guest($guestid, "guestcount") > 1){echo "Personen";} else {echo "Person";}?>)</small></p>
                    </div>
                </div>

                <p>
                    <a href="leavequeue.php" class="button">Aus der Warteschlange austreten</a>
                </p>
                
            </div>
        <?php
    }

    //FEEDBACK USER LAYOUT:
    function feedbackUser($guestid){
        ?>
            <div class="placeinline_block" id="placeinline_feedback" style="visibility: hidden;">
                <div class="placeinline_wrap toolate"> 
                    <div class="placeinline">
                        <h3>VIELEN DANK FÜR DEINEN BESUCH!</h3>
                        <p>Wir würden uns sehr über eine Spende in den Spendenschädel und eine Bewertung freuen:</p>

                        <form method="post" action="feedback_sent.php">

                            <div class="container">
                            <div class="feedback">
                                <p>Wie hat dir die Show gefallen?</p>
                                <div class="rating">
                                <input type="radio" name="rating" id="rating-5" value="5">
                                <label for="rating-5"></label>
                                <input type="radio" name="rating" id="rating-4" value="4">
                                <label for="rating-4"></label>
                                <input type="radio" name="rating" id="rating-3" value="3">
                                <label for="rating-3"></label>
                                <input type="radio" name="rating" id="rating-2" value="2">
                                <label for="rating-2"></label>
                                <input type="radio" name="rating" id="rating-1" value="1">
                                <label for="rating-1"></label>
                                <div class="emoji-wrapper">
                                    <div class="emoji">
                                    <img class="rating-0" src="app/client/src/images/hw40a_emoji_neutral.svg" alt="Logo des Halloweenhauses">
                                    <img class="rating-1" src="app/client/src/images/hw40a_emoji_reallysad.svg" alt="Logo des Halloweenhauses">
                                    <img class="rating-2" src="app/client/src/images/hw40a_emoji_sad.svg" alt="Logo des Halloweenhauses">
                                    <img class="rating-3" src="app/client/src/images/hw40a_emoji_neutral.svg" alt="Logo des Halloweenhauses">
                                    <img class="rating-4" src="app/client/src/images/hw40a_emoji_happy.svg" alt="Logo des Halloweenhauses">
                                    <img class="rating-5" src="app/client/src/images/hw40a_emoji_reallyhappy.svg" alt="Logo des Halloweenhauses">
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>

                            <div class="form-group">
                                <label>Was könnten wir nächstes Jahr verbessern?</label> 
                                <textarea rows="3" cols="33" class="form-control" name="text"></textarea>
                            </div>

                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="submit" value="Feedback senden">
                            </div>
                        </form>

                        <p><a href="new_guest.php" class="button">Neu anstellen</a></p>
                        <p><a href="leavequeue.php" class="button">Zur Startseite</a></p>
                        <div class="socials">
                            <a href="https://www.instagram.com/halloweenhaus.schmalenbeck/"><img class="title_image" src="app/client/src/images/logo_instagram.png" alt="Instagram"></a>
                            <a href="https://www.youtube.com/channel/UCmtPYNrj6xp-ed77zzSzUIQ"><img class="title_image" src="app/client/src/images/logo_youtube.png" alt="Youtube"></a>
                        </div>
                    </div>
                </div>

            </div>
        <?php
    }
?>
