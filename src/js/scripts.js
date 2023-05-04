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

/* ---------------------- Validate rut field and format --------------------- */

// Validate rut
const validateRUT = (rut) => {
  var regex = /^0*(\d{1,3}(\.?\d{3})*)\-?([\dkK])$/;
  if (!regex.test(rut)) {
    return false;
  }
  rut = rut.replace(/\./g, '').replace('-', '');
  var dv = rut.slice(-1).toUpperCase();
  var rutNum = parseInt(rut.slice(0, -1));
  var M = 0, S = 1;
  for (; rutNum; rutNum = Math.floor(rutNum / 10)) {
    S = (S + rutNum % 10 * (9 - M++ % 6)) % 11;
  }
  return (dv == (S ? S - 1 + '' : 'K'));
}

// Format rut
const formatRUT = (rutField) => {
  var rut = rutField.value.replace(/\D/g, '');
  rut = rut.replace(/^0+/, '');
  if (rut.length > 1) {
    rut = rut.replace(/^(\d{1,8})(\d{1})$/, '$1-$2');
  } else {
    rut = rut.replace(/(\d)(?=(\d{3})+$)/g, '$1.');
  }
  rutField.value = rut;
}

// Get the billing_rut field
const rutField = document.getElementById('billing_rut');

if (rutField) {
  rutField.addEventListener('keyup', function () {
    formatRUT(rutField);
  });
  rutField.addEventListener('focusout', function () {
    if (!validateRUT(rutField.value) && !rutField.value == '') {
      alert('El RUT no es valido');
      rutField.value = ''
      rutField.focus()
    }
  });
}