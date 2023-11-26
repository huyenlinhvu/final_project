"use strict";

//Auto typing 

// typed text span
const typedTextSpan = document.querySelector(".typed-text");

// stick span
const stick = document.querySelector(".stick");

// List of typing texts
const textList = ["crypto currencies","coins"];

// set delay time
const typeTime = 200;
const eraseTime = 100;
const newTextTime = 1500; // Delay between current and next text
let textListIndex = 0;
let charIndex = 0;

// Typing texts
function type() {
  if (charIndex < textList[textListIndex].length) {
    // add class 'typing'(blink affect) to the stick
    if(!stick.classList.contains("typing")) stick.classList.add("typing");
    
    // add text from textList 
    typedTextSpan.innerText += textList[textListIndex].charAt(charIndex);
    charIndex++;
    setTimeout(type, typeTime);
  } 
  else {
    stick.classList.remove("typing");
  	setTimeout(erase, newTextTime);
  }
}

// Erasing texts
function erase() {
	if (charIndex > 0) {
	  // add class 'typing'(blink affect) to the stick
    if(!stick.classList.contains("typing")) stick.classList.add("typing");
    typedTextSpan.innerText = textList[textListIndex].substring(0, charIndex-1);
    charIndex--;
    setTimeout(erase, eraseTime);
  } 
  else {
    stick.classList.remove("typing");
    textListIndex++;
    if(textListIndex>=textList.length) textListIndex=0;
    setTimeout(type, typeTime + 1100);
  }
}

document.addEventListener("DOMContentLoaded", function() { // On DOM Load initiate the effect
  if(textList.length) setTimeout(type, newTextTime + 250);
});
