<?php
    include 'layout/header.php';
    require 'main.php';

    echo'<h2>Admin-Bereich</h2>';

    connectmysql();

    $result = get_all_groups();

    echo'<p>Aktuelle Gruppe: ' . $current_group . '</p>';

    echo'
    <div class="grouplist">
        <p>ID</p>
        <p>Time</p>
        <p>Guests</p>
        <p>Frei</p>
    </div>
    ';

    $waitingguests = 0;

    if($result != null){
        foreach ($result as $g){
            if($current_group == $g['groupid']){
                echo'
                    <div class="grouplist current">
                        <p class="grouplist_entry">' . $g['groupid'] . '</p>
                        <p class="grouplist_entry">' . substr($g['time'],0 ,-3) . '</p>
                        <p class="grouplist_entry">' . $g['guestcount'] . '</p>
                        <p class="grouplist_entry">' . ($max_users_per_group - $g['guestcount']) . '</p>
                    </div>
                ';
            } else if ($current_group > $g['groupid']) {
                echo'
                    <div class="grouplist past">
                        <p class="grouplist_entry">' . $g['groupid'] . '</p>
                        <p class="grouplist_entry">' . substr($g['time'],0 ,-3) . '</p>
                        <p class="grouplist_entry">' . $g['guestcount'] . '</p>
                        <p class="grouplist_entry">' . ($max_users_per_group - $g['guestcount']) . '</p>
                    </div>
                ';
            } else {
                echo'
                    <div class="grouplist">
                        <p class="grouplist_entry">' . $g['groupid'] . '</p>
                        <p class="grouplist_entry">' . substr($g['time'],0 ,-3) . '</p>
                        <p class="grouplist_entry">' . $g['guestcount'] . '</p>
                        <p class="grouplist_entry">' . ($max_users_per_group - $g['guestcount']) . '</p>
                    </div>
                ';
                $waitingguests += $g['guestcount'];
            }
        }
    } else {
        echo '<p>- Keine Gruppen gefunden! -</p>';
    }

    echo'<br><p>Currently waiting: ' . $waitingguests . '</p>';

    echo'<form class="group_change_form" method="post" action="admin/change_group.php">
        <input type="number" value="'.$current_group.'" name="group">
        <input type="submit" value="Change current group" accesskey="s" name="submit">
    </form>';

    echo'<a href="admin/next_group.php" class="button">Nächste Gruppe</a>';

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
