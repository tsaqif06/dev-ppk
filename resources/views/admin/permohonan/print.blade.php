<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Permohonan</title>
    <style>
        /* Tambahkan gaya CSS untuk tampilan cetak */
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 100px;
        }

        .content {
            margin-bottom: 20px;
        }

        .footer {
            margin-top: 20px;
        }

        .footer p {
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="path_to_logo.png" alt="Logo">
            <h1>PEMERINTAH KABUPATEN BANGKALAN</h1>
            <h2>DINAS PENDIDIKAN</h2>
            <h2>UPTD SMP NEGERI 2 BANGKALAN</h2>
            <p>Jl. KH. Hasyim Asyari No. 20, Telp./ Fax. (031) 3059059</p>
            <p>Email: smpn_2bangkalan@yahoo.com | Web: www.uptdsmpn2bangkalan.sch.id</p>
        </div>
        <div class="content">
            <h3>PANITIA PENERIMAAN PESERTA DIDIK BARU (PPDB)</h3>
            <h4>TAHUN PELAJARAN 2021-2022</h4>
            <table>
                <tr>
                    <td>No. Pendaftaran</td>
                    <td>:</td>
                    <td>{{ $data['id'] }}</td>
                </tr>
                <tr>
                    <td>Nama Pengguna</td>
                    <td>:</td>
                    <td>{{ $data['nama_pengguna'] }}</td>
                </tr>
                <tr>
                    <td>NITKU</td>
                    <td>:</td>
                    <td>{{ $data['nitku'] }}</td>
                </tr>
                <tr>
                    <td>Nama Perusahaan</td>
                    <td>:</td>
                    <td>{{ $data['nama_perusahaan'] }}</td>
                </tr>
                <tr>
                    <td>Alamat Rumah</td>
                    <td>:</td>
                    <td>{{ $data['alamat_pengguna'] }}</td>
                </tr>
                <tr>
                    <td>No. HP/WA</td>
                    <td>:</td>
                    <td>{{ $data['telepon_pengguna'] }}</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>{{ $data['jabatan'] }}</td>
                <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td>{{ $data['email'] }}</td>
                </tr>
            </table>
            <p>SELAMAT ANDA DITERIMA SEBAGAI PESERTA DIDIK BARU DI UPTD SMP NEGERI 2 BANGKALAN DARI JALUR AFIRMASI</p>
            <div class="footer">
                <h4>CATATAN PENTING:</h4>
                <p>1. TANDA BUKTI INI DICETAK UNTUK DAFTAR ULANG DAN MENDAPATKAN FORM BIODATA SISWA YANG WAJIB DI ISI
                    DAN MELAMPIRKAN Fc. KK DAN AKTE KELAHIRAN</p>
                <p>2. UNTUK PENGAMBILAN ISIAN FORM BIODATA SISWA DILAKSANAKAN HARI SENIN, 5 JULI 2021 SETELAH PENGUMUMAN
                    DARI JAM 10.00 S.D. 12.00 WIB.</p>
                <p>3. JADWAL PENGEMBALIAN FORM ISIAN BIODATA SISWA AKAN DIJADWAL SEBAGAI BERIKUT:</p>
                <p>HARI / TANGGAL : SELASA, 6 JULI 2021</p>
                <p>TEMPAT : RUANG 1</p>
                <p>PUKUL : 09.00-10.00 WIB</p>
                <p>4. BAGI SISWA YANG TIDAK MELAKUKAN DAFTAR ULANG DINYATAKAN MENGUNDURKAN DIRI</p>
            </div>
        </div>
    </div>
</body>

</html>
