# CSS va JavaScript Kodlash Standartlari

## 🎯 Maqsad
Barcha CSS va JavaScript kodlarini alohida fayllarga yozish va kod takrorlanishini oldini olish.

## 📁 Fayl Strukturasi

```
public/
├── css/
│   ├── admin.css          # Admin layout uchun stillar
│   ├── login.css          # Login sahifasi uchun stillar
│   └── common.css         # Barcha sahifalar uchun umumiy stillar
└── js/
    ├── admin.js           # Admin layout uchun JavaScript
    ├── login.js           # Login sahifasi uchun JavaScript
    └── common.js          # Barcha sahifalar uchun umumiy JavaScript
```

## ✅ QOIDALAR

### 1. **CSS Kodlari**

#### ❌ YO'Q - Blade template'da inline CSS:
```blade
<style>
    .my-class {
        color: red;
    }
</style>
```

#### ✅ HA - Alohida CSS faylida:
```blade
<!-- Blade template'da -->
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
```

```css
/* public/css/admin.css */
.my-class {
    color: red;
}
```

### 2. **JavaScript Kodlari**

#### ❌ YO'Q - Blade template'da inline JavaScript:
```blade
<script>
    function myFunction() {
        alert('Hello');
    }
</script>
```

#### ✅ HA - Alohida JS faylida:
```blade
<!-- Blade template'da -->
<script src="{{ asset('js/admin.js') }}"></script>
```

```javascript
// public/js/admin.js
function myFunction() {
    alert('Hello');
}
```

### 3. **Kod Takrorlanishini Oldini Olish**

#### ❌ YO'Q - Har bir sahifada takrorlanadigan kod:
```blade
<!-- sahifa1.blade.php -->
<script>
    function showToast(message) {
        // kod...
    }
</script>

<!-- sahifa2.blade.php -->
<script>
    function showToast(message) {
        // xuddi shu kod...
    }
</script>
```

#### ✅ HA - Umumiy faylda:
```javascript
// public/js/common.js
function showToast(message) {
    // kod...
}
```

```blade
<!-- Barcha sahifalarda -->
<script src="{{ asset('js/common.js') }}"></script>
```

## 📝 Qanday Qo'shish Kerak?

### Yangi CSS qo'shish:

1. **Sahifaga xos CSS** bo'lsa:
   - `public/css/[sahifa-nomi].css` faylini yarating
   - Blade template'da link qo'shing:
   ```blade
   <link rel="stylesheet" href="{{ asset('css/[sahifa-nomi].css') }}">
   ```

2. **Umumiy CSS** bo'lsa:
   - `public/css/common.css` fayliga qo'shing
   - Yoki yangi umumiy fayl yarating: `public/css/[nomi].css`

### Yangi JavaScript qo'shish:

1. **Sahifaga xos JS** bo'lsa:
   - `public/js/[sahifa-nomi].js` faylini yarating
   - Blade template'da script qo'shing:
   ```blade
   <script src="{{ asset('js/[sahifa-nomi].js') }}"></script>
   ```

2. **Umumiy JS** bo'lsa:
   - `public/js/common.js` fayliga qo'shing
   - Yoki yangi umumiy fayl yarating: `public/js/[nomi].js`

## 🔍 Tekshirish

Har bir yangi kod qo'shganda quyidagilarni tekshiring:

1. ✅ Inline `<style>` yoki `<script>` taglari yo'qmi?
2. ✅ CSS/JS kodlar alohida fayllarda yozilganmi?
3. ✅ Kod takrorlanmayaptimi?
4. ✅ Umumiy funksiyalar `common.js` yoki `common.css` da yozilganmi?

## 📚 Mavjud Umumiy Funksiyalar

### JavaScript (`public/js/common.js`):
- `debounce(func, wait)` - Funksiyani kechiktirish
- `throttle(func, limit)` - Funksiyani cheklash
- `formatNumber(num, decimals)` - Raqamni formatlash
- `formatDate(date, locale)` - Sanani formatlash
- `copyToClipboard(text)` - Clipboard'ga ko'chirish
- `confirmDialog(message, title)` - Tasdiqlash dialogi
- `showLoading(element)` - Yuklanish ko'rsatkichini ko'rsatish
- `hideLoading(element)` - Yuklanish ko'rsatkichini yashirish
- `scrollToTop(duration)` - Yuqoriga scroll qilish
- `getURLParameter(name)` - URL parametrini olish
- `setURLParameter(name, value)` - URL parametrini o'rnatish

## 🚫 QAT'IYAN TAQIQLANGAN

1. ❌ Blade template'larda inline `<style>` taglari
2. ❌ Blade template'larda inline `<script>` taglari (faqat session message handler kabi zarur holatlarda)
3. ❌ Bir xil kodni bir necha joyda takrorlash
4. ❌ Umumiy funksiyalarni har bir sahifada alohida yozish

## ✅ IZIN BERILGAN

1. ✅ Blade template'larda `@stack('styles')` va `@stack('scripts')` ishlatish
2. ✅ Session message handler kabi zarur inline script'lar (minimal)
3. ✅ Alpine.js `x-data` direktivalari (inline, lekin minimal)
4. ✅ CDN linklar (Font Awesome, Google Fonts, va h.k.)

## 📖 Misollar

### Misol 1: Yangi sahifa uchun CSS qo'shish

```blade
<!-- resources/views/admin/users/create.blade.php -->
@extends('layouts.admin')

@section('title', 'Yangi Foydalanuvchi')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/users.css') }}">
@endpush

@section('content')
<!-- HTML kod -->
@endsection
```

```css
/* public/css/users.css */
.user-form {
    /* yangi stillar */
}
```

### Misol 2: Umumiy funksiyani ishlatish

```javascript
// public/js/users.js
document.addEventListener('DOMContentLoaded', function() {
    const submitBtn = document.getElementById('submit-btn');
    
    submitBtn.addEventListener('click', debounce(function() {
        // Form submit logikasi
        showLoading(submitBtn);
        // ...
    }, 300));
});
```

## 🎓 Xotira Qo'llanmasi

**Har doim eslab qoling:**
- CSS → `public/css/` papkasiga
- JS → `public/js/` papkasiga
- Umumiy kod → `common.css` yoki `common.js`
- Sahifaga xos kod → `[sahifa-nomi].css` yoki `[sahifa-nomi].js`
- Blade template'da faqat link/script taglari
