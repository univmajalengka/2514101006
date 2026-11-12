<?php
/*
 * Program Menghitung Diskon Belanja
 * Menggunakan prosedur hitungDiskon() yang menerima parameter total belanja
 */

// Prosedur untuk menghitung diskon berdasarkan total belanja
function hitungDiskon($totalBelanja) {
    $diskon = 0;

    if ($totalBelanja >= 100000) {
        $diskon = 0.1 * $totalBelanja;  // Diskon 10% untuk total belanja >= Rp. 100.000
    } elseif ($totalBelanja >= 50000) {
        $diskon = 0.05 * $totalBelanja; // Diskon 5% untuk total belanja >= Rp. 50.000 dan < Rp. 100.000
    }
    // Total belanja < Rp. 50.000 tidak mendapat diskon (diskon tetap 0)

    return $diskon;
}

// Fungsi bantu untuk menampilkan angka dalam format Rupiah
function formatRupiah($nilai) {
    return "Rp. " . number_format($nilai, 0, ',', '.');
}

// Session dipakai untuk menyimpan hasil sementara, supaya saat halaman
// dibuka ulang / di-refresh angkanya kembali ke 0
session_start();

// Nilai awal (default) semuanya 0, harus memasukkan angka terlebih dahulu
$totalBelanja = 0;
$diskon       = 0;
$totalBayar   = 0;
$persen       = 0;
$sudahHitung  = false;
$pesanError   = "";

// Proses ketika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['reset'])) {
        // Tombol Reset ditekan: hapus hasil, semua kembali ke 0
        unset($_SESSION['hasil'], $_SESSION['error']);
    } else {
        $input = trim($_POST['belanja'] ?? '');

        if ($input !== "" && is_numeric($input) && $input >= 0) {
            $belanja = (float) $input;

            // Memanggil prosedur hitungDiskon()
            $nilaiDiskon = hitungDiskon($belanja);

            // Simpan hasil perhitungan untuk ditampilkan satu kali
            $_SESSION['hasil'] = [
                'totalBelanja' => $belanja,
                'diskon'       => $nilaiDiskon,
                'totalBayar'   => $belanja - $nilaiDiskon, // total yang harus dibayar
            ];
        } else {
            $_SESSION['error'] = "Masukkan total belanja berupa angka yang valid (tidak boleh negatif).";
        }
    }

    // Arahkan ulang ke halaman ini (agar refresh tidak mengirim ulang form)
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Ambil hasil (jika ada) lalu langsung dihapus,
// sehingga ketika dibuka/di-refresh lagi angkanya reset ke 0
if (isset($_SESSION['hasil'])) {
    $totalBelanja = $_SESSION['hasil']['totalBelanja'];
    $diskon       = $_SESSION['hasil']['diskon'];
    $totalBayar   = $_SESSION['hasil']['totalBayar'];

    // Persentase diskon diambil dari hasil prosedur (untuk keterangan)
    $persen = ($totalBelanja > 0) ? round($diskon / $totalBelanja * 100) : 0;

    $sudahHitung = true;
    unset($_SESSION['hasil']);
}

