<?php if(empty($_GET['filter'])){ ?>

<section class="content-header">
    <h1>
        Daftar Project Kelas Ku
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card border-danger">
                    <div class="card-header bg-danger">
                        <h3 class="card-title text-white">Daftar Project Kelas Ku</h3>
                        <a href="" data-toggle="modal" data-target="#myModal" class="btn btn-primary">Tambah
                            Data</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tema</th>
                                        <th>Judul</th>
                                        <th>Deskripsi Singkat</th>
                                        <th style="width:25%;">Mapel Terintegrasi</th>
                                        <th style="width:8%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                    $nomor=1;
                                    $kelas = mysqli_query($mysqli,"SELECT * FROM proyek_kelas 
                                    JOIN proyek_tema ON proyek_kelas.id_tema = proyek_tema.id_tema
                                    WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' ORDER BY id_proyek_kelas ASC");
                                    while($rkelas = mysqli_fetch_array($kelas)){
                                    ?>
                                    <tr>
                                        <td><?php echo $nomor++ ?></td>
                                        <td><?php echo $rkelas['tema'] ?></td>
                                        <td><?php echo $rkelas['judul_proyek'] ?></td>
                                        <td><?php echo $rkelas['deskripsi_singkat'] ?></td>
                                        <td>
                                            <ol>
                                                <?php
                                                $mapel = mysqli_query($mysqli,"SELECT * FROM mapel_proyek 
                                                JOIN mapel ON mapel_proyek.id_mapel = mapel.id_mapel
                                                WHERE id_proyek_kelas='$rkelas[id_proyek_kelas]' ORDER BY urut ASC");
                                                while($rmapel = mysqli_fetch_array($mapel)){
                                                    echo "<li>$rmapel[nama_mapel]</li>";
                                                }
                                                ?>
                                            </ol>
                                        </td>
                                        <td>
                                            <a href="?pages=<?php echo 'detail-project' ?>&orderID=<?php echo $rkelas['id_proyek_kelas'] ?>"
                                                class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="?pages=<?php echo $_GET['pages'] ?>&filter=<?php echo 'hapus' ?>&orderID=<?php echo $rkelas['id_proyek_kelas'] ?>"
                                                class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php }elseif($_GET['filter']=='hapus'){ 
        $hapusproyek = mysqli_query($mysqli,"DELETE FROM proyek_kelas WHERE id_proyek_kelas='$_GET[orderID]'");
        $hapussubelemenproyek = mysqli_query($mysqli,"DELETE FROM proyek_subelemen WHERE id_proyek_kelas='$_GET[orderID]'");
        $hapusmapelproyek = mysqli_query($mysqli,"DELETE FROM mapel_proyek WHERE id_proyek_kelas='$_GET[orderID]'");
        $hapusnilaiproyek = mysqli_query($mysqli,"DELETE FROM proyek_kelas WHERE proyek='$_GET[orderID]'");
        
        ?><script>
alert('Berhasil');
window.location.href = "?pages=<?php echo $_GET['pages']?>";
</script><?php
        ?>
<?php } ?>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h4 class="modal-title">Form Tambah Project Kelas</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST">

                    <input type="hidden" name="kode" value="<?php echo $kode?>">

                    <div class="form-group">
                        <label id="id_tema">Pilih Tema Project </label><br>
                        <select name="id_tema" class="form-control select2" style="width:100%;">
                            <option value="">Pilih Tema</option>
                            <?php
                              $tema = mysqli_query($mysqli,"SELECT * FROM proyek_tema ORDER BY id_tema ASC");
                              while($rtema = mysqli_fetch_array($tema)){
                              ?>
                            <option value="<?php echo $rtema['id_tema']?>"><?php echo $rtema['tema']?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Judul Project</label>
                        <input type="text" name="judul" class="form-control" required="" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label>Deskripsi SIngkat Project</label>
                        <textarea name="deskripsi_singkat" class="form-control" required="" rows="5"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Mata Pelajaran Terintegrasi</label> <br>
                        <?php
                          $mapelkelas = mysqli_query($mysqli,"SELECT * FROM mapel_kelas 
                          JOIN mapel ON mapel_kelas.id_mapel = mapel.id_mapel
                          WHERE tahun='$sekolah[tahun]' AND semester='$sekolah[semester]' AND id_kelas='$datakelas[id_kelas]' ORDER BY urut ASC");
                          while($rmapelkelas = mysqli_fetch_array($mapelkelas)){
                          ?>
                        <input id="<?php echo $rmapelkelas['id_mapel_kelas']?>" type="checkbox" name="mapel[]"
                            value="<?php echo $rmapelkelas['id_mapel']?>">
                        <label
                            for="<?php echo $rmapelkelas['id_mapel_kelas']?>"><?php echo $rmapelkelas['nama_mapel']?></label>
                        <br>
                        <?php } ?>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="updateproject" class="btn btn-success">Update Data</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
            if(isset($_POST['updateproject'])){
                $kode = $_POST['kode'];
                $id_tema = $_POST['id_tema'];
                $judul = $_POST['judul'];
                $deskripsi_singkat = $_POST['deskripsi_singkat'];
                $mapel = $_POST['mapel'];
                
               
                $simpan = mysqli_query($mysqli,"INSERT INTO proyek_kelas SET kode='$kode', tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_kelas='$datakelas[id_kelas]', id_tema='$id_tema', judul_proyek='$judul', deskripsi_singkat='$deskripsi_singkat'");
                if($simpan){
                    $dataproyek = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM proyek_kelas WHERE kode='$kode'"));
                    $id_proyek_kelas = $dataproyek['id_proyek_kelas'];
                    $jumlahmapel = count($mapel);
                    
                    for ($i=0; $i <$jumlahmapel ; $i++) { 
                    	mysqli_query($mysqli,"INSERT INTO mapel_proyek SET id_proyek_kelas='$id_proyek_kelas', tahun='$sekolah[tahun]', semester='$sekolah[semester]', id_kelas='$datakelas[id_kelas]', id_mapel='$mapel[$i]'");
                    }
                    
                    
                    ?><script>
alert('Berhasil');
window.location.href = "?pages=<?php echo $_GET['pages']?>";
</script>
<?php
                }
            }
            ?>