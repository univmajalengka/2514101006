<h1 align="center">🛒 Kalkulator Diskon Belanja</h1>

<p align="center">
  Tugas Pertemuan 6 - 8 &nbsp;•&nbsp; PABW
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white" alt="HTML5">
  <img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white" alt="CSS3">
  <img src="https://img.shields.io/badge/XAMPP-FB7A24?style=for-the-badge&logo=xampp&logoColor=white" alt="XAMPP">
</p>

---

## 📝 Soal

Bikin program pakai prosedur `hitungDiskon()` yang nerima parameter total belanja. Aturannya:

| 💰 Total Belanja | 🏷️ Diskon |
|:---|:---:|
| >= Rp. 100.000 | **10%** |
| >= Rp. 50.000 tapi < Rp. 100.000 | **5%** |
| < Rp. 50.000 | **0%** |

Nilai diskon dari prosedur itu dipakai buat ngitung total yang harus dibayar.

## ⚙️ Penjelasan Kode

Di dalam prosedur `hitungDiskon()`, total belanja dicek pakai `if` dan `elseif`. Kalau belanjanya di bawah 50 ribu, nggak masuk ke kondisi mana pun, jadi diskonnya tetap 0.

```php
function hitungDiskon($totalBelanja) {
    $diskon = 0;

    if ($totalBelanja >= 100000) {
        $diskon = 0.1 * $totalBelanja;   // 10%
    } elseif ($totalBelanja >= 50000) {
        $diskon = 0.05 * $totalBelanja;  // 5%
    }

    return $diskon;
}
```

Terus total bayarnya tinggal total belanja dikurangi diskon:

```php
$diskon     = hitungDiskon($totalBelanja);
$totalBayar = $totalBelanja - $diskon;
```

## 🖥️ Tampilan Program

- ✏️ Angka total belanja diisi lewat form, awalnya semua masih **Rp. 0**
- 🧮 Klik **Hitung Diskon** buat lihat hasilnya
- 🔄 Klik **Reset** kalau mau balik ke 0 lagi
- 🎯 Kotak diskon yang kepakai (0% / 5% / 10%) bakal ke-highlight
- 📱 Bisa dibuka di laptop maupun HP

## 🧪 Contoh Hasil

| Total Belanja | Diskon | Total Bayar |
|---:|---:|---:|
| Rp. 120.000 | Rp. 12.000 | **Rp. 108.000** |
| Rp. 75.000 | Rp. 3.750 | **Rp. 71.250** |
| Rp. 30.000 | Rp. 0 | **Rp. 30.000** |

## 🚀 Cara Menjalankan

1. Buka XAMPP, nyalain **Apache**
2. Taruh `diskon.php` di folder `htdocs`, contohnya `htdocs/tugas_per6_8/`
3. Buka browser, ketik:
   ```
   http://localhost/tugas_per6_8/diskon.php
   ```

## 📂 Isi Folder

```
Tugas Pertemuan 6 - 8/
├── README.md
└── diskon.php
```
