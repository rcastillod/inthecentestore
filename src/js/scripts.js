/* ------------------------------- Hero SLider ------------------------------ */
let swiper = new Swiper("#heroSlider", {
  loop: false,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  autoplay: false,
  // autoplay: {
  //   delay: 8000,
  //   disableOnInteraction: true,
  // },
});