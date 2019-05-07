<?php
require 'php/userClass.php';
$users=new User();
$users->login();
include "header.php";
?>

    <main class="container-fluid">
        <div class="jumbotron text-center registracijos_forma">
            <h1>Prisijunk!</h1>
            <p>Augink ir prižiūrėk savo virtualius augintinius</p>

            <form action="login.php" method="post" class="form-signin registracijos_forma login">
                <div class="form-group">
                    <input type="text" class="form-control" name="user" placeholder="Vartotojo vardas" required autofocus>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Slaptažodis" required>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">
                    <span class=""></span> Prisijungti!
                </button>
            </form>
        </div>

    </main>

<?php
include "footer.php";