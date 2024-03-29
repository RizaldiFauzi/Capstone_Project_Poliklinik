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
    
    <title>Dokter</title>   <!--Judul Halaman-->

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
        <h1>
            Dokter
        </h1> 
        <hr>
        <!--Form Input Data-->

                <form class="form row" method="POST" action="dokter.php" name="myForm" onsubmit="return(validate());">
                    <!-- Kode php untuk menghubungkan form dengan database -->
                    <?php
                    $nama = '';
                    $alamat = '';
                    $no_hp = '';
                    if (isset($_GET['id'])) {
                        $ambil = mysqli_query($mysqli, 
                        "SELECT * FROM dokter 
                        WHERE id='" . $_GET['id'] . "'");
                        while ($row = mysqli_fetch_array($ambil)) {
                            $nama = $row['nama'];
                            $alamat = $row['alamat'];
                            $no_hp = $row['no_hp'];
                        }
                    ?>
                        <input type="hidden" name="id" value="<?php echo
                        $_GET['id'] ?>">
                    <?php
                    }
                    ?>
                    <div class="col">
                        <label for="nama" class="form-label fw-bold">
                            Dokter
                        </label>
                        <input type="varchar" class="form-control" name="nama" id="nama" placeholder="Dokter" value="<?php echo $nama ?>">
                    </div>
                    <div class="col">
                        <label for="alamat" class="form-label fw-bold">
                            Alamat
                        </label>
                        <input type="varchar" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo $alamat ?>">
                    </div>
                    <div class="col mb-2">
                        <label for="no_hp" class="form-label fw-bold">
                        No HP
                        </label>
                        <input type="varchar" class="form-control" name="no_hp" id="no_hp" placeholder="No HP" value="<?php echo $no_hp ?>">
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
                    </div>
                </form>
                
                <table class="table table-hover">
                    <!--thead atau baris judul-->
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">No HP</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <!--tbody berisi isi tabel sesuai dengan judul atau head-->
                    <tbody>
                        <?php
                            $result = mysqli_query($mysqli, "SELECT * FROM dokter");
                            $no = 1;
                            while ($data = mysqli_fetch_array($result)) {
                            ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $data['nama'] ?></td>
                                    <td><?php echo $data['alamat'] ?></td>
                                    <td><?php echo $data['no_hp'] ?></td>
                                    <td>
                                        <a class="btn btn-success rounded-pill px-3" href="dokter.php?id=<?php echo $data['id'] ?>">Ubah</a>
                                        <a class="btn btn-danger rounded-pill px-3" href="dokter.php?id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
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
                        $ubah = mysqli_query($mysqli, "UPDATE dokter SET 
                                                        nama = '" . $_POST['nama'] . "',
                                                        alamat = '" . $_POST['alamat'] . "',
                                                        no_hp = '" . $_POST['no_hp'] . "'
                                                        WHERE
                                                        id = '" . $_POST['id'] . "'");
                    } else {
                      $nama = $_POST['nama'];
                      $alamat = $_POST['alamat'];
                      $no_hp = $_POST['no_hp'];
                      $tambah = mysqli_query($mysqli, "INSERT INTO dokter(nama, alamat, no_hp) VALUES('$nama', '$alamat', '$no_hp')");
                    }

                    echo "<script> 
                            document.location='dokter.php';
                            </script>";
                }

                if (isset($_GET['aksi'])) {
                    if ($_GET['aksi'] == 'hapus') {
                        $hapus = mysqli_query($mysqli, "DELETE FROM dokter WHERE id = '" . $_GET['id'] . "'");
                    } else if ($_GET['aksi'] == 'ubah_status') {
                        $ubah_status = mysqli_query($mysqli, "UPDATE dokter SET 
                                                        status = '" . $_GET['status'] . "' 
                                                        WHERE
                                                        id = '" . $_GET['id'] . "'");
                    }

                    echo "<script> 
                            document.location='dokter.php';
                            </script>";
                }
                ?>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

