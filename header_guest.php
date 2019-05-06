<nav class="navbar navbar-expand-sm bg-dark ">

    <div class="col-9 collapse navbar-collapse justify-content-center ml-6">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Pirmas</a>
            </li>
<!--            <li class="nav-item">-->
<!--                <a class="nav-link" href="#">Apie</a>-->
<!--            </li>-->
<!--            <li class="nav-item">-->
<!--                <a class="nav-link" href="#">Tuščias</a>-->
<!--            </li>-->
        </ul>
    </div>
    <div class="col-3">
        <?php if (isset($_SESSION["user"])) { ?>
        <a href="login.php?logout=1" class="btn btn-primary ">Atsijungti</a>
        <?php } else { ?>
        <a href="login.php" class="btn btn-primary ">Prisijungti</a>
        <?php }; ?>

        <a href="register.php" type="button" class="btn btn-warning ">Registruotis</a>
    </div>
</nav>

<h1 class="text-center display-4 mt-3">Tavo Virtualus Augintinis</h1>


