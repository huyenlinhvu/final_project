"use strict";

let goback_btn = document.getElementById("goback");

//function to go back previous page
if(goback_btn){
    goback_btn.addEventListener("click", goback);
}

function goback() {
    history.back();
}