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
          <a class="nav-link active" aria-current="page" href="./admin.php">Data Hadir</a>
        </li>
      </ul>
    <a href="./logout.php" class="btn btn-outline-danger">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <h3>Daftar Hadir</h3>
<table class="table">

  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nama</th>
      <th scope="col">Waktu</th>
      <th scope="col">Tanggal</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    
    $i = 1;
    $query = "SELECT tstatus.id as status_id, guests.id, guests.name, tstatus.time, tstatus.date FROM guests INNER JOIN tstatus ON guests.id = tstatus.guest_id";
    $result = mysqli_query($conn, $query);

    while($row = mysqli_fetch_assoc($result)) {
    ?>
    <tr>
      <th scope="row"><?= $i++ ?></th>
      <td><?= $row['name'] ?></td>
      <td><?= $row['time'] ?></td>
      <td><?= $row['date'] ?></td>
      <td>
        <a href="dstatus.php?id=<?php echo $row['status_id'] ?>" class="btn btn-outline-danger">Delete</a>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>
</div>


<?php 
include_once('../footer.php')
?>