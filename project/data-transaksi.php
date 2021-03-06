<?php include("template/header.php");?>
<?php include("template/navbar.php");?>

<?php
  include 'coba.php';
?>

<div class="container">
  <div class="row" style="padding-top:20px;">
    <div class="panel panel-default" style="background-color:#eee">
      <div class="panel-body">
        <h3 align="center">DATA TRANSAKSI</h3>
        <?php
          if(isset($_GET['status']) && $_GET['status']=="sukses")
          {
          echo "
            <div class='alert alert-dismissable alert-success'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <center><b>Tabel Berhasil Diupdate!</b></center>
            </div>";
          }
          else if(isset($_GET['status']) && $_GET['status']=="gagal"){
            echo "<div class='alert alert-dismissable alert-danger'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <center><b>Tabel Gagal Diupdate!</b></center>z
            </div>";
          }

        ?>
          <table class="table table-hover table-bordered table-striped">
            <thead>
              <tr>
                <th style="text-align:center;">Nama Tamu</th>
                <th style="text-align:center;">ID Kamar</th>
                <th style="text-align:center;">Jenis Kamar</th>
                <th style="text-align:center;">Wisma</th>
                <th style="text-align:center;">Tanggal Transaksi</th>
                <th style="text-align:center;">Tanggal Check In</th>
                <th style="text-align:center;">Tanggal Check Out</th>
                <th style="text-align:center;">Tanggal Bayar</th>
                <th style="text-align:center;">Denda</th>
                <th style="text-align:center;">Edit</th>
                <th style="text-align:center;">Delete</th>
              </tr>
            </thead>
          <tbody>
           <?php
              $query = "select ts.*, kw.nama_wisma, kw.nama_jenis, m.id_kamar, t.nama_tamu
                        from transaksi_sewakamar ts, menyewa m, tamu t,(
                            select w.nama_wisma, k.id_kamar, jk.nama_jenis
                            from kamar k, wisma w, jenis_kamar jk
                            where k.id_wisma=w.id_wisma and jk.id_jenis= k.id_jenis) kw
                        where ts.id_transaksi= m.id_transaksi and m.id_kamar=kw.id_kamar and t.id_tamu= ts.id_tamu";
              $stid = oci_parse($conn, $query);
              oci_execute($stid);

              while ($row = oci_fetch_array($stid))
              {?>
                <tr>
                <td><?php echo $row['NAMA_TAMU'];?></td>
                <td><?php echo $row['ID_KAMAR'];?></td>
                <td><?php echo $row['NAMA_JENIS'];?></td>
                <td><?php echo $row['NAMA_WISMA'];?></td>
                <td><?php echo $row['TGL_TRANSAKSI'];?></td>
                <td><?php echo $row['TGL_CHECKIN'];?></td>
                <td><?php echo $row['TGL_CHECKOUT'];?></td>
                <td><?php echo $row['TGL_BAYAR'];?></td>
                <td><?php echo $row['DENDA'];?></td>
                
                <td>
                  <div>
                    <form method="POST" action="#">
                      <center>
                        <button type="submit" class="btn btn-primary">Edit</button>
                        <input type="hidden" name="id_transaksi" value="<?php echo $row['ID_TRANSAKSI'];?>"> </input>
                      </center>
                    </form>
                  </div>
                </td>
                <td>
                  <div>
                    <form method="GET" action="<?php $_PHP_SELF ?>">
                      <center>
                        <button type='submit' class="btn btn-primary" name='del_transaksi' value="<?php echo $row['ID_TRANSAKSI'];?>">Delete</button>
                      </center>
                    </form>
                  </div>
                </td>
                <?php
                }
                ?>
              </tbody>
          </table>

          <div>
            <a href="#">  <button class="btn">KEMBALI</button>
          </a> </div>

          <div>
           <?php
              if( isset($_GET['del_transaksi']))
              {
                $idkam = $_GET['del_transaksi'];
               /* echo '
                   <form method="POST" action="delkamar.php">
                    <div class="controls" style="display:none;">
                      <input class="form-control" type="text" name="id_kam" value="'.$idkam.'">
                    </div>
                    <div class="alert alert-dismissable">
                      <center><b> Melanjutkan Penghapusan ? </b> <br><br>
                      <button type="submit" style="width:70px"> Ya </button> &nbsp &nbsp &nbsp
                      <button type="button" data-dismiss="alert" submit style="width:70px"> Tidak </button>
                      </center>
                    </div>
                  </form>
                ';*/
              }
           ?>
         </div>
       </div>
     </div>
   </div>
</div>

<?php include("template/footer.php");?>
