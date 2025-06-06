<?php
include("conn.php");

$getamount_query = "SELECT SUM(amount) AS total_amount FROM donors";
$getamount_result = $conn->query($getamount_query);
$total_donation = $getamount_result->fetch_assoc()['total_amount'] ?? 0;

$getevents_sql = "SELECT * FROM events ORDER BY date ASC";
$getevents_result = $conn->query($getevents_sql);
$events = [];
if ($getevents_result->num_rows > 0) {
  while ($row = $getevents_result->fetch_assoc()) {
    $events[] = $row;
  }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="../img/icon.svg" type="image/x-icon">
  <title>Bebersih.id - Jadilah bagian dari sejarah</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;900&display=swap"
    rel="stylesheet" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="tailwind.config.js"></script>
  <script
    type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="SB-Mid-client-JgBC92QzBiJcAc1g"></script>
  <link rel="stylesheet" href="styles.css" />
</head>

<body
  class="relative font-montserrat bg-[#f8f8f8] text-[#113259] overflow-x-hidden">
  <button
    id="navToggle"
    class="fixed top-6 right-6 z-40 bg-white p-2 rounded-full shadow-lg">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="h-6 w-6"
      fill="#113259"
      viewBox="0 0 24 24"
      stroke="currentColor">
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M4 6h16M4 12h16M4 18h16" />
    </svg>
  </button>

  <!-- Sidebar Navigation -->
  <div
    id="sidebar"
    class="overflow-hidden fixed top-0 translate-x-full right-0 p-6 w-72 h-full bg-[#113259] text-white transform transition-transform duration-300 ease-in-out z-50 shadow-xl">
    <img
      src="img/sidebar.svg"
      class="absolute bottom-0 left-0 h-[10rem] object-cover"
      alt="" />
    <div class="flex justify-end items-center mb-8">
      <button id="closeNav" class="text-white">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-6"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
    <div class="h-">
      <nav class="">
        <ul class="space-y-4">
          <li>
            <a
              href="#home"
              class="block py-2 transition text-2xl font-black uppercase">Beranda</a>
          </li>
          <li>
            <a
              href="#donation"
              class="block py-2 transition text-2xl font-black uppercase">Donasi</a>
          </li>
          <li>
            <a
              href="#events"
              class="block py-2 transition text-2xl font-black uppercase">Event</a>
          </li>
          <li>
            <button
              onclick="document.getElementById('popupaboutus').classList.remove('hidden')"
              class="block py-2 transition text-2xl font-black uppercase">
              Tentang Kami
            </button>
          </li>
          <li>
            <button
              onclick="window.location.href = 'mailto:halo@bebersih.id'"
              class="block py-2 transition text-2xl font-black uppercase">
              Hubungi Kami
            </button>
          </li>
        </ul>
      </nav>
    </div>
  </div>

  <!-- Hero Section -->
  <section
    id="home"
    class="relative h-[calc(100vh+16rem)] flex overflow-hidden items-center justify-center text-white">
    <div class="absolute h-full w-full inset-0 bg-[#113259]"></div>
    <div
      class="absolute h-full w-full inset-0 bg-gradient-to-b from-transparent to-sky-100"></div>
    <div
      class="absolute inset-0"
      style="background-image: url('img/stars.png'); height: 110%"></div>
    <div class="absolute items-center h-full w-full inset-0">
      <img
        src="img/mountain.svg"
        alt="Beach cleanup"
        class="w-full h-full object-cover" />
    </div>
    <div class="relative h-screen w-full flex justify-center items-center">
      <div
        id="logo"
        class="absolute top-0 flex items-center justify-center gap-2">
        <span
          class="lg:text-2xl p-[3px] hover:shadow-[0px_0px_53px_-10px_#008235] transition-all duration-200 ease-in-out lg:px-5 bg-green-700 font-medium text-white">
          BEBERSIH.ID
        </span>
      </div>

      <div
        class="absolute flex items-center flex-col px-5 top-20 md:top-36 lg:top-32 text-center">
        <h3
          class="text-4xl md:text-5xl lg:text-5xl font-black mb-7 md:mb-9 lg:mb-11">
          JADILAH BAGIAN DARI SEJARAH
        </h3>
        <p class="max-w-xl md:text-lg lg:text-xl font-medium">
          aksi kecil, dampak besar, gabung gerakan bebersih bareng dan bantu
          jaga bumi tiap harinya
        </p>
      </div>
      <h1
        id="totalDonation"
        class="absolute text-7xl md:text-[8rem] lg:text-[12rem] font-black">
      </h1>
      <p class="absolute text-2xl md:text-3xl lg:text-4xl font-black">
        <script>
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
          animateCounter(totalDonation, 0, <?php echo $total_donation ?>, 2000);
        </script>
    </div>
    <div
      class="absolute -bottom-[7rem] lg:-bottom-[13rem] h-[10rem] lg:h-[20rem] w-[calc(100vw+10rem)] bg-[#f8f8f8] rounded-[50%]"></div>
  </section>

  <!-- Donation Section -->
  <section
    id="donation"
    class="relative py-5 text-[#113259] flex flex-col items-center justify-center w-screen">
    <!-- Donation Form -->
    <div
      class="absolute -top-64 max-w-[20rem] md:max-w-[26rem] lg:max-w-[26rem] bg-white p-5 md:p-8 lg:p-8 rounded-lg shadow-lg">
      <div
        class="w-full md:px-10 lg:px-10 items-center flex flex-col gap-3 mb-5">
        <h2 class="text-2xl lg:text-2xl md:text-2xl font-black uppercase">
          GABUNG BEBERSIH!
        </h2>
        <p class="font-semibold">Rp1.000 = 1kg Sampah diangkat</p>
      </div>
      <form id="donationForm" class="space-y-2">
        <div>
          <input
            type="text"
            id="name"
            placeholder="Nama"
            name="name"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#113259]" />
        </div>
        <div>
          <input
            type="email"
            id="email"
            name="email"
            placeholder="Email"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#113259]" />
        </div>
        <div class="donation-selector flex gap-2">
          <button
            type="button"
            class="bg-[#edf2f7] border border-gray-300 rounded-md cursor-pointer py-3 w-[50%] amount-btn"
            data-amount="5000">
            5kg
          </button>
          <button
            type="button"
            class="bg-[#edf2f7] border border-gray-300 rounded-md cursor-pointer py-3 w-[50%] amount-btn"
            data-amount="10000">
            10kg
          </button>
        </div>
        <div class="donation-selector flex gap-2">
          <button
            type="button"
            class="bg-[#edf2f7] border border-gray-300 rounded-md cursor-pointer py-3 w-[50%] amount-btn"
            data-amount="30000">
            30kg
          </button>
          <button
            type="button"
            class="bg-[#edf2f7] border border-gray-300 rounded-md cursor-pointer py-3 w-[50%] amount-btn"
            data-amount="50000">
            50kg
          </button>
        </div>
        <div
          class="flex items-center border border-gray-300 rounded-md px-4 py-2 gap-2">
          <p>Rp</p>
          <input
            type="number"
            id="amount"
            name="amount"
            min="1000"
            step="1000"
            placeholder="Jumlah donasi (Rp)"
            required
            class="w-full focus:outline-none focus:ring-transparent" />
        </div>
        <div>
          <textarea
            id="message"
            name="message"
            maxlength="45"
            placeholder="Pesan (Optional)"
            rows="2"
            class="mb-5 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#113259]"></textarea>
        </div>
        <button
          type="submit"
          class="w-full bg-sunset cursor-pointer hover:bg-[#91ad2b] text-white font-bold py-4 rounded-full transition duration-300">
          Berikutnya
        </button>
      </form>
    </div>

    <div class="relative mb-20 md:mb-40 lg:mb-40 p-8 mt-96 rounded-lg">
      <div class="absolute bottom-0 h-[5rem] bg-black"></div>
      <h3
        class="hidden text-6xl md:visible lg:visible uppercase text-center font-black mb-10">
        Leaderboard
      </h3>

      <h3
        class="text-6xl md:hidden lg:hidden visible uppercase text-center font-black mb-10">
        Leader<br />board
      </h3>

      <!-- Leaderboard Controls -->
      <div
        class="flex font-semibold flex-col md:flex-row lg:flex-row gap-2 mb-10">
        <div class="relative flex-grow">
          <input
            type="text"
            id="searchDonor"
            placeholder="Cari nama donatur..."
            class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-[#113259]" />
          <button
            id="searchBtn"
            class="absolute right-2 top-1/2 transform -translate-y-1/2">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5 text-gray-400"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </button>
        </div>
        <div class="flex bg-gray-200 rounded-full">
          <button
            id="recentBtn"
            class="w-[50%] px-5 py-2 md:py-0 lg:py-0 text-center flex justify-center items-center rounded-full bg-white cursor-pointer shadow-lg">
            Terbaru
          </button>
          <button
            id="mostKgBtn"
            class="w-[50%] text-center flex justify-center items-center px-5 rounded-full bg-gray-200 text-gray-400 cursor-pointer">
            Terbanyak
          </button>
        </div>
      </div>

      <!-- Leaderboard List -->
      <div class="relative">
        <div
          class="absolute z-10 w-full h-16 bg-gradient-to-t from-[#f8f8f8] to-transparent bottom-11 md:bottom-0 lg:bottom-0"></div>
        <div
          id="leaderboardList"
          class="space-y-3 max-h-[16rem] md:max-h-[50rem] lg:max-h-[50rem] overflow-y-auto lg:pr-2"></div>
        <button
          id="viewmoreleaderboard"
          class="md:hidden lg:hidden mt-2 w-full py-2 shadow-lg bg-sunset rounded-full text-white font-bold"
          onclick="toggleLeaderboardView()">
          Lebih Banyak
        </button>

        <script>
          function toggleLeaderboardView() {
            const list = document.getElementById("leaderboardList");
            const btn = document.getElementById("viewmoreleaderboard");

            const isExpanded = list.classList.contains("max-h-[40rem]");

            if (isExpanded) {
              list.classList.remove("max-h-[40rem]");
              list.classList.add("max-h-[16rem]");
              btn.innerText = "Lebih Banyak";
            } else {
              list.classList.remove("max-h-[16rem]");
              list.classList.add("max-h-[40rem]");
              btn.innerText = "Lebih Sedikit";
            }
          }
        </script>
      </div>
    </div>
    <!-- bg-[#f8f8f8] -->
  </section>

  <!-- Events Section -->
  <section
    id="events"
    class="flex flex-col items-center text-[#f8f8f8] overflow-x-hidden relative py-16 bg-[#113259]">
    <div
      class="absolute -top-[7rem] lg:-top-[10rem] h-[10rem] lg:h-[20rem] w-[calc(100vw+10rem)] bg-[#f8f8f8] rounded-[50%]"></div>
    <div class="z-10 mt-20 lg:mt-40 container mx-auto px-4">
      <div class="flex flex-col items-center mb-10 gap-5">
        <h3 class="text-6xl uppercase text-center font-black">
          EVENT BEBERSIHx
        </h3>
        <p class="text-center">
          Ayo Berpatisipasi secara langsung bersama kami dalam event
          bersih-bersih yang seru!
        </p>
      </div>

      <!-- Swiper -->
      <div class="swiper eventsSwiper mb-20">
        <div class="swiper-wrapper">
          <!-- Event slides will be inserted here by JavaScript -->
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
      </div>

      <hr />

      <div id="testimonials" class="mt-20">
        <h1 class="text-white mb-5 font-bold text-2xl">Events</h1>
        <div
          id="testimonials-container"
          class="flex flex-wrap text-[#113259] gap-12"></div>
      </div>
    </div>
  </section>

  <section
    id="socials"
    class="bg-[#113259] py-20 flex flex-col gap-4 items-center justify-center text-white">
    <h3 class="text-6xl text-wrap uppercase text-center font-black">
      BEBERSIH SOCIAL
    </h3>
    <div class="flex gap-4">
      <button
        class="bg-sunset p-3 rounded-full cursor-pointer"
        data-url="https://instagram.com/bebersih.id">
        <img src="img/instagram-brands.svg" class="size-5" alt="Instagram" />
      </button>
      <button
        class="bg-sunset p-3 rounded-full cursor-pointer"
        data-url="https://youtube.com/@bebersihid">
        <img src="img/youtube-brands.svg" class="size-5" alt="YouTube" />
      </button>
      <button
        class="bg-sunset p-3 rounded-full cursor-pointer"
        data-url="https://x.com/bebersihid">
        <img src="img/x-twitter-brands.svg" class="size-5" alt="Twitter" />
      </button>
      <button
        class="bg-sunset p-3 rounded-full cursor-pointer"
        data-url="https://tiktok.com/bebersihid">
        <img src="img/tiktok-brands.svg" class="size-5" alt="Twitter" />
      </button>
    </div>

    <script>
      const buttons = document.querySelectorAll("button[data-url]");

      buttons.forEach((btn) => {
        btn.addEventListener("click", () => {
          const url = btn.getAttribute("data-url");
          window.open(url, "_blank"); // buka tab baru
        });
      });
    </script>
  </section>

  <!-- Footer -->
  <footer
    class="bg-gradient-to-b pt-40 from-[#113259] to-[#618abd] flex flex-col items-center justify-center text-[18px] font-black text-white">
    <div class="items-center h-[30rem] w-[calc(100vw+50rem)] inset-0">
      <img
        src="img/footer.svg"
        alt="Beach cleanup"
        class="w-full h-full object-cover" />
    </div>
    <div
      class="h-[5rem] w-screen items-center justify-center p-6 flex gap-6 bg-[#113259]">
      <button
        class="cursor-pointer"
        onclick="window.location.href = 'mailto:halo@bebersih.id'">
        Hubungi Kami
      </button>

      <button
        class="cursor-pointer"
        onclick="document.getElementById('popupaboutus').classList.remove('hidden')">
        Tentang Kami
      </button>
    </div>
  </footer>

  <!-- <script src="script.js"></script> -->

  <div
    id="popupaboutus"
    class="popup-about hidden z-50 fixed top-0 right-0 flex items-center justify-center w-screen h-screen bg-[#00000049]">
    <div
      id="divaboutus"
      class="abotus lg:max-w-[40rem] bg-white p-6 rounded-lg relative">
      <button
        id="closeaboutus"
        onclick="document.getElementById('popupaboutus').classList.add('hidden')"
        class="cursor-pointer absolute -right-5 -top-5 p-5 rounded-full bg-white">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="size-6"
          fill=""
          viewBox="0 0 24 24"
          stroke="currentColor">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
      <h1
        class="font-black text-5xl text-left py-5 mb-5 w-full border-b border-b-gray-300">
        ABOUT US
      </h1>
      <p class="text-black">
        bebersih.id adalah gerakan digital yang lahir dari keresahan akan
        menumpuknya sampah di sekitar kita. kami percaya bahwa perubahan besar
        bisa dimulai dari langkah kecil—bahkan dari seribu rupiah. dengan
        kampanye Rp1.000 = 1kg sampah diangkat, kami ngajak masyarakat
        indonesia buat ambil bagian dalam aksi nyata membersihkan lingkungan.
        lewat platform ini, siapa pun bisa berdonasi, gabung event
        bersih-bersih, dan jadi bagian dari komunitas yang peduli bumi.
        bebersih.id bukan cuma soal kebersihan, tapi juga soal solidaritas,
        edukasi, dan harapan untuk indonesia yang lebih hijau dan sehat.
      </p>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      // Navigation toggle
      const navToggle = document.getElementById("navToggle");
      const closeNav = document.getElementById("closeNav");
      const sidebar = document.getElementById("sidebar");
      const popup = document.getElementById("popupaboutus");

      popup.addEventListener("click", function(event) {
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

      let donorsData = [];

      fetch("getdonors.php")
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
          const res = await fetch("getevents.php");
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
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 448 512">
              <path fill="#ffffff" d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40L64 64C28.7 64 0 92.7 0 128l0 16 0 48L0 448c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-256 0-48 0-16c0-35.3-28.7-64-64-64l-40 0 0-40c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 40L152 64l0-40zM48 192l352 0 0 256c0 8.8-7.2 16-16 16L64 464c-8.8 0-16-7.2-16-16l0-256z" />
            </svg>
            <span class="text-[0.9rem] lg:text-[1rem] md:text-[1rem]">${formattedDate}</span>
          </div>
          <div class="flex gap-2 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 512 512">
              <path fill="#ffffff" d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120l0 136c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2 280 120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
            </svg>
            <span class="text-[0.9rem] lg:text-[1rem] md:text-[1rem]">${
              event.time
              }</span>
          </div>
          <div class="flex gap-2 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 384 512">
              <path fill="#ffffff" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z" />
            </svg>
            <span
              class="underline cursor-pointer text-[0.9rem] lg:text-[1rem] md:text-[1rem]"
              onclick="window.open('https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(
      event.location
    )}', '_blank')">
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
          const response = await fetch("geteventsstatus.php");
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
          const res = await fetch("app.php", {
            method: "POST",
            body: JSON.stringify(data),
          });
          const token = await res.text();

          window.snap.pay(token, {
            onSuccess: async function(result) {
              const kgAmount = amount / 1000;
              const newDonation = {
                name: name,
                amount: kgAmount,
                message: message,
                date: new Date().toISOString(),
              };

              // Mengirim donasi yang baru ke database
              try {
                const submitRes = await fetch("adddonors.php", {
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
            onPending: function(result) {
              console.log("waiting your payment!");
              console.log(result);
            },
            onError: function(result) {
              console.log("payment failed!");
              console.log(result);
            },
            onClose: function() {
              console.log("you closed the popup without finishing the payment");
            },
          });
        } catch (err) {
          console.log("error:", err.message);
        }
      });
    });
  </script>
</body>

</html>