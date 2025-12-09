# Activity Log (Harakatlar Jurnali) Tizimi - Reja

## 🎯 Maqsad
Tizimda amalga oshirilgan barcha CRUD amallarni track qilish va saqlash. Har bir amal quyidagi ma'lumotlar bilan saqlanadi:
- Kim (User)
- Nima (Action: create, update, delete, view)
- Qayerda (Model: User, Role, Permission)
- Qachon (DateTime)
- Qaysi qurilmadan (Device, Browser)
- Qaysi tarmoqdan (IP Address)
- Qanday o'zgarishlar (Old/New values)

---

## 📋 Bosqichlar

### 1-Bosqich: Ma'lumotlar Bazasi
- Activity logs jadvali yaratish
- Indexes qo'shish (performance uchun)
- Foreign keys sozlash

### 2-Bosqich: Model va Observer
- ActivityLog model yaratish
- Observer pattern ishlatish
- Automatic logging

### 3-Bosqich: Trait va Helper
- LogsActivity trait yaratish
- Helper funksiyalar
- IP, Device detection

### 4-Bosqich: Controller Integration
- Barcha controller larga qo'shish
- Manual logging qo'shish
- Error handling

### 5-Bosqich: View va UI
- Activity log ko'rish sahifasi
- Filter va search
- Timeline view
- Export funksiyasi

---

## 🗄️ Ma'lumotlar Bazasi Strukturasi

### activity_logs jadvali

```sql
id - bigint (primary key)
user_id - bigint (foreign key to users)
subject_type - string (Model nomi: User, Role, Permission)
subject_id - bigint (Model ID)
action - enum (create, update, delete, view, login, logout)
description - text (Tavsif)
properties - json (Old/New values)
ip_address - string
user_agent - text
device - string
browser - string
platform - string
created_at - timestamp
updated_at - timestamp
```

### Indexes
- user_id
- subject_type, subject_id
- action
- created_at

---

## 📦 Activity Log Model

```php
class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'subject_type',
        'subject_id',
        'action',
        'description',
        'properties',
        'ip_address',
        'user_agent',
        'device',
        'browser',
        'platform',
    ];

    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->morphTo();
    }
}
```

---

## 🎭 LogsActivity Trait

```php
trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            self::logActivity('create', $model);
        });

        static::updated(function ($model) {
            self::logActivity('update', $model);
        });

        static::deleted(function ($model) {
            self::logActivity('delete', $model);
        });
    }

    protected static function logActivity($action, $model)
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'subject_type' => get_class($model),
            'subject_id' => $model->id,
            'action' => $action,
            'description' => self::getDescription($action, $model),
            'properties' => self::getProperties($action, $model),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'device' => self::detectDevice(),
            'browser' => self::detectBrowser(),
            'platform' => self::detectPlatform(),
        ]);
    }
}
```

---

## 🔍 Detection Funksiyalar

### Device Detection
- Mobile
- Tablet
- Desktop
- Bot

### Browser Detection
- Chrome
- Firefox
- Safari
- Edge
- Opera

### Platform Detection
- Windows
- Mac
- Linux
- Android
- iOS

---

## 🎨 UI Components

### Activity Log Index
- Table view (barcha loglar)
- Filter (user, action, date range)
- Search (description)
- Pagination
- Export (CSV, Excel)

### Activity Log Show
- Batafsil ma'lumot
- Old vs New comparison
- User info
- Device info
- Timestamp

### Dashboard Widget
- Recent activities (oxirgi 10 ta)
- Activity chart (kunlik)
- Most active users
- Action statistics

---

## 📊 Statistika

### Dashboard da ko'rsatish:
1. Bugungi amallar soni
2. Oxirgi 7 kundagi amallar
3. Eng faol foydalanuvchilar
4. Amal turlari taqsimoti (pie chart)

### Activity sahifasida:
1. Jami loglar soni
2. Action breakdown (create, update, delete)
3. Timeline view
4. Filter by date, user, action

