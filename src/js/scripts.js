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

/* -------------------------------- Preloader ------------------------------- */
flatPreloaderInit()

function flatPreloaderInit() {
  const sleep = timeout => new Promise(resolve => setTimeout(resolve, timeout))
  const overlayEl = document.getElementById('flat-preloader-overlay')
  const showPreloaderInstantly = true

  // Fix error loading screen does not disappear when clicking on back button
  window.onpageshow = function (event) {
    if (event.persisted) {
      window.location.reload()
    }
  };

  window.addEventListener('load', async function () {

    await sleep(1000)

    document.body.classList.remove('flat-preloader-active')
    overlayEl.classList.add('hide')

    await sleep(300)

    // Show the preloader immediately
    if (showPreloaderInstantly) {
      document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', e => {
          let href = link.getAttribute('href')
          e.preventDefault()
          document.body.classList.add('flat-preloader-active')
          overlayEl.classList.remove('hide')
          window.location.href = href
        })
      })
    }
  })

}
