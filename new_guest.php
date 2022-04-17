<?php 
    include 'layout/header.php';
    require 'main.php';
?>

    <h2>Wieviele Personen sind in deiner Gruppe?</h2>
    <div class="numberlist">
        <?php
        for($i=1;$i<$max_users_per_group+1;$i++){
            echo'<a href="userpage.php?new_guests=' . $i . '" class="button">' . $i . '</a>';
        } ?>
    </div>

<?php
    include 'layout/footer.php';
?>
