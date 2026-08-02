<?php
session_start();
session_regenerate_id();
include 'config/koneksi.php';

if (!isset($_SESSION['NAME'])) {
  header("location:index.php");
  exit();
}

$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$query = mysqli_query($conn, "SELECT * FROM resume WHERE id='$id'");
$row   = mysqli_fetch_assoc($query);


// jika tombol save di tekan
if (isset($_POST['save'])) {
  $title     = $_POST['title'];
  $year_start    = $_POST['year_start'];
  $year_end    = $_POST['year_end'];
  $subtitle    = $_POST['subtitle'];
  $description = $_POST['description'];

  //masukkan ke dalam users sebutkan kolom di table user nilainya 
  // di ambil dari user nginput
  if ($id) {
    // query update
    $update = mysqli_query($conn, "UPDATE resume SET title='$title',year_start='$year_start',year_end='$year_end',subtitle='$subtitle',description='$description' WHERE id='$id'");
    header("location:resume.php?update=berhasil");
  } else {
    $insert = mysqli_query($conn, "INSERT INTO resume(title, year_start, year_end, subtitle, description) VALUES ('$title','$year_start','$year_end','$subtitle','$description')");
    header("location:resume.php?tambah=berhasil");
  }
}





?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Kaiadmin - Bootstrap 5 Admin Dashboard</title>
  <meta
    content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
    name="viewport" />
  <?php
  include "inc/css.php";
  ?>

</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php
    include "inc/sidebar.php";
    ?>
    <!-- End Sidebar -->

    <div class="main-panel">
      <div class="main-header">
        <div class="main-header-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
              <img
                src="assets/img/kaiadmin/logo_light.svg"
                alt="navbar brand"
                class="navbar-brand"
                height="20" />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <!-- Navbar Header -->
        <?php
        include "inc/navbar.php";
        ?>
        <!-- End Navbar -->
      </div>

      <div class="container">
        <div class="page-inner">
          <div
            class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
              <h3 class="fw-bold mb-3"><?php echo isset($_GET['edit']) ? 'Edit Resume' : 'Create New Resume'  ?> </h3>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6 col-md-12">
              <div class="card">
                <div class="card-body">
                  <form action="" method="post">
                    <div class="mb-3">
                      <label for="" class="form-label fw-bold">Title</label>
                      <input type="text"
                        class="form-control" name="title"
                        placeholder="Enter title" required
                        value="<?php echo ($id) ? $row['title'] : '' ?>">
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label">Year Start</label>
                      <select class="form-select" name="year_start" id="year_start"></select>
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label">Year End</label>
                      <select class="form-select" name="year_end" id="year_end"></select>
                    </div>

                    <div class="mb-3">
                      <label for="" class="form-label fw-bold">Subtitle</label>
                      <input type="text"
                        class="form-control" name="subtitle"
                        placeholder="Enter Subtitle" required
                        value="<?php echo ($id) ? $row['subtitle'] : '' ?>">
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label fw-bold">Description</label>
                      <textarea name="description" class="form-control" cols="30" rows="3"><?php echo ($id) ? $row['description'] : '' ?></textarea>
                    </div>

                    <div class="mb-3">
                      <button class="btn btn-primary" name="save" type="submit">
                        Save
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <footer class="footer">
        <div class="container-fluid d-flex justify-content-between">
          <nav class="pull-left">
            <ul class="nav">
              <li class="nav-item">
                <a class="nav-link" href="http://www.themekita.com">
                  ThemeKita
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"> Help </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"> Licenses </a>
              </li>
            </ul>
          </nav>
          <div class="copyright">
            2024, made with <i class="fa fa-heart heart text-danger"></i> by
            <a href="http://www.themekita.com">ThemeKita</a>
          </div>
          <div>
            Distributed by
            <a target="_blank" href="https://themewagon.com/">ThemeWagon</a>.
          </div>
        </div>
      </footer>
    </div>


  </div>
  <?php
  include "inc/js.php";
  ?>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const selectStart = document.getElementById('year_start');
      const selectEnd = document.getElementById('year_end');
      const currentYear = new Date().getFullYear();
      const startYear = 1920;

      // Ambil data tahun dari database jika mode edit
       const selectedStartYear = "<?php echo ($id && $row && isset($row['year_start'])) ? $row['year_start'] : ''; ?>";
       const selectedEndYear = "<?php echo ($id && $row && isset($row['year_end'])) ? $row['year_end'] : ''; ?>";

      // Loop untuk Year Start
      for (let year = currentYear; year >= startYear; year--) {
        const option = document.createElement("option");
        option.value = year;
        option.textContent = year;
        if (selectedStartYear && selectedStartYear == year) {
          option.selected = true;
        }
        selectStart.appendChild(option);
      }

      // Loop terpisah untuk Year End menggunakan objek elemen baru
      for (let year = currentYear; year >= startYear; year--) {
        const option = document.createElement("option");
        option.value = year;
        option.textContent = year;
        if (selectedEndYear && selectedEndYear == year) {
          option.selected = true;
        }
        selectEnd.appendChild(option);
      }
      
    });
  </script>
</body>

</html>