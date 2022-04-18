<?php
    require 'main.php';
    include 'layout/header.php';

    connectmysql();

    if(isset($_POST['rating'])){
        if($_POST['rating'] != null){
            add_feedback($_POST['rating'], $_POST['text']);
        }
        else {
            add_feedback(0, $_POST['text']);
        }
    }
?>

<h2>Danke für dein Feedback!</h2>

<p><a href="index.php" class="button">Neu anstellen</a></p>

<?php
close_connection();
    include 'layout/footer.php';
?>
