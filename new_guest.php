<?php 
    include 'layout/header.php';
    require 'main.php';
    
?>

    <h2>Wieviele Personen sind in deiner Gruppe?</h2>
    <div class="numberlist">
        <?php
        for($i=1;$i<$max_vq_users_per_group+1;$i++){
            echo'<a href="userpage.php?new_guests=' . $i . '" class="button">' . $i . '</a>';
        } ?>
    </div>
    <p>(Wenn ihr mehr als 10 Personen seid, müsst ihr euch bitte aufteilen)</p>

<?php
    include 'layout/footer.php';
?>
