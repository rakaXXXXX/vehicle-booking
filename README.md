# Sistem Pemesanan Kendaraan - PT Nikel Mining

## 🚀 Instalasi Cepat

```
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

**URL:** http://127.0.0.1:8000  
**Admin Login:** `admin@nikel.co` / `admin123`

## 👥 Akun Demo (Seeder)

| Role | Email | Password | Hak Akses |
|------|-------|----------|-----------|
| **Admin** | `admin@nikel.co` | `admin123` | Full Access |
| **Supervisor** | `supervisor@nikel.co` | `supervisor123` | Persetujuan Tingkat 1 |
| **Manager** | `manager@nikel.co` | `manager123` | Persetujuan Tingkat 2 |
| **Karyawan** | `employee@nikel.co` | `employee123` | Lihat Pemesanan |
| **Sopir** | `driver@nikel.co` | `driver123` | Tugas Sopir |

## 🎯 Alur Kerja Lengkap

```
1. ADMIN → Vehicles → "Tambah Kendaraan"
   ↓
2. ADMIN → Bookings → "Pemesanan Baru"
   • Pilih Kendaraan (available)
   • Tentukan Sopir 
   • Tentukan Supervisor + Manager
   • Tujuan → Submit
   ↓
3. SUPERVISOR → Approvals → Approve Tingkat 1
   ↓
4. MANAGER → Approve Tingkat 2 → "APPROVED"
   ↓
5. Reports → Filter → Download Excel
```

## ✨ Fitur Lengkap

### **Admin Dashboard**
- 📊 Statistik real-time
- 🚗 Manajemen kendaraan (CRUD)
- 📅 Pemesanan kendaraan 

### **Approval Workflow**
```
Pending → Supervisor L1 → Manager L2 → APPROVED
                 ↓
           Vehicle = "in_use"
```

### **Reports & Analytics**
```
📈 Dashboard charts
📊 Excel export (periode/region)
🔍 Filter lanjutan
```

### **Role Based Access Control**
```
Admin: Semua fitur
Supervisor: Approval L1 only
Manager: Approval L2 only
User: View only
```

## 🛠️ Command Penting

```
# Reset database
php artisan migrate:fresh --seed

# Clear cache
php artisan optimize:clear

# Add test data
php artisan tinker
>>> App\Models\Vehicle::factory(10)->create()
```

## 📱 Demo Flow (Admin)

```
1. Login admin → Vehicles → Add 3 cars
2. Bookings → New → Fill all fields → Submit  
3. Logout → Login Supervisor → Approvals → Approve
4. Login Manager → Approve → See "APPROVED"
5. Reports → Export Excel
```

## ✅ Status Sistem

```
Login: ✅ Fixed
Vehicles CRUD: ✅ 
Bookings: ✅ Admin create + approvers
Approval workflow: ✅ Multi-level
Reports Excel: ✅ Filtered export
Dashboard: ✅ Analytics
RBAC: ✅ Role-based
README ID: ✅ Bahasa Indonesia

**ALL GREEN - Production Ready!**
```


