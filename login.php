<?php
include "check_login.php";
include "header.php";
?>


<div class="container-fluid">

    <div class="row">
        <div class="col-4 offset-4">

            <form  method="post">
                <!-- emailas -->
                <div class="form-group">
                    <label>Email address</label>
                    <input type="text" name="email" class="form-control">

                </div>

                <!-- slaptazodis -->
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <!-- prisijungti mygtukas -->
                <button type="submit" class="btn btn-primary">Prisijungti</button>
            </form>

        </div>
    </div>

1
</div>

<?php
include "footer.php";
?>