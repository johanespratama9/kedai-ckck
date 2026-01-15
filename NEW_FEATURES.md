# 🎉 Fitur Baru - Kedai CKCK

Dokumentasi untuk 2 fitur baru yang ditambahkan pada sistem Kedai CKCK.

---

## ✨ Fitur 1: Modal Detail Menu dengan Catatan Selera

### 📝 Deskripsi
Customer sekarang bisa klik gambar menu untuk melihat detail lengkap (gambar besar + deskripsi) dan menambahkan catatan selera pesanan seperti tingkat kepedasan, preferensi khusus, dll.

### 🎯 Cara Penggunaan

#### Untuk Customer:

**Step 1: Buka Halaman Order**
```
URL: http://[IP]:8000/order?meja={nomor_meja}
```

**Step 2: Klik Gambar Menu atau Tombol "Tambah"**
- Klik pada **gambar menu** yang diinginkan
- Atau klik tombol **"+ Tambah"** di bawah menu
- Modal dialog akan terbuka

**Step 3: Lihat Detail Menu**
Modal akan menampilkan:
- 🖼️ **Gambar besar** menu
- 📄 **Deskripsi lengkap** (bahan, cara masak, dll)
- 💰 **Harga** per porsi
- 🔢 **Input jumlah** pesanan (bisa + / -)

**Step 4: Tambahkan Catatan Selera**
Ada 2 cara:

**Cara 1: Klik Tombol Cepat**
- 🌿 **Tidak Pedas**
- 🌶️ **Pedas Sedang**
- 🔥 **Extra Pedas**
- 🧅 **Tanpa Bawang**
- 🥫 **Extra Saus**

Klik salah satu tombol untuk auto-fill catatan.

**Cara 2: Tulis Manual**
Ketik langsung di textarea, contoh:
```
- tanpa sayur, extra sambal
- matang betul, jangan terlalu pedas
- extra saus, tanpa bawang putih
- porsi nasi separuh
```

**Step 5: Atur Jumlah**
- Klik **"-"** untuk kurangi
- Klik **"+"** untuk tambah
- Atau ketik langsung di input (max 99)

**Step 6: Tambah ke Keranjang**
Klik tombol **"Tambah ke Keranjang"** (hijau)

**Step 7: Review di Keranjang**
Di tabel keranjang, Anda akan melihat:
- Nama menu
- **Catatan selera** (dengan icon pensil 📝)
- Jumlah & subtotal

---

### 💻 Implementasi Teknis

#### Database Changes
**Tabel:** `order_items`  
**Kolom baru:** `note_selera` (TEXT, nullable)

```sql
ALTER TABLE order_items ADD COLUMN note_selera TEXT NULL;
```

#### Files Modified

**1. `/resources/views/order/form.blade.php`**
- Tambah modal dialog untuk detail menu
- JavaScript functions: `openMenuModal()`, `closeMenuModal()`, `incrementQty()`, `decrementQty()`, `setNote()`
- Update card menu dengan `onclick` handler
- Tampilkan `note_selera` di tabel keranjang

**2. `/app/Http/Controllers/OrderController.php`**
- Method `addItem()` update untuk handle `note_selera`
- Validasi input `note_selera` (max 500 karakter)
- Simpan ke database saat create OrderItem

**3. `/app/Models/OrderItem.php`**
- Tambah `note_selera` ke `$fillable`

**4. `/database/migrations/2026_01_15_045741_add_note_selera_to_order_items_table.php`**
- Migration untuk add kolom `note_selera`

**5. `/resources/views/order/invoice.blade.php`**
- Tampilkan `note_selera` di detail item invoice
- Styling dengan icon dan italic text

---

### 🎨 UI/UX Features

**Modal Dialog:**
- Responsive design (mobile-friendly)
- Click outside atau ESC key untuk close
- Smooth animations (fade in/out)
- Image aspect ratio maintained
- Gradient backgrounds
- Shadow effects

**Quick Select Buttons:**
- Color-coded (hijau, kuning, merah, ungu, biru)
- Icon emoji untuk visual appeal
- Append text ke textarea (tidak replace)

**Keranjang Display:**
- Note ditampilkan di bawah nama menu
- Icon pensil 📝 untuk indikator
- Warna orange untuk highlight
- Italic text untuk distinguish

---

## 🔔 Fitur 2: Notifikasi Realtime saat Admin Approve/Reject

### 📝 Deskripsi
Customer akan mendapat notifikasi otomatis di halaman order/invoice saat admin approve atau reject pesanan. Notifikasi menampilkan nama admin yang approve/reject dan timestamp.

### 🎯 Cara Penggunaan

#### Flow Lengkap:

**Step 1: Customer Submit Order & Bayar**
1. Customer isi form order
2. Submit order
3. Upload bukti pembayaran
4. Status: `pending_approval`

