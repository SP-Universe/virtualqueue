<link rel="stylesheet" href="styles.css">

<?php
    include 'layout/header.php';

    require 'main.php';
    connectmysql();
    $guestid = checkforcookie();
    if($guestid != null){
        if(get_data_from_guest($guestid, "groupid") > $current_group){
            echo '
                <p>Deine Gast-ID: <kbd>' . $guestid . '</kbd></p>
                <p>Deine Position in der Warteschlange: ' . (get_data_from_guest($guestid, "groupid")-$current_group) . ' </p>
            ';
        } else if (get_data_from_guest($guestid, "groupid") == $current_group){
            echo '
                <p>Deine Gast-ID: <kbd>' . $guestid . '</kbd></p>
                <p>Deine Position in der Warteschlange: DU BIST AN DER REIHE!!! </p>
            ';
        } else {
            echo '
                <p>Deine Gast-ID: <kbd>' . $guestid . '</kbd></p>
                <p>Deine Position in der Warteschlange: Es gab einen Fehler... </p>
            ';
        }
    }
?>

<h2>IMPRESSUM</h2>

<p>Hier kommt dann das Impressum hin!</p>

<br>

<p><a href="index.php" class="button">Zurück zur Hauptseite</a></p>

<?php
    include 'layout/footer.php';
?>

<script>
document.addEventListener("DOMContentLoaded", function (event) {
    window.setInterval('refresh()', 30000);
    //Show hide
    let showHideElements = [...document.querySelectorAll('[data-behaviour="showhide"]')];

    showHideElements.forEach((element) => {
        element.addEventListener("click", (e) => {
            e.preventDefault();
            element.parentNode.classList.toggle("hidden")
        })
    });
});

function refresh() {
    window.location.reload();
    window.location.href =  window.location.href.split("?")[0];
}

</script>
