<?php
    require '../main.php';
?>

<head>
    <link rel="stylesheet" href="displaystyle.css">
</head>
<body>

<div class="display">
    <img src="../images/displaybackground.jpg">
    <h1>Willkommen beim Halloweenhaus Schmalenbeck!</h1>
    <h2 class="current_group">Aktuelle Gruppe: <?php echo $current_group;?></h2>

    <div class="display_cards">
        <div class="display_row">
            <div class="display_row_block">
                <div class="display_guests">
                    <?php
                    $guestids = get_all_ids_from_group($current_group); 
                    if($guestids != null){
                        foreach($guestids as $gid){
                            ?>
                                <p class="groupid large_number <?php echo get_data_from_guest($gid['guestid'], "checkedin");?>"><?php echo $gid['guestid']?> (<?php echo get_data_from_guest($gid['guestid'], "guestcount");?>)</p>
                            <?php
                        }
                    } else {
                        echo 'Die Virtual Queue ist leer';
                    }
                    ?>
                </div>
            </div>
            <div class="display_row_block">
                <p class="big_number"><?php echo ($max_vq_users_per_group + $min_sq_users_per_group) - get_data_from_group($current_group, "vq_guests") - get_data_from_setting("current_guest_count");?></p>
                <p>Gäste aus der standby Queue</p>
            </div>
        </div>
    </div>
</div>

</body>

<script>
    setInterval(function(){ 
	window.location.reload();
}, 4000);
</script>
