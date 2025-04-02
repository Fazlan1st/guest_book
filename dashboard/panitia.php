<?php 
session_start();
include_once('../header.php');
require '../function.php';
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="#">Navbar</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="./scan.php">Scan</a>
        </li>
      </ul>
      <a href="./logout.php" class="btn btn-outline-danger">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <h3>Daftar Tamu</h3>
<table class="table">

  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nama</th>
      <th scope="col">Waktu</th>
      <th scope="col">Tanggal</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    
    $i = 1;
    $query = "SELECT guests.id, guests.name, tstatus.time, tstatus.date FROM guests INNER JOIN tstatus ON guests.id = tstatus.guest_id";
    $result = mysqli_query($conn, $query);
    if (!$result) {
      die("Query Error: " . mysqli_error($conn));
  }
    while($row = mysqli_fetch_assoc($result)) {
    ?>
    <tr>
      <th scope="row"><?= $i++ ?></th>
      <td><?= $row['name'] ?></td>
      <td><?= $row['time'] ?></td>
      <td><?= $row['date'] ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
</div>


<?php 
include_once('../footer.php')
?>