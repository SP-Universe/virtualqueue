<head>
    <link rel="stylesheet" href="displaystyle.css">
</head>
<body>

<?php
    require '../main.php';

    if(checklogin()){
        connectmysql();
        ?>

        <div class="display">
            <img src="../images/displaybackground.jpg">
            <h1>Willkommen beim Halloweenhaus Schmalenbeck!</h1>
            <h2 class="current_group admin">Aktuelle Gruppe: <?php echo $current_group;?></h2>

            <div class="display_cards">
                <div class="display_row admin">
                    <div class="display_row_block admin">
                        <div class="display_guests">
                            <?php
                            $guestids = get_all_ids_from_group($current_group); 
                            if($guestids != null){
                                foreach($guestids as $gid){
                                    ?>
                                        <a href="checkin.php?guestid=<?php echo $gid['guestid'];?>"><kbd class="<?php echo get_data_from_guest($gid['guestid'], "checkedin");?>"><?php echo $gid['guestid']?> (<?php echo get_data_from_guest($gid['guestid'], "guestcount");?>)</kbd></a>
                                    <?php
                                }
                            } else {
                                echo 'Die Virtual Queue ist leer';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="display_row_block admin">
                        <a href="change_guestcount.php?method=decrease" class="button">+</a>
                        <p class="big_number admin"><?php echo $max_guests_per_show - get_data_from_group($current_group, "guestcount") - get_data_from_setting("current_guest_count");?></p>
                        <a href="change_guestcount.php?method=increase" class="button">-</a>
                    </div>
                </div>
            </div>
            
            <div class="next_group">
                <p data-behaviour="showhide">Nächste Gruppe</p>
                <a href="toggleblock.php" class="textbutton <?php echo get_data_from_setting("block_occupied");?>">Ja wirklich!</a>
            </div>
        </div>

        <?php
        close_connection();
    } else {
        ?>
            <form class="login_form" method="post" action="login.php">
                <label for="password">Passwort</label>    
                <input type="text" name="password">
                <input type="submit" value="Einloggen" accesskey="s" name="submit">
            </form>
        <?php
    }
?>
</body>
<script>
document.addEventListener("DOMContentLoaded", function (event) {
    //Show hide
    let showHideElements = [...document.querySelectorAll('[data-behaviour="showhide"]')];

    showHideElements.forEach((element) => {
        element.addEventListener("click", (e) => {
            e.preventDefault();
            element.parentNode.classList.toggle("visible")

            showHideElements.filter(e => e != element).forEach((e) => e.parentNode.classList.remove("visible"));
        })
    });
});

setInterval(function(){ 
	window.location.reload();
}, 10000);

</script>
