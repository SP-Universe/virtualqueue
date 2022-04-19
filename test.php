<?php

?>

<div id="myspan"> Laden unmöglich! 
    <p id="group">ERROR</p>
    <p id="status">ERROR</p>
</div>

<script>

const charactersDiv = document.querySelector('#myspan');

function showData(data) {
    
    const groupElement = document.querySelector('#group');
    groupElement.innerText = `Current group: ${data.current_group}`;

    const statusElement = document.querySelector('#status');
    statusElement.innerText = `Current status: ${data.current_status}`;
}


function checkforsound(data){
    currentgroup = data.current_group;
    if(guestgroup == currentgroup){
        if(!audioplayed){
            console.log("Hello world!");
            const audio = new Audio('sound/laugh.wav');
            audio.muted = true;
            audio.play();
            audioplayed = true;
        }
    }
}

function showData(data) {
    const groupElement = document.querySelector('#group');
    groupElement.innerText = `Current group: ${data.current_group}`;

    const statusElement = document.querySelector('#status');
    statusElement.innerText = `Current status: ${data.current_status}`;
}

function reloadData(){
    fetch('status.php')
    .then(response => response.json())
    .then(data => {
        showData(data);
        checkforsound(data);
    });
}

setInterval(function(){ 
	reloadData();
}, 2000);

reloadData();


</script>
