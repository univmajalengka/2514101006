# Tugas Pertemuan 6 - 8 — Program Hitung Diskon (PHP)

- **Nama:** Edrick Andreas
- **NPM:** 2514101006
- **Program Studi:** Informatika — Universitas Majalengka
- **Mata Kuliah:** Pemrograman Aplikasi Berbasis Web (PABW)

---

## 📌 Deskripsi Tugas

Program ini menggunakan **prosedur `hitungDiskon()`** yang menerima parameter **total belanja**, lalu mengembalikan **nilai diskon**. Nilai diskon itu kemudian dipakai untuk menghitung **total yang harus dibayar**.

### Ketentuan Diskon

| Total Belanja | Diskon |
|---|---|
| ≥ Rp. 100.000 | 10% |
| ≥ Rp. 50.000 dan < Rp. 100.000 | 5% |
| < Rp. 50.000 | Tidak ada diskon (0%) |

---

## 🧩 Prosedur `hitungDiskon()`

```php
function hitungDiskon($totalBelanja) {
    $diskon = 0;

    if ($totalBelanja >= 100000) {
        $diskon = 0.1 * $totalBelanja;  // Diskon 10%
    } elseif ($totalBelanja >= 50000) {
        $diskon = 0.05 * $totalBelanja; // Diskon 5%
    }
    // Total belanja < Rp. 50.000 tidak mendapat diskon

    return $diskon;
}
```

Total yang harus dibayar dihitung dengan rumus:

```php
$diskon     = hitungDiskon($totalBelanja);
$totalBayar = $totalBelanja - $diskon;
```

---

## ✨ Fitur Program

- Input total belanja melalui form.
- Saat halaman pertama kali dibuka, semua nilai dimulai dari **Rp. 0**.
- Tombol **Hitung Diskon** untuk menghitung diskon dan total bayar.
- Tombol **↺ Reset** untuk mengembalikan semua nilai ke 0.
- Kotak ketentuan diskon (0%, 5%, 10%) yang berlaku akan **disorot** otomatis.
- Angka ditampilkan dalam format Rupiah (contoh: `Rp. 120.000`).
- Ada pesan error jika input tidak valid (misalnya angka negatif).
- Hasil hilang saat halaman di-refresh, jadi tidak muncul angka lama.
- Tampilan **responsive**: 2 kolom di laptop/PC, 1 kolom di HP/tablet.

---

## 🧪 Contoh Hasil

| Total Belanja | Diskon | Total yang Harus Dibayar |
|---|---|---|
| Rp. 120.000 | Rp. 12.000 (10%) | Rp. 108.000 |
| Rp. 75.000 | Rp. 3.750 (5%) | Rp. 71.250 |
| Rp. 30.000 | Rp. 0 (0%) | Rp. 30.000 |

---

## 🚀 Cara Menjalankan

1. Install dan jalankan **XAMPP**, lalu aktifkan **Apache**.
2. Salin file `diskon.php` ke dalam folder `C:\xampp\htdocs\tugas_per6_8\`.
3. Buka browser dan akses:
   ```
   http://localhost/tugas_per6_8/diskon.php
   ```
4. Masukkan total belanja, lalu klik **Hitung Diskon**.

---

## 📁 Struktur File

```
Tugas Pertemuan 6 - 8/
├── README.md    # Dokumentasi tugas
└── diskon.php   # Program hitung diskon
```
