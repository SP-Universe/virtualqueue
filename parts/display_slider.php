<?php
    function getInfoSlider(){
        ?>
    <div id="slider">
        <ul>
            <li><img src="../app/client/src/images/info_pages/info_1.jpeg" alt="info_page 1"></li>
            <li><img src="../app/client/src/images/info_pages/info_2.jpeg" alt="info_page 2"></li>
            <li><img src="../app/client/src/images/info_pages/info_3.jpeg" alt="info_page 3"></li>
            <li><img src="../app/client/src/images/info_pages/info_4.jpeg" alt="info_page 4"></li>
            <li><img src="../app/client/src/images/info_pages/info_5.jpeg" alt="info_page 5"></li>
            <li><img src="../app/client/src/images/info_pages/info_6.jpeg" alt="info_page 6"></li>
            <li><img src="../app/client/src/images/info_pages/info_7.jpeg" alt="info_page 7"></li>
            <li><img src="../app/client/src/images/info_pages/info_8.jpeg" alt="info_page 8"></li>
            <li><img src="../app/client/src/images/info_pages/info_9.jpeg" alt="info_page 9"></li>
            <li><img src="../app/client/src/images/info_pages/info_10.jpg" alt="info_page 10"></li>
        </ul>  
    </div>

    <script>
        jQuery(document).ready(function ($) {

        setInterval(function () {
            moveRight();
        }, 6000);

        var slideCount = $('#slider ul li').length;
        var slideWidth = $('#slider ul li').width();
        var slideHeight = $('#slider ul li').height();
        var sliderUlWidth = slideCount * slideWidth;
        
        $('#slider').css({ width: slideWidth, height: slideHeight });
        
        $('#slider ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });
        
        $('#slider ul li:last-child').prependTo('#slider ul');

        function moveLeft() {
            $('#slider ul').animate({
                left: + slideWidth
            }, 200, function () {
                $('#slider ul li:last-child').prependTo('#slider ul');
                $('#slider ul').css('left', '');
            });
        };

        function moveRight() {
            $('#slider ul').animate({
                left: - slideWidth
            }, 200, function () {
                $('#slider ul li:first-child').appendTo('#slider ul');
                $('#slider ul').css('left', '');
            });
        };

        $('a.control_prev').click(function () {
            moveLeft();
        });

        $('a.control_next').click(function () {
            moveRight();
        });

        });    

    </script>
<?php } ?>