**Step 2: Customer Tunggu di Halaman Invoice**
- Buka halaman invoice
- Sistem otomatis **polling** status order setiap 3 detik
- Customer bisa refresh manual atau tunggu auto-update

**Step 3: Admin Approve Pesanan**
1. Admin login ke `/admin`
2. Masuk menu **"Dapur"**
3. Klik **"Lihat Bukti"** untuk verifikasi
4. Klik dropdown **"📋 Approval"**
5. Pilih **"✅ Setujui Order"**
6. Konfirmasi approval

**Step 4: Customer Dapat Notifikasi**
Customer akan melihat:

**Notifikasi Toast** (kanan bawah):
```
✅ Pesanan diterima oleh [Nama Admin] pada [DD MMM YYYY HH:mm]
```

**Auto Reload:**
- Halaman otomatis reload setelah 2 detik
- Status berubah dari "Menunggu" → "Disetujui"
- Tombol berubah dari disabled → "Unduh Invoice (PDF)"

---

#### Jika Admin Reject:

**Step 1: Admin Reject Pesanan**
1. Admin klik **"❌ Tolak Order"**
2. Isi **alasan penolakan** (required)
3. Submit penolakan

**Step 2: Customer Dapat Notifikasi Reject**
Customer akan melihat:

**Notifikasi Toast:**
```
❌ Pesanan ditolak oleh [Nama Admin]. Cek alasan penolakan di atas.
```

**Alert Box** (merah):
```
❌ Order Ditolak
Alasan: [Alasan dari admin]
Silakan hubungi kasir untuk membuat order baru.
```

**Auto Reload:**
- Halaman reload setelah 2 detik
- Status berubah ke "Ditolak"
- Tombol disabled

---

### 💻 Implementasi Teknis

#### API Endpoint

**Route:** `GET /api/order/{order}/status`  
**File:** `/routes/api.php`

**Response JSON:**
```json
{
  "status": "paid",
  "approval_status": "approved",
  "status_makanan": "pesanan diterima",
  "approved_by_name": "Administrator",
  "approved_at": "15 Jan 2026 13:45"
}
```

#### Files Modified

**1. `/routes/api.php`** (NEW)
- Create API route untuk status check
- Return JSON dengan approval info
- Include `approved_by_name` dari relasi

**2. `/app/Models/Order.php`**
- Relasi `approvedBy()` sudah ada
- Cast `approved_at` ke datetime

**3. `/resources/views/order/form.blade.php`**
- JavaScript polling function `checkOrderStatus()`
- Interval: 5 detik
- Auto-redirect ke invoice saat approved
- Show notification toast

**4. `/resources/views/order/invoice.blade.php`**
- JavaScript polling function `checkOrderStatus()`
- Interval: 3 detik (lebih cepat dari form)
- Auto-reload halaman saat status berubah
- Show notification toast
- Alert boxes untuk 4 status

---

### 🔄 Polling Mechanism

**Interval Time:**
- **Form page:** 5 detik
- **Invoice page:** 3 detik

**Why Different?**
- Invoice lebih critical (customer waiting for approval)
- Form page bisa lebih slow (customer masih order)

**Auto Stop Conditions:**
- Status = `approved` → redirect/reload
- Status = `rejected` → reload
- Status = `pesanan selesai` → stop polling

**Prevent Duplicate Notifications:**
- Flag `hasNotifiedApproval` & `hasNotifiedRejection`
- Check substring sebelum append notification

---

### 🎨 Notification UI

**Toast Position:** Bottom-right (fixed)

**Toast Colors:**
- ✅ **Success:** Green (`bg-green-500`)
- ❌ **Error:** Red (`bg-red-500`)
- ⏳ **Warning:** Yellow (`bg-yellow-500`)
- ℹ️ **Info:** Blue (`bg-blue-500`)

**Animation:**
- Fade in from bottom
- Slide up effect
- Duration: 0.3s ease-in-out

**Auto Dismiss:**
- After 5 seconds
- Or manual close dengan button X

**Stacking:**
- Multiple notifications stack vertically
- Newest on bottom

---

## 🧪 Testing Guide

### Test Fitur 1: Modal & Catatan Selera

**Test Case 1: Modal Terbuka**
1. Buka `/order?meja=1`
2. Klik gambar menu "Nasi Goreng"
3. ✅ Modal terbuka dengan gambar besar
4. ✅ Deskripsi ditampilkan
5. ✅ Harga sesuai

**Test Case 2: Tombol Quick Select**
1. Klik "🌶️ Pedas Sedang"
2. ✅ Textarea terisi "Pedas Sedang"
3. Klik "🥫 Extra Saus"
4. ✅ Textarea jadi "Pedas Sedang, Extra Saus"

