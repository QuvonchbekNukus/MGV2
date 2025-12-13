@extends('guestpages.main')



@section('title', 'Asosiy sahifa' )

@section("menu")
    <li><a href="{{route("guestpages.index")}}" class="active">Asosiy sahifa<br></a></li>
    <li><a href="{{route("guestpages.about")}}">Platforma haqida</a></li>
    <li><a href="{{route("guestpages.courses")}}">Darsliklar</a></li>
    <li><a href="{{route("guestpages.contacts")}}">Biz bilan aloqa</a></li>
@endsection

@section('content')
  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      <img src="{{asset("main/assets/img/img2.jpg")}}" alt="" data-aos="fade-in">

      <div class="container">
        <h2 data-aos="fade-up" data-aos-delay="100">
          Milliy Gvardiya<br>
          Jangovar va Maxsus Tayyorgarlik
        </h2>
        <p data-aos="fade-up" data-aos-delay="200">BURCH,SADOQAT,JASORAT</p>
        <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
          <a href="{{ route('login') }}" class="btn-get-started">KIRISH</a>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
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
            <a href="{{route("guestpages.about")}}" class="read-more"><span>To`liq ma`lumot</span><i class="bi bi-arrow-right"></i></a>
          </div>

        </div>

      </div>

    </section><!-- /About Section -->



    <!-- Courses Section -->
    <section id="courses" class="courses section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Darslar</h2>
        <p>Darslik qo`llanmalarimiz</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row">

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="course-item">
              <img src="{{asset("main/assets/img/img9.jpg")}}" class="img-fluid" alt="...">
              <div class="course-content">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <p class="category">TAKTIK TAYYORGARLIK</p>
                </div>
                <h3><a href="{{route("guestpages.courses")}}">To`liq ma`lumot olish</a></h3>
                <p class="description">
                  Harbiylarning taktik tayyorgarligi — bu jangovar vazifalarni samarali bajarish uchun
                  zarur bo'lgan bilim, ko'nikma va malakalardan iborat. U jangovar vaziyatni tahlil qilish,
                  optimal qarorlar qabul qilish, jangovar usullarni qo'llash, o'zaro hamkorlik va texnik
                  vositalardan foydalanishni o'z ichiga oladi. Taktik tayyorgarlik harbiylarning jangovar
                  samaradorligini oshiradi va muvaffaqiyatli harakat qilishlariga yordam beradi.
                </p>
              </div>
            </div>
          </div> <!-- End Course Item-->

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in"
            data-aos-delay="200">
            <div class="course-item">
              <img src="{{asset("main/assets/img/img8.jpg")}}" class="img-fluid" alt="...">
              <div class="course-content">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <p class="category">Maxsus Taktik Tayyorgarlik</p>
                </div>

                <h3><a href="{{route("guestpages.courses")}}">To`liq ma`lumot olish</a></h3>
                <p class="description">
                  Maxsus taktik tayyorgarlik — bu maxsus vazifalarni bajarish uchun harbiy xodimlarning
                  o'ziga xos tayyorgarligi bo'lib, u maxsus harakatlar, xavfli vaziyatlar va maxfiy
                  operatsiyalarni amalga oshirishga yo'naltirilgan. Bu tayyorgarlik ko'proq maxsus kuchlar,
                  razvedka, kontr-terrorizm yoki boshqa maxsus bo'linmalar uchun zarur bo'lib, yuqori darajadagi
                  jismoniy tayyorgarlik, o'qish, taktik va psixologik mahoratni o'z ichiga oladi. Maxsus taktik
                  tayyorgarlikning maqsadi – harbiylarga yuqori darajada murakkab va xavfli vazifalarni muvaffaqiyatli
                  bajarishga yordam berishdir.
                </p>
              </div>
            </div>
          </div> <!-- End Course Item-->

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0" data-aos="zoom-in"
            data-aos-delay="300">
            <div class="course-item">
              <img src="{{asset("main/assets/img/img7.jpg")}}" class="img-fluid" alt="...">
              <div class="course-content">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <p class="category">Otish Tayyorgarligi</p>
                </div>

                <h3><a href="{{route("guestpages.courses")}}">To`liq ma`lumot olish</a></h3>
                <p class="description">
                  Otish tayyorgarligi — bu harbiy xodimlarning qurolni to'g'ri va samarali ishlatish uchun o'qish,
                  aniqlik, tezlik va xavfsizlikni ta'minlashga qaratilgan tayyorgarlikdir. U quyidagi asosiy
                  elementlarni o'z ichiga oladi: <br>

                  1. **Qurolni boshqarish**: Harbiylar turli qurollardan foydalanishni, ularni to'g'ri ushlab turish,
                  nishon olish, otishni samarali amalga oshirishni o'rganadilar. <br>

                  2. **Aniqlik va tezlik**: Tez va aniq otish ko'nikmalarini rivojlantirish. Bu jangovar sharoitda
                  raqibga qarshi samarali harakat qilish uchun zarurdir. <br>

                  3. **Xavfsizlik**: Otish paytida xavfsizlik qoidalariga qat'iy rioya qilish, o'ziga va boshqalarga
                  zarar yetkazmaslik. <br>

                  4. **Taktik otish**: Jangovar holatlarda, masalan, yashin tezligida va noqulay sharoitda otish
                  ko'nikmalarini rivojlantirish. <br>

                  Otish tayyorgarligi harbiy xodimlarning jangovar samaradorligini oshiradi va ular uchun qurolni o'z
                  vaqtida va to'g'ri ishlatish qobiliyatini ta'minlaydi.
                </p>
              </div>
            </div>
          </div> <!-- End Course Item-->

        </div>

      </div>

    </section><!-- /Courses Section -->


  </main>
@endsection