---

## 🔐 Xavfsizlik

### Ruxsatlar
- `view-activity-logs` - Loglarni ko'rish
- `export-activity-logs` - Loglarni export qilish
- `delete-activity-logs` - Loglarni o'chirish (faqat super-admin)

### Qoidalar
- Oddiy user o'z loglarini ko'ra oladi
- Admin barcha loglarni ko'ra oladi
- Super admin loglarni o'chira oladi
- Loglarni o'zgartirish mumkin emas (read-only)

---

## 🚀 Implementatsiya Tartibi

### 1. Migration va Model (15 min)
```bash
php artisan make:migration create_activity_logs_table
php artisan make:model ActivityLog
```

### 2. Trait va Helper (20 min)
```bash
app/Traits/LogsActivity.php
app/Helpers/ActivityHelper.php
```

### 3. Observer (15 min)
```bash
php artisan make:observer UserObserver --model=User
php artisan make:observer RoleObserver --model=Role
php artisan make:observer PermissionObserver
```

### 4. Controller (20 min)
```bash
php artisan make:controller Admin/ActivityLogController
```

### 5. Views (30 min)
- resources/views/admin/activities/index.blade.php
- resources/views/admin/activities/show.blade.php
- resources/views/components/activity-card.blade.php

### 6. Routes va Permissions (10 min)
- Routes qo'shish
- Permission qo'shish
- Middleware sozlash

**Jami:** ~2 soat

---

## 📝 Saqlanadiganlar

### Create Amal
```json
{
    "action": "create",
    "model": "User",
    "new_values": {
        "name": "John Doe",
        "email": "john@example.com",
        "roles": ["admin"]
    }
}
```

### Update Amal
```json
{
    "action": "update",
    "model": "User",
    "old_values": {
        "name": "John Doe",
        "is_active": true
    },
    "new_values": {
        "name": "John Smith",
        "is_active": false
    },
    "changed_fields": ["name", "is_active"]
}
```

### Delete Amal
```json
{
    "action": "delete",
    "model": "User",
    "deleted_data": {
        "name": "John Doe",
        "email": "john@example.com"
    }
}
```

---

## 🎨 UI Dizayni

### Colors
- **Create**: Green (yangi yaratish)
- **Update**: Blue (yangilash)
- **Delete**: Red (o'chirish)
- **View**: Purple (ko'rish)
- **Login**: Cyan (kirish)

### Icons
- Create: fa-plus-circle
- Update: fa-edit
- Delete: fa-trash
- View: fa-eye
- Login: fa-sign-in-alt
- Logout: fa-sign-out-alt

### Timeline View
```
[HH:MM] ●──── User created "John Doe"
         │     by: Admin User
         │     from: 192.168.1.1 (Windows, Chrome)
         │
[HH:MM] ●──── Role updated "Editor"
         │     by: Super Admin
         │     from: 192.168.1.2 (Mac, Safari)
```

---

## 📈 Performance

### Optimizatsiya
- Index qo'shish
- Eager loading (with user, subject)
- Pagination (25 per page)
- Cache (popular queries)
- Archive old logs (90 kundan eski)

### Cleanup
```bash
# 90 kundan eski loglarni o'chirish
php artisan activitylog:clean
```

---

## ✅ Tekshirish Ro'yxati

- [ ] Migration yaratildi
- [ ] Model yaratildi
- [ ] Trait yaratildi
- [ ] Observer yaratildi
- [ ] Helper funksiyalar
- [ ] Controller yaratildi
- [ ] Routes qo'shildi
- [ ] Permissions qo'shildi
- [ ] Views yaratildi
- [ ] UI test qilindi
- [ ] Performance test
- [ ] Security check

---

**Yaratilgan:** 2025-12-07  
**Maqsad:** Activity Log tizimini qurish  
**Status:** Boshlash tayyor

