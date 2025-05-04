<?php
include("../backend/conn.php");
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bebersih.id - Bersihkan Indonesia Bersama</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;900&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="/node_modules/swiper/swiper-bundle.min.css" />
    <script src="/node_modules/swiper/swiper-bundle.min.js"></script>
    <script src="tailwind.config.js"></script>
    <script
      type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="SB-Mid-client-JgBC92QzBiJcAc1g"
    ></script>
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body
    class="relative font-montserrat bg-[#f8f8f8] text-[#113259] overflow-x-hidden"
  >
    <button
      id="navToggle"
      class="fixed top-6 right-6 z-40 bg-white p-2 rounded-full shadow-lg"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-6 w-6"
        fill="#113259"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M4 6h16M4 12h16M4 18h16"
        />
      </svg>
    </button>

    <!-- Sidebar Navigation -->
    <div
      id="sidebar"
      class="overflow-hidden fixed top-0 translate-x-full right-0 p-6 w-72 h-full bg-[#113259] text-white transform transition-transform duration-300 ease-in-out z-50 shadow-xl"
    >
      <img
        src="img/sidebar.svg"
        class="absolute bottom-0 left-0 h-[10rem] object-cover"
        alt=""
      />
      <div class="flex justify-end items-center mb-8">
        <button id="closeNav" class="text-white">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>
      </div>
      <div class="h-">
        <nav class="">
          <ul class="space-y-4">
            <li>
              <a
                href="#home"
                class="block py-2 transition text-2xl font-black uppercase"
                >Beranda</a
              >
            </li>
            <li>
              <a
                href="#donation"
                class="block py-2 transition text-2xl font-black uppercase"
                >Donasi</a
              >
            </li>
            <li>
              <a
                href="#events"
                class="block py-2 transition text-2xl font-black uppercase"
                >Event</a
              >
            </li>
            <li>
              <button
                onclick="document.getElementById('popupaboutus').classList.remove('hidden')"
                class="block py-2 transition text-2xl font-black uppercase"
              >
                Tentang Kami
              </button>
            </li>
            <li>
              <button
                onclick="window.location.href = 'mailto:halo@bebersih.id'"
                class="block py-2 transition text-2xl font-black uppercase"
              >
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
      class="relative h-[calc(100vh+16rem)] flex overflow-hidden items-center justify-center text-white"
    >
      <div class="absolute h-full w-full inset-0 bg-[#113259]"></div>
      <div
        class="absolute h-full w-full inset-0 bg-gradient-to-b from-transparent to-sky-100"
      ></div>
      <div
        class="absolute inset-0"
        style="background-image: url('img/stars.png'); height: 110%"
      ></div>
      <div class="absolute items-center h-full w-full inset-0">
        <img
          src="img/mountain.svg"
          alt="Beach cleanup"
          class="w-full h-full object-cover"
        />
      </div>
      <div class="relative h-screen w-full flex justify-center items-center">
        <div
          id="logo"
          class="absolute top-0 flex items-center justify-center gap-2"
        >
          <span
            class="lg:text-2xl p-[3px] hover:shadow-[0px_0px_53px_-10px_#008235] transition-all duration-200 ease-in-out lg:px-5 bg-green-700 font-medium text-white"
          >
            BEBERSIH.ID
          </span>
        </div>

        <div
          class="absolute flex items-center flex-col px-5 top-20 md:top-36 lg:top-32 text-center"
        >
          <h3
            class="text-4xl md:text-5xl lg:text-5xl font-black mb-7 md:mb-9 lg:mb-11"
          >
            JADILAH BAGIAN DARI SEJARAH
          </h3>
          <p class="max-w-xl md:text-lg lg:text-xl font-medium">
            aksi kecil, dampak besar, gabung gerakan bebersih bareng dan bantu
            jaga bumi tiap harinya
          </p>
        </div>
        <h1
          id="totalDonation"
          class="absolute text-7xl md:text-[8rem] lg:text-[12rem] font-black"
        >
        </h1>
      </div>
      <div
        class="absolute -bottom-[7rem] lg:-bottom-[13rem] h-[10rem] lg:h-[20rem] w-[calc(100vw+10rem)] bg-[#f8f8f8] rounded-[50%]"
      ></div>
    </section>

    <!-- Donation Section -->
    <section
      id="donation"
      class="relative py-5 text-[#113259] flex flex-col items-center justify-center w-screen"
    >
      <!-- Donation Form -->
      <div
        class="absolute -top-64 max-w-[20rem] md:max-w-[26rem] lg:max-w-[26rem] bg-white p-5 md:p-8 lg:p-8 rounded-lg shadow-lg"
      >
        <div
          class="w-full md:px-10 lg:px-10 items-center flex flex-col gap-3 mb-5"
        >
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
              class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#113259]"
            />
          </div>
          <div>
            <input
              type="email"
              id="email"
              name="email"
              placeholder="Email"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#113259]"
            />
          </div>
          <div class="donation-selector flex gap-2">
            <button
              type="button"
              class="bg-[#edf2f7] border border-gray-300 rounded-md cursor-pointer py-3 w-[50%] amount-btn"
              data-amount="5000"
            >
              5kg
            </button>
            <button
              type="button"
              class="bg-[#edf2f7] border border-gray-300 rounded-md cursor-pointer py-3 w-[50%] amount-btn"
              data-amount="10000"
            >
              10kg
            </button>
          </div>
          <div class="donation-selector flex gap-2">
            <button
              type="button"
              class="bg-[#edf2f7] border border-gray-300 rounded-md cursor-pointer py-3 w-[50%] amount-btn"
              data-amount="30000"
            >
              30kg
            </button>
            <button
              type="button"
              class="bg-[#edf2f7] border border-gray-300 rounded-md cursor-pointer py-3 w-[50%] amount-btn"
              data-amount="50000"
            >
              50kg
            </button>
          </div>
          <div
            class="flex items-center border border-gray-300 rounded-md px-4 py-2 gap-2"
          >
            <p>Rp</p>
            <input
              type="number"
              id="amount"
              name="amount"
              min="1000"
              step="1000"
              placeholder="Jumlah donasi (Rp)"
              required
              class="w-full focus:outline-none focus:ring-transparent"
            />
          </div>
          <div>
            <textarea
              id="message"
              name="message"
              maxlength="45"
              placeholder="Pesan (Optional)"
              rows="2"
              class="mb-5 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#113259]"
            ></textarea>
          </div>
          <button
            type="submit"
            class="w-full bg-sunset cursor-pointer hover:bg-[#91ad2b] text-white font-bold py-4 rounded-full transition duration-300"
          >
            Berikutnya
          </button>
        </form>
      </div>

      <div class="relative mb-20 md:mb-40 lg:mb-40 p-8 mt-96 rounded-lg">
        <div class="absolute bottom-0 h-[5rem] bg-black"></div>
        <h3
          class="hidden text-6xl md:visible lg:visible uppercase text-center font-black mb-10"
        >
          Leaderboard
        </h3>

        <h3
          class="text-6xl md:hidden lg:hidden visible uppercase text-center font-black mb-10"
        >
          Leader<br />board
        </h3>

        <!-- Leaderboard Controls -->
        <div
          class="flex font-semibold flex-col md:flex-row lg:flex-row gap-2 mb-10"
        >
          <div class="relative flex-grow">
            <input
              type="text"
              id="searchDonor"
              placeholder="Cari nama donatur..."
              class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-[#113259]"
            />
            <button
              id="searchBtn"
              class="absolute right-2 top-1/2 transform -translate-y-1/2"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                />
              </svg>
            </button>
          </div>
          <div class="flex bg-gray-200 rounded-full">
            <button
              id="recentBtn"
              class="w-[50%] px-5 py-2 md:py-0 lg:py-0 text-center flex justify-center items-center rounded-full bg-white cursor-pointer shadow-lg"
            >
              Terbaru
            </button>
            <button
              id="mostKgBtn"
              class="w-[50%] text-center flex justify-center items-center px-5 rounded-full bg-gray-200 text-gray-400 cursor-pointer"
            >
              Terbanyak
            </button>
          </div>
        </div>

        <!-- Leaderboard List -->
        <div class="relative">
          <div
            class="absolute z-10 w-full h-16 bg-gradient-to-t from-[#f8f8f8] to-transparent bottom-11 md:bottom-0 lg:bottom-0"
          ></div>
          <div
            id="leaderboardList"
            class="space-y-3 max-h-[16rem] md:max-h-[50rem] lg:max-h-[50rem] overflow-y-auto lg:pr-2"
          ></div>
          <button
            id="viewmoreleaderboard"
            class="md:hidden lg:hidden mt-2 w-full py-2 shadow-lg bg-sunset rounded-full text-white font-bold"
            onclick="toggleLeaderboardView()"
          >
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
      class="flex flex-col items-center text-[#f8f8f8] overflow-x-hidden relative py-16 bg-[#113259]"
    >
      <div
        class="absolute -top-[7rem] lg:-top-[10rem] h-[10rem] lg:h-[20rem] w-[calc(100vw+10rem)] bg-[#f8f8f8] rounded-[50%]"
      ></div>
      <div class="z-10 mt-20 lg:mt-40 container mx-auto px-4">
        <div class="flex flex-col items-center mb-10 gap-5">
          <h3 class="text-6xl uppercase text-center font-black">
            EVENT BEBERSIH
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
            class="flex flex-wrap text-[#113259] gap-12"
          ></div>
        </div>
      </div>
    </section>

    <section
      id="socials"
      class="bg-[#113259] py-20 flex flex-col gap-4 items-center justify-center text-white"
    >
      <h3 class="text-6xl text-wrap uppercase text-center font-black">
        BEBERSIH SOCIAL
      </h3>
      <div class="flex gap-4">
        <button
          class="bg-sunset p-3 rounded-full cursor-pointer"
          data-url="https://instagram.com/bebersih.id"
        >
          <img src="img/instagram-brands.svg" class="size-5" alt="Instagram" />
        </button>
        <button
          class="bg-sunset p-3 rounded-full cursor-pointer"
          data-url="https://youtube.com/@bebersihid"
        >
          <img src="img/youtube-brands.svg" class="size-5" alt="YouTube" />
        </button>
        <button
          class="bg-sunset p-3 rounded-full cursor-pointer"
          data-url="https://x.com/bebersihid"
        >
          <img src="img/x-twitter-brands.svg" class="size-5" alt="Twitter" />
        </button>
        <button
          class="bg-sunset p-3 rounded-full cursor-pointer"
          data-url="https://tiktok.com/bebersihid"
        >
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
      class="bg-gradient-to-b pt-40 from-[#113259] to-[#618abd] flex flex-col items-center justify-center text-[18px] font-black text-white"
    >
      <div class="items-center h-[30rem] w-[calc(100vw+50rem)] inset-0">
        <img
          src="img/footer.svg"
          alt="Beach cleanup"
          class="w-full h-full object-cover"
        />
      </div>
      <div
        class="h-[5rem] w-screen items-center justify-center p-6 flex gap-6 bg-[#113259]"
      >
        <button
          class="cursor-pointer"
          onclick="window.location.href = 'mailto:halo@bebersih.id'"
        >
          Hubungi Kami
        </button>

        <button
          class="cursor-pointer"
          onclick="document.getElementById('popupaboutus').classList.remove('hidden')"
        >
          Tentang Kami
        </button>
      </div>
    </footer>

    <script src="script.js"></script>

    <div
      id="popupaboutus"
      class="popup-about hidden z-50 fixed top-0 right-0 flex items-center justify-center w-screen h-screen bg-[#00000049]"
    >
      <div
        id="divaboutus"
        class="abotus lg:max-w-[40rem] bg-white p-6 rounded-lg relative"
      >
        <button
          id="closeaboutus"
          onclick="document.getElementById('popupaboutus').classList.add('hidden')"
          class="cursor-pointer absolute -right-5 -top-5 p-5 rounded-full bg-white"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="size-6"
            fill=""
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>
        <h1
          class="font-black text-5xl text-left py-5 mb-5 w-full border-b border-b-gray-300"
        >
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
  </body>
</html>
