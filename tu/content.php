<?php  
        $pages = isset($_GET['pages']) ? $_GET['pages'] : '';
       // Array untuk mapping halaman yang valid
      $valid_pages = [
          'profil' => 'sekolah.php',
          'pegawai' => 'pegawai.php',
          'kesiswaan' => 'kesiswaan.php',
          'rombel' => 'rombel.php',
          'mapel' => 'mapel.php',
          'ekstra' => 'ekstra.php',
          'prestasi-siswa' => 'prestasi-siswa.php',
          'mapel-siswa' => 'mapel-siswa.php',
          'anggota-kelas' => 'anggota-kelas.php',
          'mapel-kelas' => 'mapel-kelas.php',
          'ppra' => 'ppra.php',
          'pengingat' => 'pengingat.php',
          'laporan_wa' => 'laporan_wa.php',
          'pengaturan' => 'pengaturan.php',
          'mutasi-masuk' => 'mutasi-masuk.php',
          'mutasi-keluar' => 'mutasi-keluar.php',
          'lulusan' => 'lulusan.php',
          'nilai-akademik' => 'nilai-akademik.php',
          'voting-osis' => 'voting-osis.php',
          'detail-voting' => 'detail-voting.php',
          'rekrutmen' => 'rekrutmen.php',
          'detail-rekrutmen' => 'detail-rekrutmen.php',
          'assesmen-akhir' => 'assesmen-akhir.php',
          'kompetensi' => 'kompetensi-keahlian.php',
          'pemberitaan' => 'pemberitaan.php',
          'program-aplikasi' => 'program-aplikasi.php',
          'angket-survey' => 'angket-survey.php',
          'supervisi' => 'supervisi.php',
          'prakerin' => 'prakerin.php',
          'akademik' => 'akademik.php',
          'laporan-pendidikan' => 'laporan-pendidikan.php',
          'buku-induk' => 'buku-induk.php',
          'prestasi' => 'prestasi.php',
          'piket-harian' => 'piket-harian.php',
          'rekap-presensi' => 'rekap-presensi.php',
          'kesiswaan-upload' => 'kesiswaan-upload.php',
          'deskripsi-rapor' => 'deskripsi-rapor.php',
          'update' => 'update.php',
          'detail-project' => 'detail-project.php',
          'managemen-tema' => 'managemen-tema.php',
          'managemen-dimensi' => 'managemen-dimensi.php',
          'managemen-elemen' => 'managemen-elemen.php',
          'managemen-sub-elemen' => 'managemen-sub-elemen.php',
          'penilaian-profil-pancasila' => 'penilaian-profil-pancasila.php',
          'p5bk' => 'p5bk.php'
      ];

      // Jika pages kosong atau tidak ada dalam valid_pages, tampilkan dashboard
      if (empty($pages) || !array_key_exists($pages, $valid_pages)) {
          include "dashboard.php";
      } else {
          // Include file sesuai dengan pages yang diminta
          include $valid_pages[$pages];
      }

        ?>