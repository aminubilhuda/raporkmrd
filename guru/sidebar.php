<div class="left side-menu">
  <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
    <i class="ion-close"></i>
  </button>

  <!-- LOGO -->
  <div class="topbar-left">
    <div class="text-center bg-logo">
      <a href="index.php" class="logo"><i class="mdi mdi-bowling text-success"></i> Guru/Wali</a>
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
            Dashboard
            <span class="badge badge-pill badge-primary float-right">
              <?php  
                                    echo $jumlahkelasampuh = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM mapel_kelas WHERE id_user='$_SESSION[id_user]'"));
                                ?>
            </span>
          </a>
        </li>

        <li class="menu-title">Components</li>

        <li class="has_sub">
          <a href="javascript:void(0);" class="waves-effect"><i class="fas fa-book-open"></i> <span> Penilaian
            </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
          <ul class="list-unstyled">
            <li><a href="?pages=tpu"><span class="badge badge-primary">1 </span> Tujuan Pembelajaran</a>
            </li>
            <li><a href="?pages=kelas-ku"><span class="badge badge-primary">2 </span> Penilaian Angka</a>
            </li>
          </ul>
        </li>

        <!-- Menu ESKTRA -->
        <?php if($jumlahpembina > 0){ ?>

        <li class="has_sub">
          <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-basketball"></i> <span>
              Ekstrakurikuler
            </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
          <ul class="list-unstyled">
            <?php
                            $eskul = mysqli_query($mysqli,"SELECT * FROM pembina_eskul 
                            JOIN eskul ON pembina_eskul.id_eskul = eskul.id_eskul
                            WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_user='$_SESSION[id_user]' ");
                            while($reskul = mysqli_fetch_array($eskul)){
                        ?>
            <li><a
                href="?pages=ekstra&orderID=<?php echo $reskul['id_eskul']?>"><?php echo $reskul['nama_eskul']; ?></a>
            </li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>

        <!-- BK -->
        <?php if ($user['id_user'] == $_SESSION['id_user'] && $user['moto'] == 1) { ?>
        <li>
          <a href="?pages=absensi-bk" class="waves-effect"><i class="far fa-calendar-alt"></i><span>
              Absensi BK
            </span></a>
        </li>
        <?php } ?>
        <?php
                    if ($pembinap5bk <> '') {?>
        <li>
          <a href="?pages=p5bk" class="waves-effect"><i class="far fa-folder"></i><span>
              P5BK
            </span></a>
        </li>
        <?php } ?>

        <?php
                    if ($jumlahwali <> '') {?>
        <li>
          <a href="?pages=anggota-kelas" class="waves-effect"><i class="far fa-user"></i><span>
              Anggota Kelas
            </span></a>
        </li>


        <li>
          <a href="?pages=rekap-presensi" class="waves-effect"><i class="far fa-calendar-alt"></i><span>
              Rekap Presensi
            </span></a>
        </li>

        <!-- <li>
          <a href="?pages=project-kelas" class="waves-effect"><i class="dripicons-briefcase"></i><span>
              Project Kelas
            </span></a>
        </li> -->

        <li class="has_sub">
          <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-table"></i>
            <span>Leger/Absen/Rapor
            </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
          <ul class="list-unstyled">
            <li><a href="?pages=lager-nilai-kelas">Leger Nilai & Absen</a></li>
            <?php if ($jumlahwali <> '') {?>
            <li><a href="?pages=catatan-rapor">Cetak Rapor</a></li>
            <li><a href="?pages=rapor-pkl">Cetak Rapor Prakerin</a></li>
            <?php } ?>
          </ul>
        </li>

        <li>
          <a href="?pages=buku-induk" class="waves-effect"><i class="mdi mdi-book-open-page-variant"></i><span>
              Buku Induk
            </span></a>
        </li>
        <?php } ?>

        <!-- Menu Prakerin -->
        <?php
                $jumlahprakerin = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM prakerin WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_user='$_SESSION[id_user]'"));
                if($jumlahprakerin > 0){
                ?>
        <li>
          <a href="?pages=prakerin" class="waves-effect"><i class="fas fa-building"></i><span>
              Prakerin
            </span></a>
        </li>
        <?php } ?>

        <!-- Menu Petugas Piket -->
        <?php
                    $jumlahtugas = mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM piket_harian WHERE id_harian='$id_harian' AND id_user='$_SESSION[id_user]'"));
                    if($jumlahtugas > 0){
                ?>
        <li>
          <a href="?pages=piket-harian" class="waves-effect"><i class="far fa-calendar-check"></i><span> Piket
              Harian
            </span></a>
        </li>
        <?php } ?>
      </ul>
    </div>
    <div class="clearfix"></div>
  </div> <!-- end sidebarinner -->
</div>