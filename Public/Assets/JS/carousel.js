"use strict";
// Select all slides
const slides = document.querySelectorAll(".slide");

// loop through slides and set each slides translateX
slides.forEach((slide, img) => {
  slide.style.transform = `translateX(${img * 100}%)`;
});

//next arrow button
const arrowNext = document.querySelector(".arrow-next");

// current slide counter
let currentSlide = 0;
// maximum number of slides
let maxSlide = slides.length - 1;

// add event listener and navigation functionality
arrowNext.addEventListener("click", function () {
  // check if current slide is the last and reset current slide
  if (currentSlide === maxSlide) {
    currentSlide = 0;
  } else {
    currentSlide++;
  }

  // move slide by -100%
  slides.forEach((slide, img) => {
    slide.style.transform = `translateX(${100 * (img - currentSlide)}%)`;
  });
});

// previous arrow button
const arrowPrev = document.querySelector(".arrow-prev");

// add event listener and navigation functionality
arrowPrev.addEventListener("click", function () {
  // check if current slide is the first and reset current slide to last
  if (currentSlide === 0) {
    currentSlide = maxSlide;
  } else {
    currentSlide--;
  }

  // move slide by 100%
  slides.forEach((slide, img) => {
    slide.style.transform = `translateX(${100 * (img - currentSlide)}%)`;
  });
});
