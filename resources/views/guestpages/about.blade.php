@extends('guestpages.main')

@section('title', 'Platforma haqida' )
@section("menu")
    <li><a href="{{ route('guestpages.index') }}">Asosiy sahifa<br></a></li>
    <li><a href="{{ route('guestpages.about') }}" class="active">Platforma haqida</a></li>
    <li><a href="{{ route('guestpages.courses') }}">Darsliklar</a></li>
    <li><a href="{{ route('guestpages.contacts') }}">Biz bilan aloqa</a></li>
@endsection

@section('content')

  <main class="main">

    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>Platforma Haqida<br></h1>
              <!-- <p class="mb-0">Shu yerga nimadir yozish kerak</p> -->
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="index.html">Asosiy/Platforma haqida</a></li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->


    <section id="about" class="about section">

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="100">
            <img src="{{asset("main/assets/img/img1.jpg")}}" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6 order-2 order-lg-1 content" data-aos="fade-up" data-aos-delay="200">
            <h3>Platforma haqida ma`lumot</h3>
            <p class="fst-italic">

              Ushbu tizimlarning afzalliklari: <br>
              • Avtomatlashtirish va samaradorlik: O‘quv jarayonlarini avtomatlashtirish va tizimli tarzda hisobga
              olish, ma’lumotlarni tez va samarali yig‘ishga imkon beradi. <br>
              • Shaffoflik: Harbiy xizmatchilar va komandirlar tomonidan ma’lumotlarga tezda kirish va o‘quv jarayonini
              kuzatish imkoniyati. <br>
              • Shaxsiylashtirish: Har bir harbiy xizmatchi uchun maxsus tayyorgarlik rejalari yaratish va individual
              o‘qish usullarini qo‘llash. <br>
              • Tahlil va prognozlash: Harbiy tayyorgarlik jarayonlari haqida tahlil qilish va kelajakdagi ehtiyojlar
              yoki xavflarni prognozlash imkoniyatini beradi.

            </p>
            <h3>e-gvardiya platformasining dolzarbligi</h3>
            <p class="fst-italic">
              Yagona elektron tizimning jangovar va maxsus tayyorgarlikni hisobga olish
              uchun joriy etilishi dolzarb hisoblanadi, chunki zamonaviy texnologiyalar harbiy
              tayyorgarlik jarayonlarini <b>samarali boshqarish</b> va nazorat qilish imkonini beradi.
              Bu tizim orqali harbiy xizmatchilarning tayyorgarlik darajasini <b>aniq va real vaqt
              rejimida</b> kuzatish, o'quv jarayonlarini optimallashtirish va resurslarni samarali
              taqsimlash mumkin bo'ladi. Elektron tizimning joriy etilishi, shuningdek, boshqaruvning
              shaffofligini ta'minlaydi va harbiy tayyorgarlikning umumiy samaradorligini oshiradi.
            </p>
            <h3>Yechim e-gvardiya tizimini Milliy gvardiya bo‘linmalarida joriy etish</h3>
            <p>
              Axborot tizimi bo‘linmalardagi darslar taqsimoti, reja-konspektlar, jangovar va maxsus
              tayyorgarlik hisobini yuritish jurnali elektron tarzda yaratilishi, harbiy xizmatchilarning
              mashg‘ulotlarga qatnashganlik davomati, harbiy xizmatchilarning baholari, sutkalik naryadga va
              jamoat tartibini saqlashga jalb etilganligi hisobini yuritishda qulayliklarni yaratadi.

            </p>
            <h3>Qanday natijaga erishamiz?</h3>
            <p>
              Harbiy tayyorgarlik jarayonining raqamlashtirilishi: Mashg‘ulotlar,
              reja-konspektlar, dars taqsimoti elektron shaklda boshqarilib,
              harbiy xizmatchilarning davomati, baholari, mashg‘ulotlarda qatnashish holati,
              sutkalik naryadlarni elektron tizimda kuzatish imkoniyati yaratiladi. <br>
              Shaffoflik va monitoring tizimi: Harbiy xizmatchilarning xizmat yuklamalari elektron
              tarzda boshqarilib, kimning qaysi xizmatga jalb etilgani kuzatib boriladi, bu esa
              xizmatni shaffof boshqarishga yordam beradi. <br>
              Qog‘ozbozlikning oldini olish: Jangovar va maxsus tayyorgarlik bo‘yicha qog‘ozli
              hujjatlarni kamaytirish, mashg‘ulot rahbarlarining asosiy vaqtlarini bilim berishga
              yo‘naltirish imkonini beradi. <br>
              Bilim va ko‘nikmalarni baholash: Harbiy xizmatchilarning bilimlari va
              ko‘nikmalari real vaqtda baholanib, mashg‘ulotlarda qatnashish darajasi tahlil qilinadi.

            </p>
            <h3>Chet el tajribasi</h3>
            <p>
              <b>Rossiya:</b> Rossiyada “Jangovar tayyorgarlik elektron jurnali” tizimi ishlab c
              hiqilgan va qo‘llanilmoqda. Bu tizim mashg‘ulotlar va natijalar haqida
              ma’lumotlarni saqlash, o‘quv jarayonlarini samarali nazorat qilish va bo‘yicha
              tahlil qilish imkonini beradi. <br>
              <b>AQSh:</b> AQShda “Army Training and Certification System (ATCS)” tizimi ishlatiladi,
              bu tizim harbiy xizmatchilarni malaka oshirish va o‘quv natijalarini kuzatib borish
              imkonini beradi. <br>
              <b>Buyuk Britaniya:</b> “Defence Learning Environment” (DLE) tizimi orqali Buyuk Britaniya
              armiyasida harbiy xizmatchilarning tayyorgarligini boshqarish va o‘quv jarayonlarini
              monitoring qilish amalga oshiriladi.
            </p>
          </div>

        </div>

      </div>

    </section><!-- /About Section -->



  </main>
@endsection
