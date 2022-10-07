<?php
    function getLayoutForWaitingUser($guestid, $guestgroup){
        $guestcount = get_data_from_guest($guestid, "guestcount");
        ?>
            <div class="section section--queue">
                <div class="queue_card">
                    <div class="queue_card_top">
                        <p class="big_number" id="queue_number">1</p>
                        <p>Gruppen vor dir</p>
                    </div>
                    <div class="queue_card_center"><img src="app/client/src/images/virtualcard_center.svg" alt=""></div>
                    <div class="queue_card_bottom">
                        <div class="card_section">
                            <p class="big_number"><?php echo $guestgroup;?></p>
                            <p>Deine Gruppe</p>
                        </div>
                        <div class="card_section">
                            <p class="big_number"><?php echo $guestid;?></p>
                            <p>Deine ID</p>
                        </div>
                        <div class="card_section">
                            <p class="big_number"><?php echo $guestcount;?></p>
                            <p><?php if($guestcount > 1){echo ' Personen';}else{echo ' Person';}?></p>
                        </div>
                        <div class="card_section">
                            <p class="big_number" id="estimated_time"><?php echo substr(get_data_from_group(get_data_from_guest($guestid, "groupid"), "time"), 0 ,-3); ?></p>
                            <p>Vorraussichtlicher Einlass</p>
                        </div>
                    </div>

                    <a href="leavequeue.php" class="button leavequeue">Warteschlange verlassen</a>
                </div>

                <div class="waiting_timeline">
                    <img class="forest" src="app/client/src/images/timeline/timeline_trees.svg">
                    <img class="otto" id="walking_otto" src="app/client/src/images/timeline/timeline_otto.svg">
                    <img class="house" src="app/client/src/images/timeline/timeline_house.svg">
                </div>

                <?php feedbackUser($guestid); ?>
            </div>
        <?php
    }

    //FEEDBACK USER LAYOUT:
    function feedbackUser($guestid){
        ?>
            <div class="feedback_card" id="feedback_card">
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

                <p><a href="leavequeuetowebsite.php" class="button">Besuche unsere Webseite!</a></p>
                <div class="socials">
                    <a href="https://www.instagram.com/halloweenhaus.schmalenbeck/"><img class="title_image" src="app/client/src/images/logo_instagram.png" alt="Instagram"></a>
                    <a href="https://www.youtube.com/channel/UCmtPYNrj6xp-ed77zzSzUIQ"><img class="title_image" src="app/client/src/images/logo_youtube.png" alt="Youtube"></a>
                </div>
            </div>
        <?php
    }
?>
