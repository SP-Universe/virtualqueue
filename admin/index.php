<!DOCTYPE html>
<html lang="de"
    xmlns="http://www.w3.org/1999/xhtml"
    xmlns:fb="http://ogp.me/ns/fb#">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Digitale Warteschlange für das Halloweenhaus Schmalenbeck">
    <meta name="publisher" content="SP Universe">
    <meta name="copyright" content="SP Universe">
    <meta name="audience" content="Everyone">
    <meta charset="utf-8"/>
    <title>HW40a - Virtual Queue</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">

    <meta property="og:title" content="HW40a - Virtual Queue" />
    <meta property="og:site_name" content="HW40a - Virtual Queue" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="Die virtuelle Warteschlange des Halloweenhaus Schmalenbeck">
    <meta property="og:url" content="$Link" />
    <meta property="og:image" content="https://i.ibb.co/1QDXbC8/HW40a-Profile-Pic.jpg" />
    <meta property="og:image:alt" content="Das Logo des Halloweenhaus Schmalenbeck" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:locale" content="de_DE" />
    <meta name="twitter:card" content="summary_large_image">

    <meta name="msapplication-TileColor" content="#102C4D">
    <meta name="theme-color" media="(prefers-color-scheme: light)" content="#FFFFFF">
    <meta name="theme-color" media="(prefers-color-scheme: dark)" content="#102C4D">

    <link rel="shortcut icon" type="image/x-icon" href="../images/favicon-32x32.png" />
    <link rel="stylesheet" href="../app/client/dist/css/styles.css">
