document.addEventListener("DOMContentLoaded", () => {
  // Navigation toggle
  const navToggle = document.getElementById("navToggle");
  const closeNav = document.getElementById("closeNav");
  const sidebar = document.getElementById("sidebar");

  navToggle.addEventListener("click", () => {
    sidebar.classList.toggle("translate-x-full");
  });

  closeNav.addEventListener("click", () => {
    sidebar.classList.add("translate-x-full");
  });

  // Close sidebar when clicking on a link
  const navLinks = document.querySelectorAll("#sidebar a");
  navLinks.forEach((link) => {
    link.addEventListener("click", () => {
      sidebar.classList.add("translate-x-full");
    });
  });

  // Donation counter animation
  const totalDonation = document.getElementById("totalDonation");
  const finalValue = Number.parseInt(
    totalDonation.textContent.replace(/,/g, "")
  );

  function animateCounter(element, start, end, duration) {
    let startTime = null;

    function animation(currentTime) {
      if (!startTime) startTime = currentTime;
      const timeElapsed = currentTime - startTime;
      const progress = Math.min(timeElapsed / duration, 1);
      const value = Math.floor(progress * (end - start) + start);

      element.textContent = value.toLocaleString();

      if (timeElapsed < duration) {
        requestAnimationFrame(animation);
      } else {
        element.textContent = end.toLocaleString();
      }
    }

    requestAnimationFrame(animation);
  }

  // Start animation when element is in viewport
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        animateCounter(totalDonation, 0, finalValue, 2000);
        observer.unobserve(entry.target);
      }
    });
  });

  observer.observe(totalDonation);

  // Sample data for leaderboard
  const donorsData = [
    {
      name: "Budi Santoso",
      amount: 500,
      message: "Untuk Indonesia yang lebih bersih!",
      date: "2023-09-15T08:30:00",
    },
    {
      name: "Siti Rahayu",
      amount: 1000,
      message: "Semoga membantu",
      date: "2023-09-14T14:45:00",
    },
    {
      name: "Ahmad Hidayat",
      amount: 300,
      message: "Lanjutkan perjuangan!",
      date: "2023-09-13T10:20:00",
    },
    {
      name: "Dewi Lestari",
      amount: 750,
      message: "Untuk masa depan anak-anak kita",
      date: "2023-09-12T16:15:00",
    },
    {
      name: "Joko Widodo",
      amount: 2000,
      message: "Mari jaga lingkungan bersama",
      date: "2023-09-11T09:00:00",
    },
    {
      name: "Ratna Sari",
      amount: 450,
      message: "Semoga bermanfaat",
      date: "2023-09-10T11:30:00",
    },
    {
      name: "Hendra Wijaya",
      amount: 600,
      message: "Untuk Indonesia bersih",
      date: "2023-09-09T13:45:00",
    },
    {
      name: "Maya Indah",
      amount: 350,
      message: "Semangat terus!",
      date: "2023-09-08T15:20:00",
    },
    {
      name: "Dian Sastro",
      amount: 1500,
      message: "Dukung gerakan ini!",
      date: "2023-09-07T10:10:00",
    },
    {
      name: "Rudi Hartono",
      amount: 250,
      message: "Semoga sukses",
      date: "2023-09-06T14:30:00",
    },
    {
      name: "Nina Zatulini",
      amount: 800,
      message: "Untuk lingkungan yang lebih baik",
      date: "2023-09-05T09:45:00",
    },
    {
      name: "Andi Malarangeng",
      amount: 400,
      message: "Lanjutkan!",
      date: "2023-09-04T16:00:00",
    },
    {
      name: "Putri Marino",
      amount: 900,
      message: "Semoga bisa membantu",
      date: "2023-09-03T11:15:00",
    },
    {
      name: "Rizky Febian",
      amount: 700,
      message: "Untuk Indonesia",
      date: "2023-09-02T13:30:00",
    },
    {
      name: "Maudy Ayunda",
      amount: 1200,
      message: "Bangga dengan gerakan ini",
      date: "2023-09-01T10:00:00",
    },
  ];

  // Function to render leaderboard
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
        "donation-card bg-white p-4 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-all";
      donationCard.innerHTML = `
          <div class="flex justify-between items-start">
            <div>
              <h4 class="font-semibold text-green-800">${donor.name}</h4>
              <p class="text-sm text-gray-600 mt-1">${
                donor.message || "Tidak ada pesan"
              }</p>
            </div>
            <div class="text-right">
              <span class="font-bold text-green-700">${donor.amount} kg</span>
              <p class="text-xs text-gray-500 mt-1">${formattedDate}</p>
            </div>
          </div>
        `;

      leaderboardList.appendChild(donationCard);
    });
  }

  // Initial render of leaderboard
  renderLeaderboard(donorsData, "recent");

  // Leaderboard controls
  const recentBtn = document.getElementById("recentBtn");
  const mostKgBtn = document.getElementById("mostKgBtn");
  const searchBtn = document.getElementById("searchBtn");
  const searchInput = document.getElementById("searchDonor");

  recentBtn.addEventListener("click", () => {
    recentBtn.classList.remove("bg-green-100", "text-green-800");
    recentBtn.classList.add("bg-green-600", "text-white");

    mostKgBtn.classList.remove("bg-green-600", "text-white");
    mostKgBtn.classList.add("bg-green-100", "text-green-800");

    renderLeaderboard(donorsData, "recent");
  });

  mostKgBtn.addEventListener("click", () => {
    mostKgBtn.classList.remove("bg-green-100", "text-green-800");
    mostKgBtn.classList.add("bg-green-600", "text-white");

    recentBtn.classList.remove("bg-green-600", "text-white");
    recentBtn.classList.add("bg-green-100", "text-green-800");

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

  // Sample data for upcoming events
  const eventsData = [
    {
      title: "Bersih-Bersih Pantai Kuta",
      date: "2023-10-15",
      time: "08:00 - 12:00",
      location: "Pantai Kuta, Bali",
      image:
        "https://images.unsplash.com/photo-1618477461853-cf6ed80faba5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
      registrationLink: "#",
    },
    {
      title: "Pembersihan Sungai Ciliwung",
      date: "2023-10-22",
      time: "07:30 - 11:30",
      location: "Sungai Ciliwung, Jakarta",
      image:
        "https://images.unsplash.com/photo-1605600659873-d808a13e4d2a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
      registrationLink: "#",
    },
    {
      title: "Aksi Bersih Selokan Kampung",
      date: "2023-10-29",
      time: "09:00 - 13:00",
      location: "Kampung Melayu, Jakarta Timur",
      image:
        "https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
      registrationLink: "#",
    },
    {
      title: "Bersih-Bersih Pantai Ancol",
      date: "2023-11-05",
      time: "08:00 - 12:00",
      location: "Pantai Ancol, Jakarta Utara",
      image:
        "https://images.unsplash.com/photo-1622403721051-3c170b65c0e1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1632&q=80",
      registrationLink: "#",
    },
    {
      title: "Pembersihan Hutan Mangrove",
      date: "2023-11-12",
      time: "07:30 - 11:30",
      location: "Hutan Mangrove, Surabaya",
      image:
        "https://images.unsplash.com/photo-1621451537084-482c73073a0f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80",
      registrationLink: "#",
    },
  ];

  // Initialize Swiper for events
  const eventsWrapper = document.querySelector(".eventsSwiper .swiper-wrapper");

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
        <div class="event-content absolute bottom-0 left-0 right-0 p-6 text-white">
          <h3 class="text-xl font-bold mb-2">${event.title}</h3>
          <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 mb-3">
            <div class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <span>${formattedDate}</span>
            </div>
            <div class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>${event.time}</span>
            </div>
            <div class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span>${event.location}</span>
            </div>
          </div>
          <a href="${event.registrationLink}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition duration-300">
            Daftar Sekarang
          </a>
        </div>
      `;

    eventsWrapper.appendChild(slide);
  });

  // Initialize Swiper
  const swiper = new Swiper(".eventsSwiper", {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
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

  // Sample data for Instagram posts
  const instagramData = [
    {
      image:
        "https://images.unsplash.com/photo-1567095761054-7a02e69e5c43?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80",
      caption:
        "Terima kasih kepada 50+ relawan yang bergabung dalam kegiatan bersih-bersih pantai kemarin! #BebersihID",
      likes: 124,
      date: "2023-09-10",
    },
    {
      image:
        "https://images.unsplash.com/photo-1610147323479-a7fb11ffd5dd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80",
      caption:
        "Sampah plastik masih menjadi masalah utama di perairan kita. Mari kurangi penggunaan plastik sekali pakai! #BebersihID #PlastikFree",
      likes: 98,
      date: "2023-09-08",
    },
    {
      image:
        "https://images.unsplash.com/photo-1591100509036-ddd58f917292?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80",
      caption:
        "Hari ini kami berhasil mengumpulkan lebih dari 200kg sampah dari Sungai Ciliwung. Terima kasih untuk semua relawan! #BebersihID",
      likes: 156,
      date: "2023-09-05",
    },
    {
      image:
        "https://images.unsplash.com/photo-1604187351574-c75ca79f5807?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
      caption:
        "Edukasi tentang pemilahan sampah di SD Negeri 03 Jakarta. Anak-anak sangat antusias! #BebersihID #Edukasi",
      likes: 87,
      date: "2023-09-03",
    },
    {
      image:
        "https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
      caption:
        "Selokan bersih, banjir berkurang! Kegiatan bersih-bersih selokan di Kampung Melayu. #BebersihID",
      likes: 112,
      date: "2023-09-01",
    },
    {
      image:
        "https://images.unsplash.com/photo-1621451537084-482c73073a0f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80",
      caption:
        "Donasi dari Anda telah membantu kami mengangkat 5000kg sampah bulan ini! Terima kasih! #BebersihID #Donasi",
      likes: 203,
      date: "2023-08-28",
    },
    {
      image:
        "https://images.unsplash.com/photo-1618477461853-cf6ed80faba5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
      caption:
        "Persiapan untuk kegiatan bersih-bersih pantai minggu depan. Daftar sekarang! Link di bio. #BebersihID",
      likes: 76,
      date: "2023-08-25",
    },
    {
      image:
        "https://images.unsplash.com/photo-1622403721051-3c170b65c0e1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1632&q=80",
      caption:
        "Kolaborasi dengan komunitas lokal untuk membersihkan pantai Ancol. Bersama kita bisa! #BebersihID",
      likes: 134,
      date: "2023-08-22",
    },
  ];

  // Render Instagram feed
  const instagramFeed = document.getElementById("instagramFeed");

  instagramData.forEach((post) => {
    const postDate = new Date(post.date);
    const formattedDate = postDate.toLocaleDateString("id-ID", {
      day: "numeric",
      month: "short",
      year: "numeric",
    });

    const postElement = document.createElement("div");
    postElement.className =
      "instagram-item rounded-lg overflow-hidden shadow-md";

    postElement.innerHTML = `
        <img src="${post.image}" alt="Instagram post" class="w-full h-64 object-cover">
        <div class="instagram-overlay">
          <p class="text-sm line-clamp-2">${post.caption}</p>
          <div class="flex items-center mt-2 text-xs">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            <span>${post.likes} suka</span>
            <span class="ml-auto">${formattedDate}</span>
          </div>
        </div>
      `;

    instagramFeed.appendChild(postElement);
  });

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

  donationForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const amount = Number.parseInt(document.getElementById("amount").value);
    const message = document.getElementById("message").value;

    // Calculate kg from amount (Rp 10,000 = 10kg)
    const kgAmount = amount / 1000;

    // In a real application, you would send this data to a server
    // For demo purposes, we'll just add it to our local data and refresh the leaderboard
    const newDonation = {
      name: name,
      amount: kgAmount,
      message: message,
      date: new Date().toISOString(),
    };

    donorsData.unshift(newDonation);

    // Update total donation counter
    const currentTotal = Number.parseInt(
      totalDonation.textContent.replace(/,/g, "")
    );
    const newTotal = currentTotal + kgAmount;
    animateCounter(totalDonation, currentTotal, newTotal, 1000);

    // Refresh leaderboard
    renderLeaderboard(donorsData, "recent");

    // Reset form
    donationForm.reset();

    // Show success message
    alert(
      "Terima kasih atas donasi Anda! " +
        kgAmount +
        "kg sampah akan diangkat berkat bantuan Anda."
    );
  });
});