if (isset($_SESSION['error'])) {
    $pesanError = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Diskon Belanja</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        html, body { height: 100%; }

        body {
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            font-family: "Segoe UI", system-ui, -apple-system, sans-serif;
            font-size: 14px;
            background: radial-gradient(circle at top left, #c7d2fe, transparent 40%),
                        radial-gradient(circle at bottom right, #fbcfe8, transparent 40%),
                        #f5f3ff;
            color: #1e1b4b;
        }

        /* ===== Kartu utama ===== */
        .kartu {
            width: 100%;
            max-width: 780px;
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(79, 70, 229, .18);
        }

        /* ===== Header (ringkas, ikon di samping judul) ===== */
        .header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 22px;
            background: linear-gradient(135deg, #4f46e5, #9333ea);
            color: #fff;
        }

        .header .ikon {
            flex-shrink: 0;
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            font-size: 20px;
            background: rgba(255, 255, 255, .2);
            border-radius: 10px;
        }

        .header h1 { font-size: 18px; font-weight: 700; line-height: 1.2; }
        .header p  { font-size: 12px; opacity: .85; margin-top: 2px; }

        /* ===== Isi: 2 kolom di layar lebar ===== */
        .isi {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
            padding: 20px 22px 22px;
        }

        .kolom { display: flex; flex-direction: column; min-width: 0; }

        .judul-bagian {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            margin-bottom: 8px;
        }

        .judul-bagian.jarak { margin-top: 18px; }

        /* ===== Form ===== */
        .input-grup {
            display: flex;
            align-items: center;
            border: 2px solid #e0e7ff;
            border-radius: 10px;
            transition: border-color .2s, box-shadow .2s;
        }

        .input-grup:focus-within {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, .15);
        }

        .input-grup span {
            padding-left: 12px;
            font-weight: 700;
            color: #6366f1;
        }

        .input-grup input {
            flex: 1;
            min-width: 0;
            border: none;
            outline: none;
            padding: 10px 12px 10px 6px;
            font-size: 15px;
            background: transparent;
            color: #1e1b4b;
        }

        .tombol {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }

        button {
            padding: 10px 14px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            transition: transform .15s, box-shadow .15s, background .15s;
        }

        .btn-hitung {
            flex: 1;
            color: #fff;
            background: linear-gradient(135deg, #4f46e5, #9333ea);
            border: none;
        }

        .btn-hitung:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(99, 102, 241, .35);
        }

        .btn-reset {
            color: #4f46e5;
            background: #fff;
            border: 2px solid #e0e7ff;
        }

        .btn-reset:hover { background: #eef2ff; border-color: #c7d2fe; }

        .error {
            margin-top: 10px;
            padding: 8px 10px;
            font-size: 12px;
            color: #b91c1c;
            background: #fef2f2;
            border-radius: 8px;
        }

        /* ===== Ketentuan diskon ===== */
        .tingkat {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .tingkat div {
            padding: 8px 4px;
            text-align: center;
            border: 2px solid #eef2ff;
            border-radius: 10px;
            background: #fafaff;
            transition: all .2s;
        }

        .tingkat b     { display: block; font-size: 17px; color: #4f46e5; }
        .tingkat small { font-size: 10.5px; color: #64748b; line-height: 1.3; display: block; }

        .tingkat div.aktif {
            border-color: #8b5cf6;
            background: #f3e8ff;
        }

        /* ===== Hasil ===== */
        .rincian {
            background: #f8fafc;
            border-radius: 12px;
            padding: 2px 14px;
        }

        .baris {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            padding: 9px 0;
            border-bottom: 1px dashed #e2e8f0;
        }

        .baris:last-child { border-bottom: none; }
        .baris span:first-child { color: #64748b; }
        .baris span:last-child  { font-weight: 600; white-space: nowrap; }
        .baris .hemat { color: #16a34a; }

        .total-bayar {
            margin-top: 10px;
            padding: 14px;
            border-radius: 12px;
            text-align: center;
            background: linear-gradient(135deg, #eef2ff, #fae8ff);
        }

        .total-bayar small {
            font-size: 11px;
            color: #6b21a8;
            font-weight: 600;
            letter-spacing: .5px;
        }

        .total-bayar h2 {
            font-size: clamp(22px, 5vw, 26px);
            margin-top: 2px;
            word-break: break-word;
            background: linear-gradient(135deg, #4f46e5, #9333ea);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .catatan {
            margin-top: 8px;
            text-align: center;
            font-size: 11.5px;
            color: #94a3b8;
        }

        /* ===== Responsive: tablet & HP (1 kolom) ===== */
        @media (max-width: 680px) {
            body { padding: 12px; align-items: flex-start; }

            .kartu { border-radius: 14px; }

            .header { padding: 14px 16px; }
            .header h1 { font-size: 16px; }
            .header p  { display: none; }

            .isi {
                grid-template-columns: 1fr;
                gap: 16px;
                padding: 16px;
            }

            .judul-bagian.jarak { margin-top: 14px; }
        }

        /* ===== HP kecil ===== */
        @media (max-width: 360px) {
            body { padding: 8px; }
            .isi { padding: 14px 12px; }
            .tingkat small { font-size: 9.5px; }
            .btn-reset { padding: 10px; }
        }

        /* ===== Layar pendek (misal HP mode landscape) ===== */
        @media (max-height: 500px) and (min-width: 681px) {
            body { padding: 8px; }
            .header { padding: 10px 18px; }
            .isi { padding: 14px 18px; }
        }
    </style>
</head>
<body>

<div class="kartu">

    <!-- Header -->
    <div class="header">
        <div class="ikon">🛒</div>
        <div>
            <h1>Kalkulator Diskon Belanja</h1>
            <p>Masukkan total belanja untuk menghitung diskon dan total pembayaran.</p>
        </div>
    </div>

    <div class="isi">

        <!-- Kolom kiri: input & ketentuan diskon -->
        <div class="kolom">
            <p class="judul-bagian">Total Belanja</p>

            <form method="post" autocomplete="off">
                <div class="input-grup">
                    <span>Rp.</span>
                    <input type="number" id="belanja" name="belanja" min="0" step="1"
                           placeholder="0"
                           value="<?= $sudahHitung ? htmlspecialchars($totalBelanja) : '' ?>"
                           required>
                </div>
                <div class="tombol">
                    <button type="submit" class="btn-hitung">Hitung Diskon</button>
                    <button type="submit" name="reset" value="1" class="btn-reset" formnovalidate>↺ Reset</button>
                </div>
            </form>

            <?php if ($pesanError !== ""): ?>
                <div class="error"><?= $pesanError ?></div>
            <?php endif; ?>

            <!-- Ketentuan diskon (tingkat yang berlaku akan disorot) -->
            <p class="judul-bagian jarak">Ketentuan Diskon</p>
            <div class="tingkat">
                <div class="<?= ($sudahHitung && $persen == 0) ? 'aktif' : '' ?>">
                    <b>0%</b>
                    <small>&lt; Rp. 50.000</small>
                </div>
                <div class="<?= ($sudahHitung && $persen == 5) ? 'aktif' : '' ?>">
                    <b>5%</b>
                    <small>Rp. 50.000 – 99.999</small>
                </div>
                <div class="<?= ($sudahHitung && $persen == 10) ? 'aktif' : '' ?>">
                    <b>10%</b>
                    <small>&ge; Rp. 100.000</small>
                </div>
            </div>
        </div>

        <!-- Kolom kanan: hasil perhitungan (default 0) -->
        <div class="kolom">
            <p class="judul-bagian">Rincian Pembayaran</p>
            <div class="rincian">
                <div class="baris">
                    <span>Total Belanja</span>
                    <span><?= formatRupiah($totalBelanja) ?></span>
                </div>
                <div class="baris">
                    <span>Diskon (<?= $persen ?>%)</span>
                    <span class="hemat">- <?= formatRupiah($diskon) ?></span>
                </div>
            </div>

            <div class="total-bayar">
                <small>TOTAL YANG HARUS DIBAYAR</small>
                <h2><?= formatRupiah($totalBayar) ?></h2>
            </div>

            <?php if (!$sudahHitung): ?>
                <p class="catatan">Silakan masukkan total belanja terlebih dahulu.</p>
            <?php endif; ?>
        </div>

    </div>
</div>

</body>
</html>
