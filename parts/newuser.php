<?php
    function getLayoutForNewUser(){
        ?>

        <p>Klicke hier, um der virtuellen Warteschlange beizutreten:</p>
        <br>
        <p><a href="new_guest.php" class="button">Neuer Platz in der Warteschlange</a></p>
        <br>
        <br>
        <p>Solltest du bereits eine Gast-ID erhalten haben, gebe diese bitte hier ein und klicke dann den Button:</p>
        <br>
        <form method="post" action="existinguser.php">
            <input type="text" name="guestid">
            <input type="submit" value="Absenden" accesskey="s" name="submit">
        </form>

        <?php
    }
?>
