<?php function getHint(){
    if (isset($_GET['error'])) { ?>

        <div class="hint error">
            <span class="closebtn" data-behaviour="showhide">&times;</span>
            <?php echo $_GET['error']; ?>
        </div>

    <?php }
    if (isset($_GET['hint'])) {
        $hint = $_GET['hint'];
        if($hint === "logout"){ ?>
            <div class="hint">
                <span class="closebtn" data-behaviour="showhide">&times;</span>
                Du hast die Warteschlange verlassen.
            </div>
        <?php } 
        else if($hint === "new_user"){ ?>
            <div class="hint">
                <span class="closebtn" data-behaviour="showhide">&times;</span>
                Du hast die Warteschlange betreten!
            </div>
        <?php }
        else if($hint === "existing_user"){ ?>
            <div class="hint">
                <span class="closebtn" data-behaviour="showhide">&times;</span>
                Willkommen zurück!
            </div>
        <?php }
        else{ ?>
            <div class="hint">
                <span class="closebtn" data-behaviour="showhide">&times;</span>
                <?php echo $hint ?>
            </div>
        <?php }
    }
}
