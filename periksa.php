<?php
include_once("koneksi.php");
session_start();

if (!isset($_SESSION['user_id'])) {
  $isLoggedIn = false;
} else {
  $isLoggedIn = true;
}

if (!isset($_SESSION['user_id'])) {
header("Location: login.php"); 
exit();
}

if (isset($_GET['action']) && $_GET['action'] == "logout") {
  // Lakukan proses logout
  unset($_SESSION['user_id']);
  header("Location: index.php");
  exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, 
    initial-scale=1.0">
    
    <title>Periksa</title>   <!--Judul Halaman-->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
</head>

<body>
    <nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">
          Sistem Informasi Poliklinik
        </a>
        <button class="navbar-toggler"
        type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false"
        aria-label="Toggle navigation">
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="index.php">
                Home
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
                Data Master
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="dokter.php">
                    Dokter
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="pasien.php">
                    Pasien
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="obat.php">Obat</a>
                            </li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" 
              href="periksa.php">
                Periksa
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" 
              href="detail_periksa.php">
                Detail
              </a>
            </li>
          </ul>
        </div>
        <div class="navbar-nav ml-auto">
                <?php
                if ($isLoggedIn) {
                    // Tampilkan opsi "Logout" jika pengguna sudah login
                    echo '<a class="nav-link" href="?action=logout">Logout</a>';
                } else {
                    // Tampilkan opsi "Register" dan "Login" jika pengguna belum login
                    echo '<a class="nav-link" href="register.php">Register</a>';
                    echo '<a class="nav-link" href="login.php">Login</a>';
                }
                ?>
        </div>
      </div>
    </nav>

<div class="container">
    <form class="form row" method="POST" action="periksa.php" name="myForm" onsubmit="return(validate());">

            
        <?php
        $obatan = '';
        $catatan = '';
        $biaya_periksa = '';
        if (isset($_GET['id'])) {
        $ambil = mysqli_query($mysqli, 
        "SELECT * FROM periksa 
        WHERE id='" . $_GET['id'] . "'");
        while ($row = mysqli_fetch_array($ambil)) {
          $obatan = $row['obatan'];
          $catatan = $row['catatan'];
          $biaya_periksa = $row['biaya_periksa'];
            
          }
        ?>
          <input type="hidden" name="id" value="<?php echo
              $_GET['id'] ?>">
          <?php
        }
        ?>

        <div class="form-group mx-sm-3 mb-2">
        <label for="inputPasien" class="sr-only">Pasien</label>
        <select class="form-control" name="id_pasien">
            <?php
            $selected = '';
            $pasien = mysqli_query($mysqli, "SELECT * FROM pasien");
            while ($data = mysqli_fetch_array($pasien)) {
                if ($data['id'] == $id_pasien) {
                    $selected = 'selected="selected"';
                } else {
                    $selected = '';
                }
            ?>
                <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama'] ?></option>
            <?php
            }
            ?>
        </select>
        </div>

        <div class="form-group mx-sm-3 mb-2">
        <label for="inputDokter" class="sr-only">Dokter</label>
        <select class="form-control" name="id_dokter">
        <?php
        $selected = '';
        $dokter = mysqli_query($mysqli, "SELECT * FROM dokter");
        while ($data = mysqli_fetch_array($dokter)) {
            if ($data['id'] == $id_dokter) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
        ?>
            <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama'] ?></option>
        <?php
        }
        ?>
        </select>
        </div>

       
        <div class="form-group mx-sm-3 mb-2">
            <label for="inputTanggalAwal" class="form-label">
                Tanggal Periksa
            </label>
            <input type="datetime-local" class="form-control" name="id_periksa" id="inputTanggalPeriksa" placeholder="Tanggal Periksa" value="<?php echo $id_periksa ?>">
        </div>

        <div class="form-group mx-sm-3 mb-2">
            <label for="obatan" class="form-label">
                  Obat
            </label>
            <input type="text" class="form-control" name="obatan" id="inputObat" placeholder="Obatan" value="<?php echo $obatan ?>">
        </div>

        <div class="form-group mx-sm-3 mb-2">
            <label for="catatan" class="form-label">
                  Catatan
            </label>
            <input type="text" class="form-control" name="catatan" id="inputCatatan" placeholder="Catatan" value="<?php echo $catatan ?>">
        </div>

        <div class="form-group mx-sm-3 mb-2">
            <label for="biaya_periksa" class="form-label">
                  Biaya Periksa
            </label>
            <input type="int" class="form-control" name="biaya_periksa" id="inputBiaya_Periksa" placeholder="Biaya Periksa" value="<?php echo $biaya_periksa ?>">
        </div>

        <div class="col">
            <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
        </div>

        
    </form>


   

        <!-- Table-->
        <table class="table table-hover">
                    <!--thead atau baris judul-->
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Pasien</th>
                            <th scope="col">Nama Dokter</th>
                            <th scope="col">Tanggal Periksa</th>
                            <th scope="col">Obatan</th>
                            <th scope="col">Catatan</th>
                            <th scope="col">Biaya Periksa</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <!--tbody berisi isi tabel sesuai dengan judul atau head-->
                    <tbody>
                    <?php
                        $result = mysqli_query($mysqli, "SELECT pr.*,d.nama as 'id_dokter', p.nama as 'id_pasien' FROM periksa pr LEFT JOIN dokter d ON (pr.id_dokter=d.id) LEFT JOIN pasien p ON (pr.id_pasien=p.id) ORDER BY pr.id_periksa DESC");
                        $no = 1;
                        while ($data = mysqli_fetch_array($result)) {
                        ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $data['id_pasien'] ?></td>
                                <td><?php echo $data['id_dokter'] ?></td>
                                <td><?php echo $data['id_periksa'] ?></td>
                                <td><?php echo $data['obatan'] ?></td>
                                <td><?php echo $data['catatan'] ?></td>
                                <td><?php echo $data['biaya_periksa'] ?></td>
                                <td>
                                    <a class="btn btn-success rounded-pill px-3" 
                                    href="periksa.php?id=<?php echo $data['id'] ?>">
                                    Ubah</a>
                                    <a class="btn btn-danger rounded-pill px-3" 
                                    href="periksa.php?id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
                                </td>
                            </tr>
                      <?php
                      }
                    ?>
                    </tbody>
                </table>
        
        <?php
                if (isset($_POST['simpan'])) {
                    if (isset($_POST['id'])) {
                      $ubah = mysqli_query($mysqli, "UPDATE periksa SET 
                                                        id_pasien = '" . $_POST['id_pasien'] . "',
                                                        id_dokter = '" . $_POST['id_dokter'] . "',
                                                        id_periksa = '" . $_POST['id_periksa'] . "',
                                                        obatan = '" . $_POST['obatan'] . "',
                                                        catatan = '" . $_POST['catatan'] . "',
                                                        biaya_periksa = '" . $_POST['biaya_periksa'] . "'
                                                        WHERE
                                                        id = '" . $_POST['id'] . "'");
                    } else {
                      $nama_pasien = $_POST['id_pasien'];
                      $nama_dokter = $_POST['id_dokter'];
                      $tanggal_periksa = $_POST['id_periksa'];
                      $obatan = $_POST['obatan'];
                      $catatan = $_POST['catatan'];
                      $biaya_periksa = $_POST['biaya_periksa'];
                      $tambah = mysqli_query($mysqli, "INSERT INTO periksa(id_pasien, id_dokter, id_periksa, obatan, catatan, biaya_periksa) VALUES('$nama_pasien', '$nama_dokter', '$tanggal_periksa', '$obatan', '$catatan', '$biaya_periksa')");
                    }

                    echo "<script> 
                            document.location='periksa.php';
                            </script>";
                }

                if (isset($_GET['aksi'])) {
                    if ($_GET['aksi'] == 'hapus') {
                        $hapus = mysqli_query($mysqli, "DELETE FROM periksa WHERE id = '" . $_GET['id'] . "'");
                    } else if ($_GET['aksi'] == 'ubah_status') {
                        $ubah_status = mysqli_query($mysqli, "UPDATE periksa SET 
                                                        status = '" . $_GET['status'] . "' 
                                                        WHERE
                                                        id = '" . $_GET['id'] . "'");
                    }

                    echo "<script> 
                            document.location='periksa.php';
                            </script>";
                }
                ?>
<div class="container">

            
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

