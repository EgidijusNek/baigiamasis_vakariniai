<?php require_once 'member.php';?>
<div class="col-2 mt-4 meniu">Gyvūno valdymo meniu
<ul class="nav flex-column">
            <li class="nav-item">
                <?php if($petActual['petState'] == 'sleeping'){ ?>
                    <a disabled class="btn btn-outline-danger disabled">
                        <i class="fas fa-utensils"></i>
                    </a>
                <?php } else{ ?>
                    <a id="feed" class="btn" href="#show-food" data-toggle="modal">
                        <i class="fas fa-utensils"></i>
                    </a>
                <?php } ?>
<!--                <a class="nav-link bg-success fas fa-utensils" href="#">Maitinti</a>-->
            </li>
            <li class="nav-item">
                <form action="member.php" method="post">
                    <input type="hidden" id="bath" name="bath"></input>
                    <input type="hidden" id="petID" name="petID" value="<?=$petActual['idPet'];?>"></input>
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-shower"></i>Prausti
                    </button>
                </form>

<!--                <a class="nav-link bg-success" href="#">Prausti</a>-->
            </li>
            <li class="nav-item">
                <?php if($petActual['petState'] == 'sleeping'){ ?>
                    <a class="btn btn-outline-success disabled">
                        <i class="fas fa-gamepad"></i>
                    </a>
                <?php } else{ ?>
                    <a id="minigame" class="btn btn-outline-success" href="#list-minigames" data-toggle="modal">
                        <i class="fas fa-gamepad"></i>Žaisti
                    </a>
                <?php } ?>

<!--                <a class="nav-link bg-success" href="#">Žaisti</a>-->
            </li>
            <li class="nav-item">

                <form action="member.php" method="post">
                    <input type="hidden" id="sleep" name="sleep"></input>
                    <input type="hidden" id="petIDSleep" name="petIDSleep" value="<?=$petActual['idPet'];?>"></input>
                    <?php if($petActual['petState'] == 'sleeping'){?>
                        <button type="submit" class="btn btn-outline-warning">
                            <i class="fas fa-sun"></i>
                        </button>
                    <?php } else{?>
                        <button type="submit" class="btn btn-outline-info">
                            <i class="fas fa-bed"></i>Laikas miegoti
                        </button>
                    <?php } ?>
                </form>


<!--                <a class="nav-link bg-success" href="#">Laikas Miegoti</a>-->
            </li>
            <li class="nav-item">

                <form action="member.php" method="post">
                    <input type="hidden" id="cure" name="cure"></input>
                    <input type="hidden" id="petIDCure" name="petIDCure" value="<?=$petActual['idPet'];?>"></input>
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="fas fa-syringe"></i>Duoti vaistų
                    </button>
                </form>

<!--                <a class="nav-link bg-success" href="#">Duoti Vaistų</a>-->
            </li>
            <li class="nav-item">

                <a name="weight" class="btn btn-outline-info" role="button" href="#weight" data-toggle="modal">
                    <i class="fas fa-weight"></i>Svoris
                </a>
<!--                <a class="nav-link bg-success" href="#">Svoris</a>-->
            </li>
        </ul>
    </div>
