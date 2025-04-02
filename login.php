<?php 

include_once('./header.php');
require './function.php';

$m = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $pass = $_POST['password'];
    $m = loginUser($username, $pass);
}
echo $m;

?>

<div class="container"> 
<div class="position-absolute top-50 start-50 translate-middle">
    <h2>Login</h2>
    <form action="" method="post">
        <input type="text" class="form-control" placeholder="Username" name="username">
        <input type="password" class="form-control mt-2" placeholder="Password" name="password">
        <button class="btn btn-primary mt-2" type="submit">Login</button>
    </form>
</div>
</div>
<?php 
include_once('./footer.php')
?>