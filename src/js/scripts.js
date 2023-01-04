/* ------------------------------- Hero SLider ------------------------------ */
let swiper = new Swiper("#heroSlider", {
  lazy: true,
  loop: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  autoplay: {
    delay: 8000,
    disableOnInteraction: true,
  },
});
