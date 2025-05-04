document.addEventListener("DOMContentLoaded", () => {
  // Navigation toggle
  const navToggle = document.getElementById("navToggle");
  const closeNav = document.getElementById("closeNav");
  const sidebar = document.getElementById("sidebar");
  const popup = document.getElementById("popupaboutus");

  popup.addEventListener("click", function (event) {
    if (!document.getElementById("divaboutus").contains(event.target)) {
      popup.classList.add("hidden");
    }
  });

  navToggle.addEventListener("click", () => {
    sidebar.classList.toggle("translate-x-full");
  });

  closeNav.addEventListener("click", () => {
    sidebar.classList.add("translate-x-full");
  });

  const navLinks = document.querySelectorAll("#sidebar a, #sidebar button");

  navLinks.forEach((link) => {
    link.addEventListener("click", () => {
      sidebar.classList.add("translate-x-full");
    });
  });

  let finalValue = 0;
  const totalDonation = document.getElementById("totalDonation");

  function animateCounter(element, start, end, duration) {
    let startTime = null;
    function animation(currentTime) {
      if (!startTime) startTime = currentTime;
      const timeElapsed = currentTime - startTime;
      const progress = Math.min(timeElapsed / duration, 1);
      const value = Math.floor(progress * (end - start) + start);

      element.textContent = value.toLocaleString();

      if (progress < 1) {
        requestAnimationFrame(animation);
      }
    }
    requestAnimationFrame(animation);
  }

  async function loadTotalDonation() {
    try {
      const response = await fetch("../backend/getamount.php");
      const data = await response.json();
      finalValue = data.total || 0;
      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            animateCounter(totalDonation, 0, finalValue, 2000);
            observer.unobserve(entry.target);
          }
        });
      });

      observer.observe(totalDonation);
    } catch (error) {
      console.error("error ambil total donasi:", error);
    }
  }

  loadTotalDonation();

  let donorsData = [];

  fetch("../backend/getdonors.php")
    .then((res) => res.json())
    .then((data) => {
      donorsData = data;
      renderLeaderboard(donorsData, "recent");
    })
    .catch((err) => {
      console.error("gagal ambil data donor:", err);
    });

  function renderLeaderboard(donors, sortBy = "recent") {
    const leaderboardList = document.getElementById("leaderboardList");
    leaderboardList.innerHTML = "";

    const sortedDonors = [...donors];

    if (sortBy === "recent") {
      sortedDonors.sort((a, b) => new Date(b.date) - new Date(a.date));
    } else if (sortBy === "most") {
      sortedDonors.sort((a, b) => b.amount - a.amount);
    }

    sortedDonors.forEach((donor) => {
      const donationDate = new Date(donor.date);
      const formattedDate = donationDate.toLocaleDateString("id-ID", {
        day: "numeric",
        month: "short",
        year: "numeric",
      });

      const donationCard = document.createElement("div");
      donationCard.className =
        "donation-card bg-white p-3 md:p-5 lg:p-5 max-w-[30rem] md:max-w-[38rem] lg:max-w-[38rem] rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-all";
      donationCard.innerHTML = `    
        <div class="relative flex min-h-[3rem] min-w-[calc(100vw-4rem)] md:min-w-0 lg:min-w-0 justify-between items-center">
            <div>
              <h4 class="font-bold md:text-[18px] lg:text-[18px]">${
                donor.name
              }</h4>
              <p class="text-[14px] max-w-54 md:max-w-full lg:max-w-full md:text-[15px] lg:text-[15px] text-gray-600 md:mt-1 lg:mt-1">${
                donor.message || " "
              }</p>
            </div>
            <span class="text-[14px] md:text-[1rem] lg:text-[1rem] py-1 px-2 md:py-2 lg:py-2 md:px-4 lg:px-4 shadow-md rounded-full bg-[#239541] text-white">${
              donor.amount
            } kg</span>
            
            <p class="absolute -bottom-3 -right-2 text-[10px] md:text-xs lg:text-xs text-gray-400 mt-1">${formattedDate}</p>
          </div>
        `;

      leaderboardList.appendChild(donationCard);
    });
  }

  const recentBtn = document.getElementById("recentBtn");
  const mostKgBtn = document.getElementById("mostKgBtn");
  const searchBtn = document.getElementById("searchBtn");
  const searchInput = document.getElementById("searchDonor");

  recentBtn.addEventListener("click", () => {
    recentBtn.classList.remove(
      "bg-white",
      "shadow-lg",
      "bg-gray-200",
      "text-gray-400"
    );
    recentBtn.classList.add("bg-white", "shadow-lg");

    mostKgBtn.classList.remove(
      "bg-white",
      "shadow-lg",
      "bg-gray-200",
      "text-gray-400"
    );
    mostKgBtn.classList.add("bg-gray-200", "text-gray-400");

    renderLeaderboard(donorsData, "recent");
  });

  mostKgBtn.addEventListener("click", () => {
    mostKgBtn.classList.remove(
      "bg-white",
      "shadow-lg",
      "bg-gray-200",
      "text-gray-400"
    );
    mostKgBtn.classList.add("bg-white", "shadow-lg");

    recentBtn.classList.remove(
      "bg-white",
      "shadow-lg",
      "text-gray-400",
      "bg-gray-200"
    );
    recentBtn.classList.add("bg-gray-200", "text-gray-400");

    renderLeaderboard(donorsData, "most");
  });

  searchBtn.addEventListener("click", () => {
    const searchTerm = searchInput.value.toLowerCase().trim();
    if (searchTerm) {
      const filteredDonors = donorsData.filter((donor) =>
        donor.name.toLowerCase().includes(searchTerm)
      );
      renderLeaderboard(filteredDonors, "recent");
    } else {
      renderLeaderboard(donorsData, "recent");
    }
  });

  searchInput.addEventListener("keyup", (e) => {
    if (e.key === "Enter") {
      searchBtn.click();
    }
  });

  searchInput.addEventListener("input", () => {
    searchBtn.click();
  });

  let eventsData = [];

  async function loadEventsData() {
    try {
      const res = await fetch("../backend/getevents.php");
      const data = await res.json();

      eventsData = data.map((event) => ({
        title: event.title,
        date: event.date,
        time: event.time,
        location: event.location,
        image: event.image,
        registrationLink: event.formurl,
      }));
    } catch (err) {
      console.error("gagal ngambil data event:", err);
    }
    const eventsWrapper = document.querySelector(
      ".eventsSwiper .swiper-wrapper"
    );
    eventsData.forEach((event) => {
      const eventDate = new Date(event.date);
      const formattedDate = eventDate.toLocaleDateString("id-ID", {
        day: "numeric",
        month: "long",
        year: "numeric",
      });

      const slide = document.createElement("div");
      slide.className = "swiper-slide";
      slide.style.backgroundImage = `url(${event.image})`;

      slide.innerHTML = `
        <div class="event-content absolute bottom-0 left-0 w-full right-0 p-5 text-white">
  <h3 class="lg:text-xl md:text-xl font-bold mb-2">${event.title}</h3>
  
  <div class="flex justify-between items-end">
    
    <div class="flex mb-3 flex-col gap-1 w-[50%]">
      <div class="flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 448 512"><path fill="#ffffff" d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40L64 64C28.7 64 0 92.7 0 128l0 16 0 48L0 448c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-256 0-48 0-16c0-35.3-28.7-64-64-64l-40 0 0-40c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40L152 64l0-40zM48 192l352 0 0 256c0 8.8-7.2 16-16 16L64 464c-8.8 0-16-7.2-16-16l0-256z"/></svg>
        <span class="text-[0.9rem] lg:text-[1rem] md:text-[1rem]">${formattedDate}</span>
      </div>
      <div class="flex gap-2 items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 512 512"><path fill="#ffffff" d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120l0 136c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2 280 120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/></svg>
        <span class="text-[0.9rem] lg:text-[1rem] md:text-[1rem]">${
          event.time
        }</span>
      </div>
      <div class="flex gap-2 items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 384 512"><path fill="#ffffff" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>
        <span
    class="underline cursor-pointer text-[0.9rem] lg:text-[1rem] md:text-[1rem]"
    onclick="window.open('https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(
      event.location
    )}', '_blank')"
  >
    ${shortenString(event.location)}
  </span>
      </div>
    </div>

    <a target="_blank" rel="noopener noreferrer" href="${
      event.registrationLink
    }" class="inline-block bg-sunset text-white font-medium py-2 px-10 lg:py-3 lg:px-14 md:py-3 md:px-14 rounded-full transition duration-300">
      Daftar
    </a>
  </div>
</div>

      `;

      eventsWrapper.appendChild(slide);
    });

    function shortenString(str) {
      if (str.length > 19) {
        return str.slice(0, 19) + "...";
      }
      return str;
    }

    // Initialize Swiper
    const swiper = new Swiper(".eventsSwiper", {
      slidesPerView: 1,
      spaceBetween: 30,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      breakpoints: {
        640: {
          slidesPerView: 2,
          spaceBetween: 20,
        },
        1024: {
          slidesPerView: 3,
          spaceBetween: 30,
        },
      },
    });
  }

  loadEventsData();

  // Fungsi untuk mengambil data events dan render ke dalam #testimonials
  async function loadEventsStatusData() {
    try {
      // Ambil data dari backend PHP
      const response = await fetch("../backend/geteventsstatus.php");
      const eventsData = await response.json();

      const testimonialsContainer = document.getElementById(
        "testimonials-container"
      );

      // Pastikan container kosong sebelum render ulang
      testimonialsContainer.innerHTML = "";

      // Loop setiap event dan buat card-nya
      eventsData.forEach((event) => {
        // Gunakan innerHTML untuk langsung membuat konten HTML
        testimonialsContainer.innerHTML += `
          <div class="relative lg:w-[46%] md:w-[46%] w-full p-5 bg-white rounded-lg flex flex-col">
            <div class="rotate-12 absolute flex justify-center items-center text-white -right-6 -top-6 md:-right-8 md:-top-8 lg:-right-8 lg:-top-8 size-20 bg-no-repeat bg-center bg-cover" style="background-image: url(img/badge.png)">
              <p class="font-semibold uppercase text-[0.9rem]">${
                event.status === "1" ? "TUNTAS" : "PENDING"
              }</p>
            </div>
  
            <!-- Judul Event -->
            <h3 class="font-black text-[20px]">${event.daerah}</h3>
  
            <!-- Lokasi -->
            <p>${event.lokasi}</p>
  
            <!-- Sampah Terkumpul -->
            <p class="text-white bg-[#239541] mt-2 py-1 px-4 rounded-full w-fit">
              ${event.sampah}kg Sampah
            </p>
  
            <!-- Story / Deskripsi Event -->
            <p class="text-black mt-5">
              ${event.story}
            </p>
          </div>
        `;
      });
    } catch (err) {
      console.log("Error fetching events data:", err);
    }
  }

  loadEventsStatusData();

  const donationForm = document.getElementById("donationForm");
  const amountButtons = document.querySelectorAll(".amount-btn");
  const amountInput = document.getElementById("amount");

  amountButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      amountButtons.forEach((b) => b.classList.remove("text-white"));
      amountButtons.forEach((b) => b.classList.remove("bg-[#113259]"));
      amountButtons.forEach((b) => b.classList.add("bg-[#edf2f7]"));
      btn.classList.remove("bg-[#edf2f7]");
      btn.classList.add("bg-[#113259]");
      btn.classList.add("text-white");

      amountInput.value = btn.getAttribute("data-amount");
    });
  });

  amountInput.addEventListener("input", () => {
    amountButtons.forEach((b) => b.classList.remove("text-white"));
    amountButtons.forEach((b) => b.classList.remove("bg-[#113259]"));
    amountButtons.forEach((b) => b.classList.add("bg-[#edf2f7]"));
  });

  donationForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const number = "082822961182"; // kalau ini fixed, ga perlu dimasukin dari form
    const amount = Number.parseInt(document.getElementById("amount").value);
    const message = document.getElementById("message").value;

    const data = {
      name,
      email,
      number,
      amount,
    };

    try {
      const res = await fetch("../backend/app.php", {
        method: "POST",
        body: JSON.stringify(data),
      });
      const token = await res.text();

      window.snap.pay(token, {
        onSuccess: async function (result) {
          const kgAmount = amount / 1000;
          const newDonation = {
            name: name,
            amount: kgAmount,
            message: message,
            date: new Date().toISOString(),
          };

          // Mengirim donasi yang baru ke database
          try {
            const submitRes = await fetch("../backend/adddonors.php", {
              method: "POST",
              body: new URLSearchParams({
                name: name,
                email: email,
                amount: kgAmount,
                message: message,
              }),
            });

            const submitData = await submitRes.json();
            if (submitData.success) {
              // Update data dan leaderboard setelah berhasil submit ke database
              donorsData.unshift(newDonation);

              const currentTotal = Number.parseInt(
                totalDonation.textContent.replace(/,/g, "")
              );
              const newTotal = currentTotal + kgAmount;
              animateCounter(totalDonation, currentTotal, newTotal, 1000);

              renderLeaderboard(donorsData, "recent");
            } else {
              alert("Gagal menambah donasi ke database: " + submitData.message);
            }
          } catch (err) {
            console.error("Error saat kirim data ke database:", err);
            alert("Ada masalah saat menambahkan donasi.");
          }

          donationForm.reset();
          amountButtons.forEach((b) => b.classList.remove("text-white"));
          amountButtons.forEach((b) => b.classList.remove("bg-[#113259]"));
          amountButtons.forEach((b) => b.classList.add("bg-[#edf2f7]"));

          console.log(result);
        },
        onPending: function (result) {
          console.log("waiting your payment!");
          console.log(result);
        },
        onError: function (result) {
          console.log("payment failed!");
          console.log(result);
        },
        onClose: function () {
          console.log("you closed the popup without finishing the payment");
        },
      });
    } catch (err) {
      console.log("error:", err.message);
    }
  });
});
