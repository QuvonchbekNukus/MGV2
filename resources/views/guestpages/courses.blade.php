@extends('guestpages.main')

@section('title', 'Darsliklar')

@section('menu')

    <li><a href="{{ route('guestpages.index') }}">Asosiy sahifa<br></a></li>
    <li><a href="{{ route('guestpages.about') }}">Platforma haqida</a></li>
    <li><a href="{{ route('guestpages.courses') }}" class="active">Darsliklar</a></li>
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
              <h1>Darsliklar</h1>
              <!-- <p class="mb-0">
                text yozish kerak
              </p> -->
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="index.html">Asosiy/Darsliklar</a></li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->


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
                  <img src="{{asset('main/assets/img/img9.jpg')}}" class="img-fluid" alt="...">
                  <div class="course-content">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <p class="category">TAKTIK TAYYORGARLIK</p>
                    </div>
                    <h3><a href="">To`liq ma`lumot olish</a></h3>
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
                  <img src="{{asset('main/assets/img/img8.jpg')}}" class="img-fluid" alt="...">
                  <div class="course-content">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <p class="category">Maxsus Taktik Tayyorgarlik</p>
                    </div>

                    <h3><a href="">To`liq ma`lumot olish</a></h3>
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
                  <img src="{{asset('main/assets/img/img7.jpg')}}" class="img-fluid" alt="...">
                  <div class="course-content">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <p class="category">Otish Tayyorgarligi</p>
                    </div>

                    <h3><a href="">To`liq ma`lumot olish</a></h3>
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
