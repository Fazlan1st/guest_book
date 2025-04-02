<?php 
session_start();
include_once('../header.php');
require '../function.php';


if(count($_POST)>0) {
  mysqli_query($conn,"UPDATE guests set name='" . $_POST['name'] . "', email='" . $_POST['email'] . "', mobile='" . $_POST['mobile'] . "' WHERE id='" . $_POST['id'] . "'");

}

$result = mysqli_query($conn,"SELECT * FROM guests WHERE id='" . $_GET['id'] . "'");
$row= mysqli_fetch_array($result);
?>

?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="./admin.php">Back</a>
  </div>
</nav>

<form action="" method="post" class="mt-3">
    <input type="text" name="id" value="<?= $row['id'] ?>">
    <input type="text" class="form-control" name="name" value="<?= $row['name'] ?>">
    <input type="email" class="form-control" name="email" value="<?= $row['email'] ?>">
    <input type="text" class="form-control" name="mobile" value="<?= $row['mobile'] ?>">
    <button type="submit" class="btn btn-secondary">Update</button>
</form>
<?php 
include_once('../footer.php')
?>