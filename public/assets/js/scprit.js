const img1 = document.getElementById('img1');
const img2 = document.getElementById('img2');

let slideIndex = true;

setInterval(() => {
  if (slideIndex) {
    // img1 keluar kiri
    img1.classList.remove('translate-x-0');
    img1.classList.add('-translate-x-full');

    // img2 masuk dari kanan
    img2.classList.remove('translate-x-full');
    img2.classList.add('translate-x-0');
  } else {
    // reset img1 ke kanan dulu sebelum masuk
    img1.classList.remove('-translate-x-full');
    img1.classList.add('translate-x-full');

    // trigger reflow supaya transisi jalan lagi
    void img1.offsetWidth;

    // img2 keluar kiri
    img2.classList.remove('translate-x-0');
    img2.classList.add('-translate-x-full');

    // img1 masuk dari kanan
    img1.classList.remove('translate-x-full');
    img1.classList.add('translate-x-0');
  }

  slideIndex = !slideIndex;
}, 5000);


const dropmenu = document.getElementById('dropmenu');
const btnmenu = document.getElementById('btnmenu');
const btnclose = document.getElementById('btnclose')
const bgclose = document.getElementById('bgclose')

btnmenu.addEventListener('click', function() {
  dropmenu.classList.toggle('hidden');
});
btnclose.addEventListener('click', function() {
  dropmenu.classList.toggle('hidden')
})
bgclose.addEventListener('click', function () {
  dropmenu.classList.toggle('hidden')
});


const btnFood = document.getElementById("btnfood");
  const btnDrink = document.getElementById("btndrink");
  const carouselFood = document.getElementById("carousel-food");
  const carouselDrink = document.getElementById("carousel-drink");

  // --- Fungsi ubah tombol aktif ---
  function setActive(button) {
    btnFood.classList.remove("bg-[#701D0D]");
    btnDrink.classList.remove("bg-[#701D0D]");

    btnFood.classList.add("bg-[#1B2B28]");
    btnDrink.classList.add("bg-[#1B2B28]");

    button.classList.remove("bg-[#1B2B28]");
    button.classList.add("bg-[#701D0D]",);
  }

  // --- Fungsi ubah tampilan carousel ---
  function showCarousel(type) {
    if (type === "food") {
      carouselFood.classList.remove("opacity-0", "pointer-events-none");
      carouselFood.classList.add("opacity-100", "z-10");

      carouselDrink.classList.add("opacity-0", "pointer-events-none");
      carouselDrink.classList.remove("opacity-100", "z-10");
    } else {
      carouselDrink.classList.remove("opacity-0", "pointer-events-none");
      carouselDrink.classList.add("opacity-100", "z-10");

      carouselFood.classList.add("opacity-0", "pointer-events-none");
      carouselFood.classList.remove("opacity-100", "z-10");
    }
  }

  // --- Event click ---
  btnFood.addEventListener("click", () => {
    setActive(btnFood);
    showCarousel("food");
  });

  btnDrink.addEventListener("click", () => {
    setActive(btnDrink);
    showCarousel("drink");
  });

  // --- Saat pertama kali masuk halaman ---
  setActive(btnDrink);
  showCarousel("drink");
  

  // Fungsi toggle dengan transisi halus
  btnFood.addEventListener("click", () => {
    foodCarousel.classList.remove("opacity-0", "pointer-events-none");
    foodCarousel.classList.add("opacity-100", "z-10");

    drinkCarousel.classList.add("opacity-0", "pointer-events-none");
    drinkCarousel.classList.remove("opacity-100", "z-10");
  });

  btnDrink.addEventListener("click", () => {
    drinkCarousel.classList.remove("opacity-0", "pointer-events-none");
    drinkCarousel.classList.add("opacity-100", "z-10");

    foodCarousel.classList.add("opacity-0", "pointer-events-none");
    foodCarousel.classList.remove("opacity-100", "z-10");
  });

// Fungsi untuk ganti carousel
function setActiveCarousel(type) {
  // Sembunyikan semua carousel
  Object.values(carousels).forEach((c) => c.classList.add("hidden"));

  // Tampilkan carousel aktif
  activeCarousel = carousels[type];
  activeCarousel.classList.remove("hidden");

  // Reset index
  index = 0;

  // Generate ulang dots
  generateDots();
  updateDots();

  // Bind event scroll ulang
  bindScrollEvent();
}

// Tombol switch
document.getElementById("btndrink").addEventListener("click", () => {
  setActiveCarousel("drink");
});

document.getElementById("btnfood").addEventListener("click", () => {
  setActiveCarousel("food");
});

// Init pertama kali (default: drink)
setActiveCarousel("drink");




// const btnFood = document.getElementById("btnfood");
// const btnDrink = document.getElementById("btndrink");
const food = document.getElementById("carousel-food");
const drink = document.getElementById("carousel-drink");

btnFood.addEventListener("click", () => {
  food.classList.remove("hidden");
  drink.classList.add("hidden");
});

btnDrink.addEventListener("click", () => {
  drink.classList.remove("hidden");
  food.classList.add("hidden");
});



const formbillard = document.getElementById("formbillard");
const bookBtn = document.getElementById("bookBtn");

bookBtn.addEventListener("click", () => {
  formbillard.classList.toggle("hidden");
});