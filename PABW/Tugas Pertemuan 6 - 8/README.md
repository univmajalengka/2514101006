# Tugas Pertemuan 6 - 8

Program PHP untuk menghitung diskon belanja menggunakan prosedur `hitungDiskon()`.

## Soal

Buat program menggunakan prosedur `hitungDiskon()` yang menerima parameter total belanja, dengan ketentuan:

- Total belanja >= Rp. 100.000 dapat diskon 10%
- Total belanja >= Rp. 50.000 tapi < Rp. 100.000 dapat diskon 5%
- Total belanja < Rp. 50.000 tidak dapat diskon

Nilai diskon yang dikembalikan prosedur dipakai untuk menghitung total yang harus dibayar.

## Penjelasan

Prosedur `hitungDiskon()` menerima total belanja, lalu dicek pakai `if` dan `elseif` untuk menentukan diskonnya. Kalau tidak masuk ke dua kondisi itu, diskon tetap 0.

```php
function hitungDiskon($totalBelanja) {
    $diskon = 0;

    if ($totalBelanja >= 100000) {
        $diskon = 0.1 * $totalBelanja;
    } elseif ($totalBelanja >= 50000) {
        $diskon = 0.05 * $totalBelanja;
    }

    return $diskon;
}
```

Setelah itu total bayar dihitung dari total belanja dikurangi diskon:

```php
$diskon     = hitungDiskon($totalBelanja);
$totalBayar = $totalBelanja - $diskon;
```

Total belanja dimasukkan lewat form. Waktu pertama dibuka semua nilainya masih 0, jadi harus isi angka dulu lalu klik Hitung Diskon. Ada juga tombol Reset untuk mengembalikan nilainya ke 0.

## Contoh

| Total Belanja | Diskon | Total Bayar |
|---|---|---|
| Rp. 120.000 | Rp. 12.000 | Rp. 108.000 |
| Rp. 75.000 | Rp. 3.750 | Rp. 71.250 |
| Rp. 30.000 | Rp. 0 | Rp. 30.000 |

## Cara Menjalankan

1. Jalankan Apache di XAMPP.
2. Simpan `diskon.php` di folder `htdocs`, misalnya `htdocs/tugas_per6_8/`.
3. Buka `http://localhost/tugas_per6_8/diskon.php` di browser.
