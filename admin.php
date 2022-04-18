<?php
    include 'layout/header.php';
    require 'main.php';

    echo'<h2>Admin-Bereich</h2>';

    connectmysql();

    $result = get_all_groups();

    echo'<p>Aktuelle Gruppe: ' . $current_group . ' | Aktueller Status: ' . $current_status . '</p>';

    echo'<a href="admin/next_group.php" class="button">Nächste Gruppe</a>';

    echo'
    <div class="groups">
        <div class="grouplist">
            <p class="grouplist_entry">ID</p>
            <p class="grouplist_entry">Time</p>
            <p class="grouplist_entry">Guests</p>
            <p class="grouplist_entry">Frei</p>
            <p class="grouplist_entry double">IDs</p>
        </div>
    </div>
    ';

    $waitingguests = 0;
    echo'<div class="groups" id=list>';
    if($result != null){
        foreach ($result as $g){
            $guestids = get_all_ids_from_group($g['groupid']);
            ?>
                <div class="grouplist <?php if($current_group == $g['groupid']){ echo 'current';} else if ($current_group > $g['groupid']) { echo 'past';}?>">
                    <p class="grouplist_entry"><?php echo $g['groupid'];?></p>
                    <p class="grouplist_entry"><?php echo substr($g['time'],0 ,-3);?></p>
                    <p class="grouplist_entry"><?php echo $g['guestcount'];?></p>
                    <p class="grouplist_entry"><?php echo ($max_users_per_group - $g['guestcount']);?></p>
                    <div class="grouplist_entry double" data-behaviour="showhide">
                        <?php foreach($guestids as $gid){
                            ?>
                                <span data-behaviour="showhide"><kbd><?php echo $gid['guestid']?></kbd></span>
                            <?php
                            }
                        ?>
                    </div>
                </div>
            <?php
            if($current_group < $g['groupid']){
                $waitingguests += $g['guestcount'];
            }
        }
    } else {
        echo '<p>- Keine Gruppen gefunden! -</p>';
    }

    echo'</div><br><p>Currently waiting: ' . $waitingguests . '</p>';

    echo'<form class="group_change_form" method="post" action="admin/change_group.php">
        <input type="number" value="'.$current_group.'" name="group">
        <input type="submit" value="Change current group" accesskey="s" name="submit">
    </form>';

?>
    
    <form class="group_change_form" method="post" action="admin/change_status.php">
        <select id="status" name="status">
            <option value="closedbefore" <?php if($current_status === "closedbefore"){echo'selected';}?>>closedbefore</option>
            <option value="open" <?php if($current_status === "open"){echo'selected';}?>>open</option>
            <option value="maintenance" <?php if($current_status === "maintenance"){echo'selected';}?>>maintenance</option>
            <option value="closedafter" <?php if($current_status === "closedafter"){echo'selected';}?>>closedafter</option>
        </select>
        <input type="submit" value="Change status" accesskey="s" name="submit">
    </form>

<?php
    close_connection();
?>

<script>
document.addEventListener("DOMContentLoaded", function (event) {
    //Show hide
    let showHideElements = [...document.querySelectorAll('[data-behaviour="showhide"]')];

    showHideElements.forEach((element) => {
        element.addEventListener("click", (e) => {
            e.preventDefault();
            element.parentNode.classList.toggle("visible")
        })
    });
});

$(document).ready(function(){
    setInterval(function(){
        //$("#list").load(window.location.href + " #list" );
    }, 3000);
});
</script>
