<?php include("template/header.php");?>
<?php include("template/navbar.php");?>

<?php
  include 'connect.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">     
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li class="active">Icons</li>
      </ol>
    </div><!--/.row-->

  
    <div class="row" style="padding-top:20px;">
      <div class="col-lg-12">
      <div class="panel panel-default" >
        <div class="panel-body">
        <h3 align="center">DATA KAMAR</h3>
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
                <th style="text-align:center;">ID Kamar</th>
                <th style="text-align:center;">Jenis Kamar</th>
                <th style="text-align:center;">Wisma</th>
                <th style="text-align:center;">Edit</th>
                <th style="text-align:center;">Delete</th>
              </tr>
            </thead>
          <tbody>
           <?php
              $query = "select k.id_kamar, jk.nama_jenis, w.nama_wisma from kamar k, jenis_kamar jk, wisma w
              where k.id_wisma=w.id_wisma and k.id_jenis=jk.id_jenis";
              $stid = oci_parse($conn, $query);
              oci_execute($stid);
             // echo $query;

              while ($row = oci_fetch_array($stid))
              {?>
                <tr>
                <td><?php echo $row['ID_KAMAR'];?></td>
                <td><?php echo $row['NAMA_JENIS'];?></td>
                <td><?php echo $row['NAMA_WISMA'];?></td>
                
                <td>
                  <div>
                    <form method="POST" action="update-kamar.php">
                      <center>
                        <button type="submit" class="btn btn-primary">Edit</button>
                        <input type="hidden" name="update_kamar" value="<?php echo $row['ID_KAMAR'];?>"> </input>
                      </center>
                    </form>
                  </div>
                </td>
                <td>
                  <div>
                    <form method="GET" action="<?php $_PHP_SELF ?>">
                      <center>
                        <button type='submit' class="btn btn-primary" name='del_kamar' value="<?php echo $row['ID_KAMAR'];?>">Delete</button>
                      </center>
                    </form>
                  </div>
                </td>
                <?php
                }
                ?>
              </tbody>
          </table>

          <div class="pull-right">
            <br>
            <a href="tambah-kamar.php">  <button class="btn">TAMBAH BARU</button> </a>
          </div>

       </div>
       <div>
           <?php
              if( isset($_GET['del_kamar']))
              {
                $idkamar = $_GET['del_kamar'];
                echo '
                   <form method="POST" action="delete-kamar.php">
                    <div class="controls" style="display:none;">
                      <input class="form-control" type="text" name="id_kamar" value="'.$idkamar.'">
                    </div>
                    <div class="alert alert-dismissable">
                      <center><b> Melanjutkan Penghapusan ? </b> <br><br>
                      <button type="submit" style="width:70px"> Ya </button> &nbsp &nbsp &nbsp
                      <button type="button" data-dismiss="alert" submit style="width:70px"> Tidak </button>
                      </center>
                    </div>
                  </form>
                ';
              }
           ?>
         </div>
     </div>
   </div>
</div>
</div>
<?php include("template/footer.php");?>
