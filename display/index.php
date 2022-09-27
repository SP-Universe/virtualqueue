<?php
    require '../main.php';
?>

<head>
    <link rel="icon" type="image/png" sizes="32x32" href="../app/client/src/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../app/client/src/images/favicon-16x16.png">
    <link rel="stylesheet" href="../app/client/dist/css/styles.css">
</head>
<body>

<div class="display">
    <img src="../app/client/src/images/displaybackground.jpg">
    <h1>Willkommen beim Halloweenhaus Schmalenbeck!</h1>
    <h2 class="current_group">Aktuelle Gruppe: <?php echo $current_group;?></h2>

    <div class="display_cards" id="reloading">
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
            <div class="display_row_block" >
                <p class="big_number"><?php 
                    if(($max_vq_users_per_group + $min_sq_users_per_group) - get_data_from_group($current_group, "vq_guests") - get_data_from_setting("display_guest_count") > 0){
                        echo ($max_vq_users_per_group + $min_sq_users_per_group) - get_data_from_group($current_group, "vq_guests") - get_data_from_setting("display_guest_count");
                    } else {
                        echo 0;
                    }
                ?></p>
                <p>Gäste aus der standby Queue</p>
            </div>
        </div>
    </div>
</div>

</body>

<!-- <script>
    setInterval(function(){ 
	    window.location.reload();
    }, 4000);

</script> -->
<script src="jquery-3.6.0.min.js"></script>
<script>
   $(document).ready(function(){
   window.setInterval(function(){
     $("#reloading").load(window.location.href + " #reloading" );
   }, 3000);
   });
</script>
