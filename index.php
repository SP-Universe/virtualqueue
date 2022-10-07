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

    const feedbackCard = document.querySelector('#feedback_card');

    const estimatedTimeElement = document.querySelector('#estimated_time');
    const placeinlineNumberElement = document.querySelector('#queue_number');
    console.log("elements found");

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

    function showBanners(data) {
        switch (data.current_status) {
            case "closedbefore":
                closedbeforeBannerElement.style.visibility='visible';
                showclosedBannerElement.style.visibility='hidden';
                maintenanceBannerElement.style.visibility='hidden';
                closedafterBannerElement.style.visibility='hidden';
                estimatedTimeElement.innerText = "--:--";
                break;
            case "showclosed":
                closedbeforeBannerElement.style.visibility='hidden';
                showclosedBannerElement.style.visibility='visible';
                maintenanceBannerElement.style.visibility='hidden';
                closedafterBannerElement.style.visibility='hidden';
                estimatedTimeElement.innerText = "--:--";
                break;
            case "open":
                closedbeforeBannerElement.style.visibility='hidden';
                showclosedBannerElement.style.visibility='hidden';
                maintenanceBannerElement.style.visibility='hidden';
                closedafterBannerElement.style.visibility='hidden';
                estimatedTimeElement.innerText = "--:--";
                break;
            case "maintenance":
                closedbeforeBannerElement.style.visibility='hidden';
                showclosedBannerElement.style.visibility='hidden';
                maintenanceBannerElement.style.visibility='visible';
                closedafterBannerElement.style.visibility='hidden';
                estimatedTimeElement.innerText = "--:--";
                break;
            case "closedafter":
                closedbeforeBannerElement.style.visibility='hidden';
                showclosedBannerElement.style.visibility='hidden';
                maintenanceBannerElement.style.visibility='hidden';
                closedafterBannerElement.style.visibility='visible';
                estimatedTimeElement.innerText = "--:--";
                break;
        }
    }

    function showData(data) {
        if("<?php echo $guestid;?>" != "") {
            let options = {hour: "2-digit", minute: "2-digit"};
            var time = data.estimatedtime;
            time = time.substring(0, time.length - 3);

            if(data.current_group == <?php echo $guestgroup;?>){
                placeinlineNumberElement.innerText = "Komm herein!";
                placeinlineNumberElement.parentElement.classList.add("your_turn");
                estimatedTimeElement.innerText = "Jetzt!";
                feedbackCard.classList.remove("visible");
            } else if (data.current_group < <?php echo $guestgroup;?>){
                placeinlineNumberElement.innerText = guestgroup - data.current_group;
                placeinlineNumberElement.parentElement.classList.remove("your_turn");
                estimatedTimeElement.innerText = time;
                feedbackCard.classList.remove("visible");
            } else if (data.current_group > <?php echo $guestgroup;?>){
                placeinlineNumberElement.innerText = guestgroup - data.current_group;
                placeinlineNumberElement.parentElement.classList.remove("your_turn");
                estimatedTimeElement.innerText = time;
                feedbackCard.classList.add("visible");
            } else {
                placeinlineNumberElement.innerText = guestgroup - data.current_group;
                feedbackCard.classList.remove("visible");
            }

            if(data.current_status == "showclosed"){
                estimatedTimeElement.innerText = time;
            } else if(data.current_status == "maintenance"){
                estimatedTimeElement.innerText = "(" + time + ")";
            } else if(data.current_status == "closedafter"){
                estimatedTimeElement.innerText = "--:--";
            }

            if (parseInt(data.current_group) < parseInt(guestgroup)) {
                audioplayed = false;
            } else if (parseInt(data.current_group) === parseInt(guestgroup)) {

            } else if (parseInt(data.current_group) > parseInt(guestgroup)){
                audioplayed = false;
            }            
        }
    }

    function reloadData(){
        window.history.replaceState({}, document.title, "index.php");
        fetch('status.php')
        .then(response => response.json())
        .then(data => {
            showBanners(data);
            showData(data);
            checkforsound(data);
        });
    }

    setInterval(function(){ 
        reloadData();
    }, 3000);

    reloadData();

</script>
