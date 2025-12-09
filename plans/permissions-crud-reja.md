# Permissions CRUD Funksiyalari Rejasi

## 📋 Hozirgi Holat

Permissions uchun mavjud funksiyalar:
- ✅ Index (Ko'rish)
- ✅ Create (Yangi qo'shish)
- ✅ Store (Saqlash)
- ✅ Destroy (O'chirish)

**Yo'q funksiyalar:**
- ❌ Edit (Tahrirlash sahifasi)
- ❌ Update (Yangilash)
- ❌ Show (Batafsil ko'rish)

---

## 🎯 Amalga Oshirish Rejasi

### 1-Bosqich: Controller Metodlarini Qo'shish

**Fayl:** `app/Http/Controllers/Admin/PermissionController.php`

#### 1.1 Edit Metodi
```php
public function edit(Permission $permission)
{
    return view('admin.permissions.edit', compact('permission'));
}
```

#### 1.2 Update Metodi
```php
public function update(Request $request, Permission $permission)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
    ]);

    $permission->update(['name' => $validated['name']]);

    return redirect()->route('admin.permissions.index')
        ->with('success', 'Ruxsat muvaffaqiyatli yangilandi!');
}
```

#### 1.3 Show Metodi (Ixtiyoriy)
```php
public function show(Permission $permission)
{
    // Permission qaysi rollarga biriktirilgan
    $roles = $permission->roles()->with('users')->get();
    
    // Permission qaysi foydalanuvchilarga to'g'ridan-to'g'ri biriktirilgan
    $users = $permission->users()->get();
    
    return view('admin.permissions.show', compact('permission', 'roles', 'users'));
}
```

---

### 2-Bosqich: Routes Qo'shish

**Fayl:** `routes/web.php`

Qo'shimcha routelar:
```php
// Permissions edit
Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])
    ->middleware('permission:assign-permissions')
    ->name('permissions.edit');

// Permissions update
Route::put('/permissions/{permission}', [PermissionController::class, 'update'])
    ->middleware('permission:assign-permissions')
    ->name('permissions.update');

// Permissions show (ixtiyoriy)
Route::get('/permissions/{permission}', [PermissionController::class, 'show'])
    ->middleware('permission:view-permissions')
    ->name('permissions.show');
```

---

### 3-Bosqich: View Fayllarini Yaratish

#### 3.1 Edit View
**Fayl:** `resources/views/admin/permissions/edit.blade.php`

**Tarkibi:**
- Permission nomini tahrirlash input
- Validation xatolari
- Saqlash va Bekor qilish tugmalari
- Orqaga qaytish linki

#### 3.2 Show View (Ixtiyoriy)
**Fayl:** `resources/views/admin/permissions/show.blade.php`

**Tarkibi:**
- Permission nomi
- Qaysi rollarga biriktirilgan
- Qaysi foydalanuvchilarga biriktirilgan
- Statistika (jami rollar, foydalanuvchilar)
- Tahrirlash tugmasi
- Orqaga qaytish linki

---

### 4-Bosqich: Index View ni Yangilash

**Fayl:** `resources/views/admin/permissions/index.blade.php`

**Qo'shilishi kerak:**
- Har bir permission uchun "Tahrirlash" tugmasi
- Har bir permission uchun "Ko'rish" tugmasi (ixtiyoriy)
- Actions ustuni

**O'zgartirishlar:**
```blade
<div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
    <span class="text-sm text-gray-700">{{ $permission->name }}</span>
    <div class="flex items-center space-x-2">
        <!-- Ko'rish -->
        <a href="{{ route('admin.permissions.show', $permission) }}" 
           class="text-blue-600 hover:text-blue-900 text-sm">
            <i class="fas fa-eye"></i>
        </a>
        
        <!-- Tahrirlash -->
        @can('assign-permissions')
        <a href="{{ route('admin.permissions.edit', $permission) }}" 
           class="text-yellow-600 hover:text-yellow-900 text-sm">
            <i class="fas fa-edit"></i>
        </a>
        @endcan
        
        <!-- O'chirish -->
        @can('assign-permissions')
        <form action="{{ route('admin.permissions.destroy', $permission) }}" 
              method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="text-red-600 hover:text-red-900 text-sm" 
                    onclick="return confirm('Rostdan ham o\'chirmoqchimisiz?')">
                <i class="fas fa-trash"></i>
            </button>
        </form>
        @endcan
    </div>
</div>
```

---

## 🔧 5-Bosqich: Qo'shimcha Xususiyatlar

### 5.1 Bulk Actions (Ko'plab amallar)
- Bir necha permissionni tanlab o'chirish
- Bir necha permissionni rolga biriktirish

### 5.2 Search va Filter
- Permission nomiga qarab qidirish
- Guruhga qarab filter qilish
- Ishlatilmagan permissionlarni ko'rsatish

### 5.3 Validation Qoidalari
- Permission nomi faqat harflar, raqamlar va defis
- Permission nomi unique bo'lishi
- Permission nomi kamida 3 ta belgidan iborat

### 5.4 Permission Name Convention
- Format: `action-resource` (masalan: `view-users`, `create-posts`)
- Avtomatik validate qilish

---

## 📊 6-Bosqich: Ma'lumotlar va Statistika

### Show sahifasida ko'rsatish kerak:

1. **Asosiy Ma'lumotlar:**
   - Permission ID
   - Permission nomi
   - Guard name
   - Yaratilgan sana
   - Oxirgi yangilangan sana

2. **Bog'langan Rollar:**
   - Rol nomi
   - Rol foydalanuvchilari soni
   - Rolga o'tish linki

3. **Bog'langan Foydalanuvchilar:**
   - Foydalanuvchi nomi va emaili
   - Foydalanuvchiga o'tish linki

4. **Statistika:**
   - Jami rollar soni
   - Jami foydalanuvchilar soni
   - Ko'p ishlatiladigan permissionlar

---

## 🎨 7-Bosqich: UI/UX Yaxshilashlar

### 7.1 Permission Groups
```php
// Controller da
$permissions = Permission::all()->groupBy(function($permission) {
    $parts = explode('-', $permission->name);
    return $parts[1] ?? 'other';
});
```

### 7.2 Color Coding
- Users related: Blue
- Roles related: Purple
- Permissions related: Green
- Settings related: Gray
- Posts related: Orange

### 7.3 Icons
- view: fa-eye
- create: fa-plus
- edit: fa-edit
- delete: fa-trash
- assign: fa-user-tag

---

## ✅ Tekshirish Ro'yxati

### Controller
- [ ] Edit metodi qo'shildi
- [ ] Update metodi qo'shildi
- [ ] Show metodi qo'shildi
- [ ] Validation qo'shildi
- [ ] Error handling qo'shildi

### Routes
- [ ] Edit route qo'shildi
- [ ] Update route qo'shildi
- [ ] Show route qo'shildi
- [ ] Middleware to'g'ri qo'llandi

### Views
- [ ] Edit view yaratildi
- [ ] Show view yaratildi
- [ ] Index view yangilandi
- [ ] Tugmalar qo'shildi
- [ ] Icons qo'shildi

### Testing
- [ ] Permission tahrirlash ishlaydi
- [ ] Permission yangilash ishlaydi
- [ ] Permission ko'rish ishlaydi
- [ ] Validation ishlaydi
- [ ] Permission o'chirish ishlaydi

---

## 🚀 Boshlash Tartibi

1. **Controller metodlarini yozish** (5 daqiqa)
2. **Routes qo'shish** (2 daqiqa)
3. **Edit view yaratish** (5 daqiqa)
4. **Show view yaratish** (10 daqiqa)
5. **Index view ni yangilash** (5 daqiqa)
6. **Tekshirish va test qilish** (5 daqiqa)

**Jami vaqt:** ~30 daqiqa

---

## 📝 Eslatma

- Permission nomini o'zgartirish juda ehtiyotkorlik talab qiladi
- O'zgartirish paytida barcha role-permission bog'lanishlar saqlanadi
- Agar permission kodda ishlatilsa, nomini o'zgartirish xato keltirib chiqarishi mumkin
- Shuning uchun permission nomini o'zgartirish jarayonida ogohlantirish berish tavsiya etiladi

---

**Yaratilgan sana:** 2025-12-07  
**Maqsad:** Permissions uchun to'liq CRUD funksiyalarini qo'shish  
**Status:** Rejalashtirish bosqichi

