# Super Admin Permission Seeder Qo'llanmasi

Bu qo'llanma yangi ruxsatlar qo'shish va admin roliga biriktirish uchun `AdminPermissionSeeder` dan qanday foydalanishni ko'rsatadi.

## Kirish

Loyihada yangi funksional yoki menyu qo'shganda, uni admin roliga ruxsat biriktirish kerak. Buning uchun `AdminPermissionSeeder` seederidan foydalaniladi.

## AdminPermissionSeeder dan foydalanish

### 1. Yangi ruxsatlar qo'shish

`database/seeders/AdminPermissionSeeder.php` faylini oching va `$newPermissions` massiviga yangi ruxsatlarni qo'shing:

```php
$newPermissions = [
    'view-new-feature',      // Yangi funksiyani ko'rish
    'create-new-feature',    // Yangi funksiyani yaratish
    'edit-new-feature',      // Yangi funksiyani tahrirlash
    'delete-new-feature',    // Yangi funksiyani o'chirish
];
```

### 2. Seeder ni ishga tushirish

Seeder ni ishga tushirish uchun quyidagi buyruqni bajaring:

```bash
php artisan db:seed --class=AdminPermissionSeeder
```

Yoki `DatabaseSeeder` ga qo'shing:

```php
public function run(): void
{
    $this->call([
        RolePermissionSeeder::class,
        AdminPermissionSeeder::class, // Yangi seeder
    ]);
}
```

## Misol: Yangi "Xabarlar" moduli qo'shish

### 1-qadam: Navigation faylida ruxsat tekshiruvi qo'shing

`resources/views/layouts/admin-navigation.blade.php` faylida:

```blade
@can('view-messages')
<x-nav-link :href="route('admin.messages.index')" :active="request()->routeIs('admin.messages.*')">
    <i class="fas fa-envelope mr-2"></i>{{ __('Xabarlar') }}
</x-nav-link>
@endcan
```

### 2-qadam: Route da ruxsat middleware qo'shing

`routes/web.php` faylida:

```php
Route::resource('messages', MessageController::class)
    ->middleware('permission:view-messages');
```

### 3-qadam: AdminPermissionSeeder ga ruxsatlar qo'shing

`database/seeders/AdminPermissionSeeder.php` faylida:

```php
$newPermissions = [
    'view-messages',
    'create-messages',
    'edit-messages',
    'delete-messages',
];
```

### 4-qadam: Seeder ni ishga tushiring

```bash
php artisan db:seed --class=AdminPermissionSeeder
```

## Ruxsatlar nomlash konventsiyasi

Ruxsatlar quyidagi formatda nomlanadi:

- `view-{resource}` - Ro'yxatni ko'rish
- `create-{resource}` - Yangi yaratish
- `edit-{resource}` - Tahrirlash
- `delete-{resource}` - O'chirish
- `export-{resource}` - Eksport qilish (agar kerak bo'lsa)
- `publish-{resource}` - Nashr qilish (agar kerak bo'lsa)

## Mavjud ruxsatlar

Loyihada quyidagi ruxsatlar mavjud:

### Foydalanuvchilar
- `view-users`
- `create-users`
- `edit-users`
- `delete-users`

### Rollar
- `view-roles`
- `create-roles`
- `edit-roles`
- `delete-roles`

### Ruxsatlar
- `view-permissions`
- `create-permissions`
- `edit-permissions`
- `delete-permissions`

### Guruhlar
- `view-groups`
- `create-groups`
- `edit-groups`
- `delete-groups`

### Darslar
- `view-lessons`
- `create-lessons`
- `edit-lessons`
- `delete-lessons`

### Qurollar
- `view-toys`
- `create-toys`
- `edit-toys`
- `delete-toys`

### Activity Logs
- `view-activity-logs`
- `export-activity-logs`
- `delete-activity-logs`

### Dashboard
- `view-dashboard`

### Sozlamalar
- `view-settings`
- `edit-settings`

### Hisobotlar
- `view-reports`
- `export-reports`

### Kontent boshqaruvi
- `view-posts`
- `create-posts`
- `edit-posts`
- `delete-posts`
- `publish-posts`

## Muhim eslatmalar

1. **Cache tozalash**: Seeder avtomatik ravishda permission cache ni tozalaydi
2. **Mavjud ruxsatlar**: Agar ruxsat allaqachon mavjud bo'lsa, `firstOrCreate` metodi uni qayta yaratmaydi
3. **Admin roli**: Faqat `admin` roliga ruxsatlar biriktiriladi. `super-admin` roliga barcha ruxsatlar avtomatik biriktiriladi
4. **Seeder ishga tushirish**: Har safar yangi ruxsat qo'shganda seeder ni qayta ishga tushirish kerak

## Tekshirish

Ruxsatlar to'g'ri biriktirilganligini tekshirish uchun:

```bash
php artisan tinker
```

Tinker da:

```php
$admin = Role::where('name', 'admin')->first();
$admin->permissions->pluck('name');
```

Bu buyruq admin rolining barcha ruxsatlarini ko'rsatadi.

## Xatoliklarni hal qilish

### Ruxsat ko'rinmayapti

1. Cache ni tozalash:
```bash
php artisan permission:cache-reset
```

2. Seeder ni qayta ishga tushirish:
```bash
php artisan db:seed --class=AdminPermissionSeeder
```

### Admin roliga ruxsat biriktirilmagan

1. `AdminPermissionSeeder.php` faylida `$newPermissions` massivini tekshiring
2. Seeder ni qayta ishga tushiring
3. Admin roli mavjudligini tekshiring:
```php
$adminRole = Role::where('name', 'admin')->first();
```

## Qo'shimcha ma'lumot

- [Spatie Permission Paketi](https://spatie.be/docs/laravel-permission)
- [Laravel Seederlar](https://laravel.com/docs/seeding)

