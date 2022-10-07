<?php function getHint(){
    if (isset($_GET['error'])) { ?>

        <div class="hint error">
            <p class="closebtn" data-behaviour="showhide">&times;</p>
            <?php echo $_GET['error']; ?>
        </div>

    <?php }
    if (isset($_GET['hint'])) {
        $hint = $_GET['hint'];
        if($hint === "logout"){ ?>
            <div class="hint">
                <p>Du hast die Warteschlange verlassen.</p>
                <p class="closebtn" data-behaviour="showhide">&times;</p>
            </div>
        <?php } 
        else if($hint === "new_user"){ ?>
            <div class="hint">
                <p>Du hast die Warteschlange betreten!</p>
                <p class="closebtn" data-behaviour="showhide">&times;</p>
            </div>
        <?php }
        else if($hint === "existing_user"){ ?>
            <div class="hint">
                <p>Willkommen zurück!</p>
                <p class="closebtn" data-behaviour="showhide">&times;</p>
            </div>
        <?php }
        else{ ?>
            <div class="hint">
                <p><?php echo $hint ?></p>
                <p class="closebtn" data-behaviour="showhide">&times;</p>
            </div>
        <?php }
    }
}
