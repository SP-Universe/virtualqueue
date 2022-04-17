<?php
    include 'layout/header.php';
    require 'main.php';

    echo'<h2>Admin-Bereich</h2>';

    connectmysql();

    $result = get_all_groups();

    echo'<p>Current Group: ' . $current_group . '</p>';

    echo'
    <div class="grouplist">
        <p>ID</p>
        <p>Time</p>
        <p>Guests</p>
        <p>Frei</p>
    </div>
    ';

    $waitingguests = 0;

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

    echo'<br><p>Currently waiting: ' . $waitingguests . '</p>';

    echo'<form method="post" action="admin/change_group.php">
        <input type="text" name="group">
        <input type="submit" value="Change current group" accesskey="s" name="submit">
    </form>';

    close_connection();
?>