**Test Case 3: Input Manual**
1. Ketik "tanpa bawang, matang betul"
2. ✅ Text tersimpan

**Test Case 4: Quantity Control**
1. Klik tombol "+"
2. ✅ Quantity bertambah
3. Klik tombol "-"
4. ✅ Quantity berkurang (min 1)

**Test Case 5: Submit ke Keranjang**
1. Isi quantity = 2
2. Isi note = "Extra Pedas"
3. Klik "Tambah ke Keranjang"
4. ✅ Item masuk keranjang
5. ✅ Note ditampilkan di bawah nama menu

**Test Case 6: Close Modal**
1. Klik di luar modal
2. ✅ Modal tertutup
3. Press ESC key
4. ✅ Modal tertutup

---

### Test Fitur 2: Notifikasi Realtime

**Test Case 1: Customer Waiting**
1. Customer submit order & bayar
2. Buka invoice page
3. Status: "⏳ Menunggu Persetujuan Admin"
4. ✅ Polling started (check console)

**Test Case 2: Admin Approve**
1. Admin login & approve order
2. ✅ Customer dapat notif toast (green)
3. ✅ Notif text: "Pesanan diterima oleh Administrator pada [time]"
4. ✅ Halaman auto-reload setelah 2 detik
5. ✅ Status berubah: "✅ Order Disetujui & Pembayaran Diterima"
6. ✅ Tombol: "Unduh Invoice (PDF)"

**Test Case 3: Admin Reject**
1. Admin reject order dengan alasan "Bukti transfer tidak jelas"
2. ✅ Customer dapat notif toast (red)
3. ✅ Halaman reload
4. ✅ Alert box merah muncul
5. ✅ Alasan ditampilkan: "Bukti transfer tidak jelas"

**Test Case 4: Multiple Tabs**
1. Buka invoice di 2 tab
2. Admin approve
3. ✅ Kedua tab dapat notif
4. ✅ Kedua tab reload

**Test Case 5: Polling Stop**
1. Wait until status = approved
2. ✅ Polling interval cleared
3. ✅ Tidak ada request ke API lagi

---

## 📊 Database Schema Changes

### Tabel: `order_items`

**Before:**
```sql
CREATE TABLE order_items (
    id INTEGER PRIMARY KEY,
    order_id INTEGER,
    menu_id INTEGER,
    quantity INTEGER,
    subtotal INTEGER,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**After:**
```sql
CREATE TABLE order_items (
    id INTEGER PRIMARY KEY,
    order_id INTEGER,
    menu_id INTEGER,
    quantity INTEGER,
    subtotal INTEGER,
    note_selera TEXT NULL,  -- ← NEW
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

## 🔒 Security Considerations

### Fitur 1: Input Validation

**XSS Prevention:**
- Blade `{{ }}` auto-escape HTML
- `addslashes()` untuk modal data attributes
- Max length 500 karakter

**SQL Injection:**
- Eloquent ORM auto-sanitize
- Prepared statements

### Fitur 2: API Security

**CORS:** 
- Same-origin only
- No external access

**Rate Limiting:**
- Consider adding throttle middleware
- Prevent polling abuse

**Authentication:**
- No auth required for read-only status
- But order ID must be known

---

## 🚀 Performance Optimization

### Fitur 1: Modal

**Lazy Loading:**
- Modal HTML rendered once
- Data populated via JavaScript
- No DOM re-creation

**Image Optimization:**
- Consider webp format
- Lazy load images
- Thumbnail → full size

### Fitur 2: Polling

**Efficient Queries:**
- Only fetch necessary fields
- Use eager loading `with('approvedBy')`
- Index `id`, `approval_status`

**Reduce Requests:**
- Stop polling when done
- Use long polling (future)
- Consider WebSocket (future)

---

## 🔮 Future Enhancements

### Fitur 1:
- [ ] Upload foto custom request
- [ ] AI suggestion untuk catatan
- [ ] Template catatan per menu
- [ ] Voice input untuk catatan

### Fitur 2:
- [ ] Push notifications (service worker)
- [ ] WebSocket real-time (Laravel Echo + Pusher)
- [ ] Sound notification
- [ ] Email/SMS notification
- [ ] Admin typing indicator

---

## 📞 Support

Jika ada kendala dengan fitur baru:

1. **Check Console:** `F12` → Console tab
2. **Check Network:** Tab Network untuk API calls
3. **Clear Cache:** `Ctrl+Shift+R` atau `Cmd+Shift+R`
4. **Report Bug:** Hubungi developer dengan:
   - Screenshot error
   - Browser & version
   - Step to reproduce

---

**Last Updated:** 15 January 2026  
**Version:** 2.0.0  
**Author:** Kedai CKCK Dev Team