</head>
<body>
<?php
    require '../main.php';

    connectmysql();

    if(checklogin()){

        $all_groups = get_all_groups();
        $waitingguests = 0;

        ?>

        <div class="togglebutton_group" data-behaviour="toggleview">
            <span class="togglebutton" id="togglebutton_groups">Overview</span>
            <span class="togglebutton" id="togglebutton_display">Entrance</span>
        </div>

        <div class="current_status_screen">
            <h2>Admin-Bereich</h2>
            <p>Gruppe: <?php echo $current_group; ?> | Status: <?php echo $current_status; ?></p>
        </div>

        <div class="toggleview groupsadmin" id="groupsadmin">        
            <a href="next_group.php?view=groups" class="button">Nächste Gruppe</a>
            
            <div class="groupslist">
                <div class="groupslist_row">
                    <p class="groupslist_entry">ID</p>
                    <p class="groupslist_entry">Time</p>
                    <p class="groupslist_entry">VQ</p>
                    <p class="groupslist_entry">SQ</p>
                    <p class="groupslist_entry double">IDs</p>
                </div>
            </div>
            <div class="groupslist" id=groupslist>

                <?php
                if($all_groups != null){
                    foreach ($all_groups as $g){
                        $guestids = get_all_ids_from_group($g['groupid']);

                        $checkedin_vqs = 0;
                        if ($guestids != null) {
                            foreach($guestids as $gid){
                                if(get_data_from_guest($gid['guestid'], "checkedin") == "checkedin")
                                {
                                    $checkedin_vqs += get_data_from_guest($gid['guestid'], "guestcount");
                                }
                            }
                        }
                        
                        if($current_group < $g['groupid']){
                            $waitingguests += $g['vq_guests'];
                            ?>
                        
                            <div class="groupslist_row">
                                <p class="groupslist_entry"><?php echo $g['groupid'];?></p>
                                <p class="groupslist_entry"><?php echo substr($g['time'],0 ,-3);?></p>
                                <p class="groupslist_entry"><?php echo $g['vq_guests'];?></p>
                                <p class="groupslist_entry"><?php echo (($min_sq_users_per_group + $max_vq_users_per_group) - $g['vq_guests']);?></p>
                                <div class="groupslist_entry groupids" data-behaviour="showhide">
                                    <?php if ($guestids != null) {
                                        foreach($guestids as $gid){
                                            ?>
                                                <p data-behaviour="showhide" class="groupid <?php echo get_data_from_guest($gid['guestid'], "checkedin")?>"><?php echo $gid['guestid']?></p>
                                            <?php
                                        }
                                        
                                    } else { ?>
                                        <p data-behaviour="showhide" class="groupid">Empty</p>
                                    <?php } ?>
                                </div>
                            </div>

                            <?php
                        } else if($current_group == $g['groupid']){
                            $waitingguests += $g['vq_guests'];
                            ?>
                        
                            <div class="groupslist_row current" id="current_group">
                                <p class="groupslist_entry"><?php echo $g['groupid'];?></p>
                                <p class="groupslist_entry"><?php echo substr($g['time'],0 ,-3);?></p>
                                <p class="groupslist_entry"><?php echo $checkedin_vqs . "/" . $g['vq_guests'];?></p>
                                <p class="groupslist_entry"><?php echo get_data_from_setting("display_guest_count") . "/" . (($min_sq_users_per_group + $max_vq_users_per_group) - $g['vq_guests']);?></p>
                                <div class="groupslist_entry groupids" data-behaviour="showhide">
                                    <?php if ($guestids != null) {
                                        foreach($guestids as $gid){
                                            ?>
                                                <p data-behaviour="showhide" class="groupid <?php echo get_data_from_guest($gid['guestid'], "checkedin")?>"><?php echo $gid['guestid']?></p>
                                            <?php
                                        }
                                        
                                    } else { ?>
                                        <p data-behaviour="showhide" class="groupid">Empty</p>
                                    <?php } ?>
                                </div>
                            </div>

                            <?php
                        } else{
                            ?>
                        
                            <div class="groupslist_row past">
                                <p class="groupslist_entry"><?php echo $g['groupid'];?></p>
                                <p class="groupslist_entry"><?php echo substr($g['time'],0 ,-3);?></p>
                                <p class="groupslist_entry"><?php echo $checkedin_vqs;?></p>
                                <p class="groupslist_entry"><?php echo $g['sq_guests'];?></p>
                                <div class="groupslist_entry groupids" data-behaviour="showhide">
                                    <?php if ($guestids != null) {
                                        foreach($guestids as $gid){
                                            ?>
                                                <p data-behaviour="showhide" class="groupid <?php echo get_data_from_guest($gid['guestid'], "checkedin")?>"><?php echo $gid['guestid']?></p>
                                            <?php
                                        }
                                        
                                    } else { ?>
                                        <p data-behaviour="showhide" class="groupid">Empty</p>
                                    <?php } ?>
                                </div>
                            </div>

                            <?php
                        }
                    }
                } else {
                    echo '<p>- Keine Gruppen gefunden! -</p>';
                }
                ?>
            </div>
            <br>
            <p>Gerade warten <b><?php echo $waitingguests;?></b> Gäste </p>

            <form id="guestcount_form" class="group_change_form" method="post" action="change_group.php">
                <div class="options">
                    <div class="options_value">
                        <p>Gruppe</p>
                        <input type="number" value="<?php echo $current_group;?>" name="group">
                    </div>
                    <div class="options_value">
                        <p>Max VQ</p>
                        <input onchange="calculateTotalShowSize()" type="number" value="<?php echo $max_vq_users_per_group;?>" id="max_vq" name="max_vq">
                    </div>
                    <div class="options_value">
                        <p>Min SQ</p>
                        <input onchange="calculateTotalShowSize()" type="number" value="<?php echo $min_sq_users_per_group;?>" id="min_sq" name="min_sq">
                    </div>
                    <div class="options_value">
                        <p id="guestcount_display">(20 People per Show)</p>
                    </div>
                </div>
                
                <input type="submit" value="Change values" accesskey="s" name="submit">
            </form>
            
            <form class="group_change_form" method="post" action="change_status.php">
                <select id="status" name="status">
                    <option value="closedbefore" <?php if($current_status === "closedbefore"){echo'selected';}?>>closedbefore</option>
                    <option value="showclosed" <?php if($current_status === "showclosed"){echo'selected';}?>>showclosed</option>
                    <option value="open" <?php if($current_status === "open"){echo'selected';}?>>open</option>
                    <option value="maintenance" <?php if($current_status === "maintenance"){echo'selected';}?>>maintenance</option>
                    <option value="closedafter" <?php if($current_status === "closedafter"){echo'selected';}?>>closedafter</option>
                </select>
                <input type="submit" value="Change status" accesskey="s" name="submit">
            </form>
        </div>

        <div class="toggleview displayadmin" id="displayadmin">

            <div class="next_group">
                <p data-behaviour="showhide_nextgroup" class="showhide_nextgroup">Nächste Gruppe</p>
                <a href="next_group.php?view=display" class="textbutton">Ja wirklich!</a>
            </div>

            <p class="next_group_time" id="admin_next_group_countdown">00:00 till next group</p>

            <div class="display_cards">
                <div class="display_row admin">
                    <div class="display_row_block admin">
                        <div class="display_guests">
                            <?php
                            $guestids = get_all_ids_from_group($current_group); 
                            if($guestids != null){
                                foreach($guestids as $gid){
                                    ?>
                                        <a href="checkin.php?view=display&&guestid=<?php echo $gid['guestid'];?>"><p class="groupid <?php echo get_data_from_guest($gid['guestid'], "checkedin");?>"><?php echo $gid['guestid']?> (<?php echo get_data_from_guest($gid['guestid'], "guestcount");?>)</p></a>
                                    <?php
                                }
                            } else {
                                echo 'Die Virtual Queue ist leer';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="display_row_block admin">
                        <a href="change_guestcount.php?method=decrease" class="roundbutton">+</a>
                        <p class="big_number admin"><?php echo ($min_sq_users_per_group + $max_vq_users_per_group) - get_data_from_group($current_group, "vq_guests") - get_data_from_setting("display_guest_count");?></p>
                        <a href="change_guestcount.php?method=increase" class="roundbutton">-</a>
                    </div>
                </div>
            </div>
        </div>

        <?php
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
var view="groups";

<?php if(isset($_GET['view'])){
    echo "view='" . $_GET['view'] . "'";
}
?>

const groupviewElement = document.querySelector('#groupsadmin');
const displayviewElement = document.querySelector('#displayadmin');

const togglebuttonDisplayElement = document.querySelector('#togglebutton_display');
const togglebuttonGroupsElement = document.querySelector('#togglebutton_groups');

var guestcountForm = document.forms["guestcount_form"];
const guestcountDisplayElement = document.querySelector('#guestcount_display');

let showHideElements = [...document.querySelectorAll('[data-behaviour="showhide"]')];

var countDownDate = new Date("Oct 5, <?php echo get_data_from_group($current_group + 1, 'time');?>").getTime();
console.log(countDownDate);

setInterval(function() {
    var now = new Date().getTime();
    var distance = countDownDate - now;
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    document.getElementById("admin_next_group_countdown").innerHTML = "<p>" + hours + ":" + minutes + ":" + seconds + " Sekunden bis zum nächstem Einlass</p>";
    console.log(countDownDate);
}, 1000);

function calculateTotalShowSize(){
    var minSQ = guestcountForm.elements["min_sq"];
    var maxVQ = guestcountForm.elements["max_vq"];

    var total_guests_per_group = parseInt(minSQ.value) + parseInt(maxVQ.value);
    guestcountDisplayElement.innerText = "(" + total_guests_per_group + " Guests per Show)";
}

function updateDisplay() {
    window.history.replaceState({}, document.title, "index.php");
    if(view == "groups"){
        groupviewElement.style.visibility = 'visible';
        groupviewElement.style.height = 'auto';
        displayviewElement.style.visibility = 'hidden';
        displayviewElement.style.height = '0';
        togglebuttonGroupsElement.classList.add("active");
        togglebuttonGroupsElement.classList.remove("inactive");
        togglebuttonDisplayElement.classList.add("inactive");
        togglebuttonDisplayElement.classList.remove("active");
    } else {
        groupviewElement.style.visibility = 'hidden';
        groupviewElement.style.height = '0';
        displayviewElement.style.visibility = 'visible';
        displayviewElement.style.height = 'auto';
        togglebuttonGroupsElement.classList.add("inactive");
        togglebuttonGroupsElement.classList.remove("active");
        togglebuttonDisplayElement.classList.add("active");
        togglebuttonDisplayElement.classList.remove("inactive");
    }
}

document.addEventListener("DOMContentLoaded", function (event) {
    //Show hide

    showHideElements.forEach((element) => {
        element.addEventListener("click", (e) => {
            e.preventDefault();
            element.parentNode.classList.toggle("visible")
        })
    });

    //Toggle Admin view
    let toggleViewElement = document.querySelector('[data-behaviour="toggleview"]');

    toggleViewElement.addEventListener("click", (e) => {
        e.preventDefault();
        if(view == "groups"){
            view = "display";
            updateDisplay();
        } else {
            view = "groups";
            updateDisplay();
        }
    })

    //Show hide
    let showHidenextgroupElements = [...document.querySelectorAll('[data-behaviour="showhide_nextgroup"]')];

    showHidenextgroupElements.forEach((element) => {
        element.addEventListener("click", (e) => {
            e.preventDefault();
            element.parentNode.classList.toggle("visible")

            showHideElements.filter(e => e != element).forEach((e) => e.parentNode.classList.remove("visible"));
        })
    });
});

setInterval(function(){ 
    if(view == "groups"){
        window.location.reload();
        updateDisplay();
    }
}, 30000);

updateDisplay();
calculateTotalShowSize();

</script>
<?php close_connection(); ?>
