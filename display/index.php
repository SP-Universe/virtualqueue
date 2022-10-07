<?php
    require '../main.php';
    connectmysql();
?>

<head>
    <title>HWHS - Virtual Queue Display</title>
    <link rel="icon" type="image/png" sizes="32x32" href="../app/client/src/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../app/client/src/images/favicon-16x16.png">
    <link rel="stylesheet" href="../app/client/dist/css/styles.css">
</head>
<body>
    <script src="jquery-3.6.0.min.js"></script>

    <div class="section section--display">

        <div class="background_img">
            <img src="../app/client/src/images/display_background/layer_0.png" alt="background">
            <img src="../app/client/src/images/display_background/layer_1.png" alt="background">
            <img src="../app/client/src/images/display_background/layer_2.png" alt="background">
            <img src="../app/client/src/images/display_background/layer_3.png" alt="background">
            <img src="../app/client/src/images/display_background/layer_4.png" alt="background">
            <img src="../app/client/src/images/display_background/layer_5.png" alt="background">
            <img src="../app/client/src/images/display_background/layer_6.png" alt="background">
            <img src="../app/client/src/images/display_background/layer_7.png" alt="background">
            <img src="../app/client/src/images/display_background/layer_8.png" alt="background">
            <img src="../app/client/src/images/display_background/layer_9.png" alt="background">
        </div>

        <!--<img class="background_img" src="../app/client/src/images/displaybackground.jpg">-->
        <h1>Willkommen beim Halloweenhaus Schmalenbeck!</h1>

        <?php if(get_data_from_setting("current_status") != "closedbefore"){ ?>
        <h2 class="current_group">Aktuelle Gruppe: <?php echo $current_group;?></h2>
        <?php } ?>

        <div class="display_cards">

            <?php
                    if(get_data_from_setting("current_status") != "closedbefore"){
            ?>
            <div class="display_card entrance">
                <div class="reloading_div" id="reloading">
                    <?php if(get_data_from_setting("current_status") == "open") { ?>
                        <div class="guest_ids">
                            <h2>Jetzt an der Reihe:</h2>
                            <?php
                            $guestids = get_all_ids_from_group($current_group); 
                            if($guestids != null){
                                foreach($guestids as $gid){
                                    ?>
                                        <kbd class="groupid large_number <?php echo get_data_from_guest($gid['guestid'], "checkedin");?>"><?php echo $gid['guestid']?> (<?php echo get_data_from_guest($gid['guestid'], "guestcount");?>)</kbd>
                                    <?php
                                }
                            } else {
                                echo 'Die Virtual Queue ist leer';
                            }
                            ?>
                            <p>(Gäste aus der Virtual Queue)</p>
                        </div>
                        <img src="../app/client/src/images/virtualcard_center.svg" alt="">
                        <div class="big_number_wrap">
                            <h2>Noch freie Plätze:</h2>
                            <p class="big_number"><?php 
                                if(($max_vq_users_per_group + $min_sq_users_per_group) - get_data_from_group($current_group, "vq_guests") - get_data_from_setting("display_guest_count") > 0){
                                    echo ($max_vq_users_per_group + $min_sq_users_per_group) - get_data_from_group($current_group, "vq_guests") - get_data_from_setting("display_guest_count");
                                } else {
                                    echo 0;
                                }
                            ?></p>
                            <p>(Gäste aus der Standby Queue)</p>
                        </div>
                    <?php } elseif(get_data_from_setting("current_status") == "showclosed") { ?>
                        <div class="guest_ids">
                            <h2>Jetzt in unserer virtuellen Warteschlange anstellen:</h2>
                            <img class="qrcode" src="../app/client/src/images/qrcode.png" alt="QRCode">
                            <p>virtualqueue.halloweenhaus-schmalenbeck.de</p>
                        </div>
                        <div class="big_number_wrap"></div>
                    <?php } elseif(get_data_from_setting("current_status") == "maintenance") { ?>
                        <div class="guest_ids">
                            <h2 class="warning">Es gibt gerade technische Schwierigkeiten... <br>Bitte etwas Geduld!</h2>
                            <h2>Als nächstes an der Reihe:</h2>
                            <?php
                            $guestids = get_all_ids_from_group($current_group); 
                            if($guestids != null){
                                foreach($guestids as $gid){
                                    ?>
                                        <kbd class="groupid large_number <?php echo get_data_from_guest($gid['guestid'], "checkedin");?>"><?php echo $gid['guestid']?> (<?php echo get_data_from_guest($gid['guestid'], "guestcount");?>)</kbd>
                                    <?php
                                }
                            } else {
                                echo 'Die Virtual Queue ist leer';
                            }
                            ?>
                            <p>(Gäste aus der Virtual Queue)</p>
                        </div>
                        <img src="../app/client/src/images/virtualcard_center.svg" alt="">
                        <div class="big_number_wrap">
                            <h2>Noch freie Plätze:</h2>
                            <p class="big_number"><?php 
                                if(($max_vq_users_per_group + $min_sq_users_per_group) - get_data_from_group($current_group, "vq_guests") - get_data_from_setting("display_guest_count") > 0){
                                    echo ($max_vq_users_per_group + $min_sq_users_per_group) - get_data_from_group($current_group, "vq_guests") - get_data_from_setting("display_guest_count");
                                } else {
                                    echo 0;
                                }
                            ?></p>
                            <p>(Gäste aus der Standby Queue)</p>
                        </div>
                    <?php } elseif(get_data_from_setting("current_status") == "closedafter") { ?>
                        <div class="guest_ids">
                            <h2>Die Warteschlange ist für heute geschlossen</h2>
                            <p>Danke für euren Besuch und bis nächstes Jahr!</p>
                            <p>Besucht auch gerne mal unsere Website halloweenhaus-schmalenbeck.de</p>
                        </div>
                        <div class="big_number_wrap"></div>
                    <?php } ?>
                </div>

                <div class="social_medias">
                    <div class="social_media_icon">
                        <img class="logo" src="../app/client/src/images/logo_instagram.png" alt="logo_instagram">
                    </div>
                    <p>@halloweenhaus.schmalenbeck</p>
                </div>
                <div class="social_medias">
                    <div class="social_media_icon">
                        <img class="logo" src="../app/client/src/images/logo_youtube.png" alt="logo_youtube ">
                    </div>
                    <p>Halloweenhaus Schmalenbeck</p>
                </div>
            </div>
            <?php
                }
            ?>

            <div class="display_card information">
                <div class="infoslider">
                    <?php require '../parts/display_slider.php';
                        getInfoSlider();
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

<!---->
<script>
   $(document).ready(function(){
   window.setInterval(function(){
     $("#reloading").load(window.location.href + " #reloading" );
   }, 1000);
   });
</script>
<!---->

<?php 
close_connection();
?>
