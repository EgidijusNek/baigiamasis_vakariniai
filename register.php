<?php
require 'php/userClass.php';
$users=new User();
$users->register();
include "header.php";
?>

<main class="container-fluid">
    <div class="jumbotron text-center registracijos_forma">
        <h1>Susikurk paskyrą!</h1>
        <p>Užpildyk žemiau esančius laukelius ir galėsi susikurti savo virtualų augintinį!</p>

        <form action="register.php" method="post" class="form-horizontal registracijos_forma form-control">
            <div class="form-group">
                <input type="text" class="form-control" id="inputUser" name="user" placeholder="Vartotojo vardas" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Slaptažodis" required>
            </div>
            <button class="btn btn-lg btn-danger btn-block" type="submit">
                <span class="glyphicon glyphicon-circle-arrow-right"></span> Registruotis!
            </button>
        </form>
    </div>

</main>

<?php
include "footer.php";