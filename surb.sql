-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Nov 2021 pada 14.37
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `surb`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_disposisi`
--

CREATE TABLE `tbl_disposisi` (
  `id_disposisi` int(10) NOT NULL,
  `tgl_diterima` date NOT NULL,
  `nama_penerima` varchar(250) NOT NULL,
  `sifat` varchar(30) NOT NULL,
  `id_sm` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_disposisi`
--

INSERT INTO `tbl_disposisi` (`id_disposisi`, `tgl_diterima`, `nama_penerima`, `sifat`, `id_sm`) VALUES
(0, '2021-11-21', 'Siapa aja', 'Penting', '27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_instansi`
--

CREATE TABLE `tbl_instansi` (
  `id_instansi` tinyint(1) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `supervisor` varchar(50) NOT NULL,
  `website` varchar(50) NOT NULL,
  `logo` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_instansi`
--

INSERT INTO `tbl_instansi` (`id_instansi`, `nama`, `alamat`, `supervisor`, `website`, `logo`) VALUES
(1, 'PT. Dagsap Endura Eatore', 'Kawasan Industri Sentul Jl. Cahaya Raya Kav. H-3 Kabupaten Bogor', 'Della Fenlies', 'https://www.dagsap.co.id/', '1.JPG');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_ska`
--

CREATE TABLE `tbl_ska` (
  `id_ska` int(5) NOT NULL,
  `no_ska` varchar(50) NOT NULL,
  `nama_ska` varchar(100) NOT NULL,
  `nip_ska` varchar(50) NOT NULL,
  `dept_ska` varchar(50) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `tgl_buat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_ska`
--

INSERT INTO `tbl_ska` (`id_ska`, `no_ska`, `nama_ska`, `nip_ska`, `dept_ska`, `tgl_masuk`, `tgl_buat`) VALUES
(75, '0120/HRD-DEE/IV/2021', ' Laras Ayu', ' 1145.0418', 'Produksi', '2018-04-24', '2021-04-19'),
(76, '0105/HRD-DEE/IV/2021', ' Vairul Dwi Nopiasari', '1050.0817', 'Produksi', '2017-08-14', '2021-04-06'),
(77, '0104/HRD-DEE/IV/2021', ' Nisa Rahma Aulia', ' 0943.0816', 'Produksi', '2017-08-10', '2021-04-05'),
(78, ' 0097/HRD-DEE/III/2021', 'Dewi Masitoh', ' 1523.0221', 'HRD & GA', '2021-02-02', '2021-03-25'),
(79, ' 0096/HRD-DEE/III/2021', ' Bogi Sugih Saputra', ' 1083.1117', 'Sales & Marketing', '2017-11-17', '2021-03-25'),
(80, ' 0121/HRD-DEE/IV/2021', 'Anita Nuerjanah', ' 1137.0418', 'Produksi', '2018-04-09', '2021-04-19'),
(81, '0136/HRD-DEE/IV/2021', ' Dodik Tri Purwanto', ' 0531.0113', 'Produksi', '2013-01-14', '2021-04-15'),
(82, '0141/HRD-DEE/IV/2021', 'Adar Rusmana', '1285.0419', 'Supervisor Tax', '2019-04-17', '2021-04-30'),
(84, '0231/HRD-DEE/V/2021', 'Syarifudin K', '0373.0811', 'Tax', '2011-08-18', '2021-05-19'),
(85, '0252/HRD-DEE/VI/2021', 'Sella Oktaviani', '1143.0418', 'Sales & Marketing', '2018-04-18', '2021-06-11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_surat_keluar`
--

CREATE TABLE `tbl_surat_keluar` (
  `id_sk` int(10) NOT NULL,
  `no_sk` varchar(50) NOT NULL,
  `isi_sk` mediumtext NOT NULL,
  `kepada_sk` varchar(50) NOT NULL,
  `tgl_surat` date NOT NULL,
  `file` varchar(250) NOT NULL,
  `pic_sk` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_surat_keluar`
--

INSERT INTO `tbl_surat_keluar` (`id_sk`, `no_sk`, `isi_sk`, `kepada_sk`, `tgl_surat`, `file`, `pic_sk`) VALUES
(24, '0107/HRD-DEE/III/2018', 'Ditugaskan untuk mengambil kursi ( student fold chair ) di SFC Rental, sebanyak 40 Unit Pada Hari Selasa, 25 Maret 2021 Jam 14.00 WIB', 'Sudirman', '2021-03-23', '8041-0107ST-2021.pdf', 'Nio Dani Anto'),
(25, '0031/HRD-DEE/I/2021', 'Ditugaskan untuk mengikuti Pelatihan Operator Pesawat Angkat/Angkut (Forklift)', 'Andri Nasrudin dan Pirman Sukirman', '2021-01-23', '140-0031ST-2021.pdf', 'Otty Adiani Ratri'),
(26, '0304/HRD-DEE/XII/2019', 'Ditugaskan untuk mengikuti Psikotest yang akan di lakukan di Existensi Biro Psikologi, yang diselenggarakan pada 15 Juni 2021 Jam 08.00 WIB', 'Sigit Priyanto', '2021-06-13', '1324-0304ST-2021.pdf', 'Sugandi'),
(27, '0543/HRD-DEE/X/2021', 'karyawan di PT Dagsap Endura Eatore sejak tanggal 05 Februari 2009 dan sampai saat ini masih aktif', ' Angga Lesmana', '2021-09-05', '695-0543SK.pdf', 'Tarno'),
(28, '0545/HRD-DEE/X/2021', 'Karyawan di PT Dagsap Endura Eatore sejak tanggal 17 November 2019 sampai dengan tanggal 17 Oktober 2021', 'Nurbaeti', '2021-10-17', '2633-0545SK.pdf', 'Nio Dani Anto'),
(29, '0522/HRD-DEE/IX/2021', 'Ditugaskan untuk menghadiri undangan dari Pemerintahan Kabupaten Bogor Dinas Penanaman Modal Dan Pelayanan Terpadu Satu Pintu, yang diselenggarakan pada 08 September 2021 Jam 08.00 WIB', 'Dewi Pramesti Tri Utami', '2021-09-06', '9063-0522ST.pdf', 'Otty Adiani Ratri'),
(30, '0010/HRD-DEE/I/2021', 'Karyawan di PT Dagsap Endura Eatore sejak tanggal 27 September 2011 sampai dengan tanggal 02 April 2012', ' Indah Dwi Utami', '2021-01-15', '9896-0010SK.pdf', 'Sugandi'),
(31, '0013/HRD-DEE/I/2021', 'karyawan di PT Dagsap Endura Eatore sejak tanggal 01 Mei 2006 dan sampai saat ini masih aktif', 'Sumedi Dasun', '2021-01-15', '4705-0013SK.pdf', 'Deni Suwanda'),
(32, '0040/HRD-DEE/I/2021', 'Karyawan di PT Dagsap Endura Eatore sejak tanggal 09 Juni 2014 sampai dengan tanggal 18 Juli 2017', 'Siti Muniroh', '2021-01-30', '7103-0040SK-2021.pdf', 'Sugandi'),
(33, '0089/HRD-DEE/III/2021', 'karyawan di PT Dagsap Endura Eatore sejak tanggal 10 Juli 2018 dan sampai saat ini masih aktif. ', 'Andini Adelia Putri', '2021-03-17', '8677-0089SK.pdf', 'Tarno');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_surat_masuk`
--

CREATE TABLE `tbl_surat_masuk` (
  `id_sm` int(10) NOT NULL,
  `no_sm` varchar(50) NOT NULL,
  `asal_sm` varchar(250) NOT NULL,
  `isi_sm` mediumtext NOT NULL,
  `perihal_sm` varchar(30) NOT NULL,
  `tgl_surat` date NOT NULL,
  `file` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_surat_masuk`
--

INSERT INTO `tbl_surat_masuk` (`id_sm`, `no_sm`, `asal_sm`, `isi_sm`, `perihal_sm`, `tgl_surat`, `file`) VALUES
(27, '21.480/X/DP-K', 'Asosiasi Pengusaha Indonesia (Apindo)', 'Sertifikat kompetensi tenaga listrik peserta akan berakhir pada bulan nopember 2021, dan dapat melakukan perpanjangan sertifikat melalui APINDO Kabupaten bogor', 'Perpanjangan Sertifikat Kompet', '2020-10-07', '6222-ppskktk.pdf'),
(28, '/PHBI-MN/10/09/21', 'Masjid Jamie Al-Ikhlas', 'Akan dilaksanakannya peringatan Maulid Nabi Muhammad SAW 1443H di Masjid Jamie Al-Ikhlas, maka dari itu panitia memohon bantuan dana ', 'Permohonan Bantuan Dana', '2021-09-10', '4866-masjidjamiealikhlas.jpeg'),
(29, '5/PPMH/IX/2021', 'Pondok Pesantren Miftahul Huda', 'Akan dilakukan pembangunan majelas talim miftahul huda, maka dari itu panitia memohon bantuan dana ', 'Permohonan Bantuan Dana', '0000-00-00', '9477-miftahulhuda.jpeg'),
(30, '21.464/VII/DPK-K', 'Asosiasi Pengusaha Indonesia (Apindo)', 'DPK APINDO Kab Bogor bekerjasama dengan Dinas Kesehatan Kabupaten Bogor akan mengadakan vaksinasi massal bagi pekerja di perusahaan anggota APINDO Kab Bogor, Pelaksanaan dilakukan selama 2 hari yaitu 31 Juli 2021 dan 1 Agustus 2021', 'Pelaksanaan Vaksinasi Massal', '2021-07-14', '4031-apindo-vaksinasimassal.jpeg'),
(32, '121212', 'ASASA', 'ASADADSD', 'SDSDSDSDSD', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` tinyint(2) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `username`, `password`) VALUES
(1, 'admin', 'c4ca4238a0b923820dcc509a6f75849b');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_disposisi`
--
ALTER TABLE `tbl_disposisi`
  ADD PRIMARY KEY (`id_disposisi`);

--
-- Indeks untuk tabel `tbl_instansi`
--
ALTER TABLE `tbl_instansi`
  ADD PRIMARY KEY (`id_instansi`);

--
-- Indeks untuk tabel `tbl_ska`
--
ALTER TABLE `tbl_ska`
  ADD PRIMARY KEY (`id_ska`);

--
-- Indeks untuk tabel `tbl_surat_keluar`
--
ALTER TABLE `tbl_surat_keluar`
  ADD PRIMARY KEY (`id_sk`);

--
-- Indeks untuk tabel `tbl_surat_masuk`
--
ALTER TABLE `tbl_surat_masuk`
  ADD PRIMARY KEY (`id_sm`);

--
-- Indeks untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_ska`
--
ALTER TABLE `tbl_ska`
  MODIFY `id_ska` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT untuk tabel `tbl_surat_keluar`
--
ALTER TABLE `tbl_surat_keluar`
  MODIFY `id_sk` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `tbl_surat_masuk`
--
ALTER TABLE `tbl_surat_masuk`
  MODIFY `id_sm` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
