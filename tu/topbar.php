     <div class="topbar">

         <nav class="navbar-custom">

             <ul class="list-inline float-right mb-0">
                 <!-- language-->

                 <li class="list-inline-item dropdown notification-list">
                     <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown"
                         href="#" role="button" aria-haspopup="false" aria-expanded="false">
                         <img src="../assets/images/users/<?php echo ($user['kelamin']==1 ? "man.svg" : "woman.svg") ?>"
                             class="rounded-circle"> <?php echo $user['nama'] ?>
                     </a>
                     <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                         <!-- item-->
                         <div class="dropdown-item noti-title">
                             <h5>Welcome</h5>
                         </div>
                         <!-- <a class="dropdown-item" href="#"><i class="mdi mdi-account-circle m-r-5 text-muted"></i>
                             Profile</a>
                         <a class="dropdown-item" href="#"><i class="mdi mdi-wallet m-r-5 text-muted"></i> My
                             Wallet</a>
                         <a class="dropdown-item" href="#"><span class="badge badge-success float-right">5</span><i
                                 class="mdi mdi-settings m-r-5 text-muted"></i> Settings</a>
                         <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline m-r-5 text-muted"></i>
                             Lock screen</a> -->
                         <div class="dropdown-divider"></div>
                         <a class="dropdown-item" href="logout.php"><i class="mdi mdi-logout m-r-5 text-muted"></i>
                             Logout</a>
                     </div>
                 </li>
             </ul>

             <ul class="list-inline menu-left mb-0">
                 <li class="float-left">
                     <button class="button-menu-mobile open-left waves-light waves-effect">
                         <i class="mdi mdi-menu"></i>
                     </button>
                 </li>
                 <li class="hide-phone pt-3 pl-3">
                     <form method="POST" class="form-inline">
                         <?php if(isset($sekolah['is_historical_view']) && $sekolah['is_historical_view']) { ?>
                             <span class="badge badge-warning mr-2 p-2">Mode Histori Aktif</span>
                         <?php } ?>
                         <select name="view_tahun" class="form-control form-control-sm mr-2" style="width: auto; border-radius: 4px;">
                             <?php
                             $tp_query = mysqli_query($mysqli, "SELECT * FROM tahun_pelajaran ORDER BY id_tahun_pelajaran DESC");
                             while($tp = mysqli_fetch_array($tp_query)) {
                                 $sel = ($sekolah['tahun'] == $tp['id_tahun_pelajaran']) ? 'selected' : '';
                                 echo "<option value='".$tp['id_tahun_pelajaran']."' $sel>".$tp['tahun_pelajaran']."</option>";
                             }
                             ?>
                         </select>
                         <select name="view_semester" class="form-control form-control-sm mr-2" style="width: auto; border-radius: 4px;">
                             <?php
                             $sm_query = mysqli_query($mysqli, "SELECT * FROM semester ORDER BY id_semester ASC");
                             while($sm = mysqli_fetch_array($sm_query)) {
                                 $sel = ($sekolah['semester'] == $sm['id_semester']) ? 'selected' : '';
                                 echo "<option value='".$sm['id_semester']."' $sel>".$sm['semester']."</option>";
                             }
                             ?>
                         </select>
                         <button type="submit" name="set_view_filter" class="btn btn-sm btn-info mr-1" title="Terapkan Filter"><i class="fas fa-filter"></i></button>
                         <?php if(isset($sekolah['is_historical_view']) && $sekolah['is_historical_view']) { ?>
                         <button type="submit" name="reset_view_filter" class="btn btn-sm btn-danger" title="Reset ke Data Aktif"><i class="fas fa-times"></i></button>
                         <?php } ?>
                     </form>
                 </li>
             </ul>

             <div class="clearfix"></div>
         </nav>
     </div>