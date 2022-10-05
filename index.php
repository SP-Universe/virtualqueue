<?php 
    require 'layout/header.php';
    require 'parts/hints.php';
    require 'parts/banners.php';
    require 'parts/newuser.php';
    require 'parts/waitinguser.php';
    require 'main.php';
    connectmysql();

    $guestid = checkforcookie();
    $guestgroup = get_data_from_guest($guestid, "groupid");

    getHint();
    getBanner();

            if($guestid === null){
                getLayoutForNewUser();
            } else {
                getLayoutForWaitingUser($guestid, $guestgroup);
            }
            close_connection();
        include 'layout/footer.php';
    ?>

<audio id="sound">
    <source src="sound/laugh.ogg">
</audio>

<script> 
    var audioplayed = false;
    var guestgroup;
    var currentgroup;

    var guestgroup = "<?php echo "$guestgroup";?>";

    const sound = document.querySelector('#sound');

    const closedbeforeBannerElement = document.querySelector('#closedbefore_banner');
    const showclosedBannerElement = document.querySelector('#showclosed_banner');
    const maintenanceBannerElement = document.querySelector('#maintenance_banner');
    const closedafterBannerElement = document.querySelector('#closedafter_banner');

    const placeinlineBeforeElement = document.querySelector('#placeinline_before');
    const placeinlineFinishedElement = document.querySelector('#placeinline_finished');
    const placeinlineFeedbackElement = document.querySelector('#placeinline_feedback');

    const estimatedTimeElement = document.querySelector('#estimated_time');

    const placeinlineNumberElement = document.querySelector('#placeinline_number');

    document.addEventListener("DOMContentLoaded", function (event) {
        //Show hide
        let showHideElements = [...document.querySelectorAll('[data-behaviour="showhide"]')];

        showHideElements.forEach((element) => {
            element.addEventListener("click", (e) => {
                e.preventDefault();
                element.parentNode.classList.toggle("hidden")
            })
        });

        currentgroup = "<?php echo"$current_group";?>";
        
    });

    function checkforsound(data){
        currentgroup = data.current_group;
        if(guestgroup == currentgroup){
            if(!audioplayed){
                sound.play();
                audioplayed = true;
            }
        }
    }

    function showData(data) {
        if("<?php echo $guestid;?>" != "") {
            let options = {hour: "2-digit", minute: "2-digit"}; 
            //var time = new Date ("1970-01-01 " + data.estimatedtime);
            var time = data.estimatedtime;
            if(data.current_status == "closedbefore"){
                closedbeforeBannerElement.style.visibility='visible';
                showclosedBannerElement.style.visibility='hidden';
                maintenanceBannerElement.style.visibility='hidden';
                closedafterBannerElement.style.visibility='hidden';
                estimatedTimeElement.innerText = "Warteschlange geschlossen";
            } else if(data.current_status == "showclosed"){
                closedbeforeBannerElement.style.visibility='hidden';
                showclosedBannerElement.style.visibility='visible';
                maintenanceBannerElement.style.visibility='hidden';
                closedafterBannerElement.style.visibility='hidden';
                //estimatedTimeElement.innerText = "Vorraussichtliche Eintrittszeit: " + time.toLocaleTimeString('de-de', options);
                estimatedTimeElement.innerText = "Vorraussichtlicher Einlass: " + time.substring(0, time.length - 3);
            } else if(data.current_status == "maintenance"){
                closedbeforeBannerElement.style.visibility='hidden';
                showclosedBannerElement.style.visibility='hidden';
                maintenanceBannerElement.style.visibility='visible';
                closedafterBannerElement.style.visibility='hidden';
                estimatedTimeElement.innerText = "Es kann aktuell zu Verzögerungen kommen";
            } else if(data.current_status == "closedafter"){
                closedbeforeBannerElement.style.visibility='hidden';
                showclosedBannerElement.style.visibility='hidden';
                maintenanceBannerElement.style.visibility='hidden';
                closedafterBannerElement.style.visibility='visible';
                estimatedTimeElement.innerText = "Warteschlange geschlossen";
            } else {
                closedbeforeBannerElement.style.visibility='hidden';
                showclosedBannerElement.style.visibility='hidden';
                maintenanceBannerElement.style.visibility='hidden';
                closedafterBannerElement.style.visibility='hidden';
                
                //estimatedTimeElement.innerText = "Vorraussichtliche Eintrittszeit: " + time.toLocaleTimeString('de-de', options);
                estimatedTimeElement.innerText = "Vorraussichtlicher Einlass: " + time.substring(0, time.length - 3);
            }

            if (parseInt(data.current_group) < parseInt(guestgroup)) {
                placeinlineBeforeElement.style.visibility='visible';
                placeinlineBeforeElement.style.height='auto';
                placeinlineFinishedElement.style.visibility='hidden';
                placeinlineFinishedElement.style.height='0px';
                placeinlineFeedbackElement.style.visibility='hidden';
                placeinlineFeedbackElement.style.height='0px';
                audioplayed = false;
            } else if (parseInt(data.current_group) === parseInt(guestgroup)) {
                placeinlineBeforeElement.style.visibility='hidden';
                placeinlineBeforeElement.style.height='0px';
                placeinlineFinishedElement.style.visibility='visible';
                placeinlineFinishedElement.style.height='auto';
                placeinlineFeedbackElement.style.visibility='hidden';
                placeinlineFeedbackElement.style.height='0px';
            } else if (parseInt(data.current_group) > parseInt(guestgroup)){
                audioplayed = false;
                placeinlineBeforeElement.style.visibility='hidden';
                placeinlineBeforeElement.style.height='0px';
                placeinlineFinishedElement.style.visibility='hidden';
                placeinlineFinishedElement.style.height='0px';
                placeinlineFeedbackElement.style.visibility='visible';
                placeinlineFeedbackElement.style.height='auto';
            }

            placeinlineNumberElement.innerText = guestgroup - data.current_group;
        }
    }

    function reloadData(){
        window.history.replaceState({}, document.title, "index.php");
        fetch('status.php')
        .then(response => response.json())
        .then(data => {
            showData(data);
            checkforsound(data);
        });
    }

    setInterval(function(){ 
        reloadData();
    }, 5000);

    reloadData();

</script>
