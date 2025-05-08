<div class="left side-menu">
  <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
    <i class="ion-close"></i>
  </button>

  <!-- LOGO -->
  <div class="topbar-left">
    <div class="text-center bg-logo">
      <a href="index.php" class="logo"><i class="mdi mdi-bowling text-success"></i> Tata Usaha</a>
      <!-- <a href="index.html" class="logo"><img src="assets/images/logo.png" height="24" alt="logo"></a> -->
    </div>
  </div>
  <div class="sidebar-user">
    <img src="../assets/dist/img/<?php echo $sekolah['logo'] ?>" alt="user" class="rounded-circle img-thumbnail mb-1">
    <h6 class=""><?php echo $user['nama'] ?> </h6>
    <p class=" online-icon text-dark"><i class="mdi mdi-record text-success"></i>online</p>
    <ul class="list-unstyled list-inline mb-0 mt-2">
      <li class="list-inline-item">
        <a href="#" class="" data-toggle="tooltip" data-placement="top" title="Profile"><i
            class="dripicons-user text-purple"></i></a>
      </li>
      <li class="list-inline-item">
        <a href="?pages=pengaturan" class="" data-toggle="tooltip" data-placement="top" title="Settings"><i
            class="dripicons-gear text-dark"></i></a>
      </li>
      <li class="list-inline-item">
        <a href="logout.php" class="" data-toggle="tooltip" data-placement="top" title="Log out"><i
            class="dripicons-power text-danger"></i></a>
      </li>
    </ul>
  </div>

  <div class="sidebar-inner slimscrollleft">

    <div id="sidebar-menu">
      <ul>
        <li class="menu-title">Main</li>

        <li>
          <a href="index.php" class="waves-effect">
            <i class="dripicons-device-desktop"></i>
            <span> Dashboard <span class="badge badge-pill badge-primary float-right">11</span></span>
          </a>
        </li>

        <li class="menu-title">Components</li>

        <li class="has_sub">
          <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-home"></i> <span> Data
              Sekolah </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
          <ul class="list-unstyled">
            <li><a href="?pages=profil">Profile Sekolah</a></li>
            <li><a href="?pages=pegawai">Pegawai</a></li>
            <li><a href="?pages=kesiswaan">Data Siswa</a></li>
            <li><a href="?pages=mapel">Mata Pelajaran</a></li>
            <li><a href="?pages=ekstra">EkstraKurikuler</a></li>
            <li><a href="?pages=kompetensi">Kompetensi Keahlian</a></li>
            <li><a href="?pages=prakerin">Prakerin</a></li>
            <li><a href="?pages=deskripsi-rapor">Deskripsi Rapor</a></li>
          </ul>
        </li>
        <li class="has_sub">
          <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-monitor"></i> <span> Kelas
            </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
          <ul class="list-unstyled">
            <li><a href="?pages=rombel">Kelas</a></li>
            <li><a href="?pages=anggota-kelas">Anggota Kelas</a></li>
            <li><a href="?pages=mapel-kelas">Mapel Kelas</a></li>
            <li><a href="?pages=mapel-siswa">Mapel Pilihan Siswa</a></li>
          </ul>
        </li>
        <li>
          <a href="?pages=laporan-pendidikan" class="waves-effect"><i class="dripicons-print"></i><span>
              Laporan
              Pendidikan
            </span></a>
        </li>
        <li>
          <a href="?pages=p5bk" class="waves-effect"><i class="dripicons-folder"></i>
            <span>P5BK</span>
          </a>
        </li>
        <li>
          <a href="?pages=piket-harian" class="waves-effect"><i class="dripicons-calendar"></i><span>
              Piket Harian
            </span></a>
        </li>

        <li class="has_sub">
          <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-whatsapp"></i> <span>Set
              WhatsApp </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
          <ul class="list-unstyled">
            <li><a href="?pages=pengingat">Pesan Jadwal</a></li>
            <li><a href="#">Pesan Broadcast</a></li>
            <li><a href="?pages=laporan_wa">Laporan Kirim</a></li>

          </ul>
        </li>
        <li class="has_sub">
          <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-whatsapp"></i> <span>Managemen P5BK
            </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
          <ul class="list-unstyled">
            <li><a href="?pages=managemen-tema">Managemen Tema</a></li>
            <li><a href="?pages=managemen-dimensi">Managemen Dimensi</a></li>
            <li><a href="?pages=managemen-elemen">Managemen Element</a></li>
            <li><a href="?pages=managemen-sub-elemen">Managemen Sub Elemen</a></li>
          </ul>
        </li>
        </li>
        <li>
          <a href="?pages=pengaturan" class="waves-effect"><i class="mdi mdi-settings"></i><span> Pengaturan
            </span></a>
        </li>
        <li>
          <a href="?pages=update" class="waves-effect"><i class="mdi mdi-settings"></i><span> Update Aplikasi
            </span></a>
        </li>
      </ul>
    </div>
    <div class="clearfix"></div>
  </div> <!-- end sidebarinner -->
</div>