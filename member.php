<?php
require 'php/userClass.php';
require 'php/petClass.php';
//require 'php/minigamesClass.php';
include "header_online.php";

$users = new User();
$users->protect();

$pets = new Pet();
$result = $pets->showPets();


/**** rodyti esamus ir galimus keisti gyvūnus*/
if(isset($_POST['petActual']))
    $test = $_POST['petActual'];
else if(count($result) > 0)
    $test = $result[0]['idPet'];

if(!empty($test))
    $petActual = $pets->retPet($test);
else
    header('Location: /createPet.php');

$_SESSION["idPet"] = $petActual['idPet'];

$pets->controlsGeneral($petActual['idPet']);
$pets->restartPet($petActual['idPet']);

///** nužudyti gyvūną */
if(isset($_POST['delete'])){
    $pets->deletePet();
}


/** minigame valdymas */
$game = new Minigame();
$resGame = $game->showMinigames($petActual['idPet']);

if(isset($_POST['petM']) && isset($_POST['minigameActual'])){
    $idP = $_POST['petM'];
    $idM = $_POST['minigameActual'];
}

if(!empty($idP) && !empty($idM)){
    if($idM == 'Akmuo - Popierius - Zirkles'){
        header("Location: minigames/akmuo-popierius-zirkles.php?idP=$idP");
    }
    else if($idM == 'Kryžiukai-Nuliukai'){
        header("Location: minigames/kryziukai-nuliukai.php?idP=$idP");
    }
}

$listRanking = $game->ranking();


/** maistas */
if(isset($_POST['petHungry'])){
    if(isset($_POST['Rabbit'])){
        $pets->feed($_POST['Rabbit'], $_POST['petHungry']);
    }
    else if(isset($_POST['Mouse'])){
        $pets->feed($_POST['Mouse'], $_POST['petHungry']);
    }
    else if(isset($_POST['Bird'])){
        $pets->feed($_POST['Bird'], $_POST['petHungry']);
    }
    else if(isset($_POST['Fruit'])){
        $pets->feed($_POST['Fruit'], $_POST['petHungry']);
    }
    else if(isset($_POST['Bug'])){
        $pets->feed($_POST['Bug'], $_POST['petHungry']);
    }
}

/** prausimasis */
if(isset($_POST['bath']) && isset($_POST['petID']))
    $pets->bathing($_POST['petID']);

/** miegas */
if(isset($_POST['sleep']) && isset($_POST['petIDSleep']))
    $pets->sleeping($_POST['petIDSleep']);

///** gydymas */
if(isset($_POST['cure']) && isset($_POST['petIDCure']))
    $pets->curing($_POST['petIDCure']);
?>

        <div class="container-fluid">
            <main class="row">
                <div class="col-1 mt-4 meniu"></div>
    <?php include "gyvuno_valdymo_meniu.php";?>
<!--                Pagrindinis ekranas-->
                <div class="col-8 mt-4 ekranas meniu">
                <div class="row">
                    <div class="col-7 bg-primary">
                        info
                            <table id="timeActual" class="table align-">
                                <thead class="table-dark ">
                                <tr>
                                    <th  scope="col">Laimė</th>
                                    <th scope="col">Alkis</th>
                                    <th scope="col">Sveikata</th>
                                    <th scope="col">Miegas</th>
                                    <th scope="col">Būsena</th>
                                    <th scope="col">Amžius</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="progress">
                                            <?php if($petActual['petHappiness'] < 50){?>
                                                <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" aria-valuenow="<?=$petActual['petHappiness']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$petActual['petHappiness']; ?>%</div>
                                            <?php } else { ?>
                                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?=$petActual['petHappiness']; ?>%" aria-valuenow="<?=$petActual['petHappiness']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$petActual['petHappiness']; ?>%</div>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="progress">
                                            <?php if($petActual['petHunger'] < 50){?>
                                                <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?=$petActual['petHunger']; ?>%; color: black;" aria-valuenow="<?=$petActual['petHunger']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$petActual['petHunger']; ?>%</div>
                                            <?php } else { ?>
                                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?=$petActual['petHunger']; ?>%" aria-valuenow="<?=$petActual['petHunger']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$petActual['petHunger']; ?>%</div>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="progress">
                                            <?php if($petActual['petHealth'] <= 40){?>
                                                <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?=$petActual['petHealth']; ?>%; color: black;" aria-valuenow="<?=$petActual['petHealth']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$petActual['petHealth']; ?>%</div>
                                            <?php } else { ?>
                                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?=$petActual['petHealth']; ?>%" aria-valuenow="<?=$petActual['petHealth']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$petActual['petHealth']; ?>%</div>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="progress">
                                            <?php if($petActual['petSleep'] < 50){?>
                                                <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?=$petActual['petSleep']; ?>%; color: black;" aria-valuenow="<?=$petActual['petSleep']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$petActual['petSleep']; ?>%</div>
                                            <?php } else { ?>
                                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?=$petActual['petSleep']; ?>%" aria-valuenow="<?=$petActual['petSleep']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$petActual['petSleep']; ?>%</div>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td style="font-weight: bold; font-style: italic;"> <?php echo $petActual['petState']; ?></td>
                                    <td style="font-weight: bold;"> <?php echo $petActual['age']; ?></td>
                                    <?php// } ?>
                                </tr>
                                </tbody>
                            </table>

<!--                            <table class="table" align="center" style="width: 80%; margin-top: 8%;">-->
<!--                                <thead class="table-dark">-->
<!--                                <tr>-->
<!--                                    <th scope="col">-->
<!---->
<!--                                        --><?php //if($petActual['petState'] == 'dormindo'){ ?>
<!--                                            <a disabled class="btn btn-outline-danger rounded-circle disabled" role="button">-->
<!--                                                <i class="fas fa-utensils"></i>-->
<!--                                            </a>-->
<!--                                        --><?php //} else{ ?>
<!--                                            <a onmousedown="btnsMenu.play()" id="alimentar" class="btn btn-outline-danger rounded-circle" role="button" href="#lista-comidas" data-toggle="modal">-->
<!--                                                <i class="fas fa-utensils"></i>-->
<!--                                            </a>-->
<!--                                        --><?php //} ?>
<!--                                    </th>-->
<!--                                    <th scope="col">-->
<!--                                        <form action="listagem-pet.php" method="post">-->
<!--                                            <input type="hidden" id="banho" name="banho"></input>-->
<!--                                            <input type="hidden" id="petID" name="petID" value="--><?//=$petActual['idPet'];?><!--"></input>-->
<!--                                            <button onmousedown="btnBanho.play()" type="submit" class="btn btn-outline-primary rounded-circle">-->
<!--                                                <i class="fas fa-shower"></i>-->
<!--                                            </button>-->
<!--                                        </form>-->
<!--                                    </th>-->
<!--                                    <th scope="col">-->
<!--                                        --><?php //if($petActual['petState'] == 'dormindo'){ ?>
<!--                                            <a class="btn btn-outline-success rounded-circle disabled" role="button">-->
<!--                                                <i class="fas fa-gamepad"></i>-->
<!--                                            </a>-->
<!--                                        --><?php //} else{ ?>
<!--                                            <a onmousedown="btnsMenu.play()" id="minigame" class="btn btn-outline-success rounded-circle"  role="button" href="#lista-minigames" data-toggle="modal">-->
<!--                                                <i class="fas fa-gamepad"></i>-->
<!--                                            </a>-->
<!--                                        --><?php //} ?>
<!--                                    </th>-->
<!--                                    <th scope="col">-->
<!--                                        <form action="listagem-pet.php" method="post">-->
<!--                                            <input type="hidden" id="dormir" name="dormir"></input>-->
<!--                                            <input type="hidden" id="petIDDormir" name="petIDDormir" value="--><?//=$petActual['idPet'];?><!--"></input>-->
<!--                                            --><?php //if($petActual['petState'] == 'dormindo'){?>
<!--                                                <button onmousedown="btnNS.play()" type="submit" class="btn btn-outline-warning rounded-circle">-->
<!--                                                    <i class="fas fa-sun"></i>-->
<!--                                                </button>-->
<!--                                            --><?php //} else{?>
<!--                                                <button onmousedown="btnNS.play()" type="submit" class="btn btn-outline-info rounded-circle">-->
<!--                                                    <i class="fas fa-bed"></i>-->
<!--                                                </button>-->
<!--                                            --><?php //} ?>
<!--                                        </form>-->
<!--                                    </th>-->
<!--                                    <th scope="col">-->
<!--                                        <form action="listagem-pet.php" method="post">-->
<!--                                            <input type="hidden" id="cura" name="cura"></input>-->
<!--                                            <input type="hidden" id="petIDCura" name="petIDCura" value="--><?//=$petActual['idPet'];?><!--"></input>-->
<!--                                            <button onmousedown="btnNS.play()" type="submit" class="btn btn-outline-danger rounded-circle">-->
<!--                                                <i class="fas fa-syringe"></i>-->
<!--                                            </button>-->
<!--                                        </form>-->
<!--                                    </th>-->
<!--                                    <th scope="col">-->
<!--                                        <a onmousedown="btnsMenu.play()" name="peso" class="btn btn-outline-info rounded-circle" role="button" href="#peso" data-toggle="modal">-->
<!--                                            <i class="fas fa-weight"></i>-->
<!--                                        </a>-->
<!--                                    </th>-->
<!--                                </tr>-->
<!--                                </thead>-->
<!--                            </table>-->
                        </div>
                    </div>


                    </div>
                    <div class="col-5 bg-danger">foto
                        <div class="">
                            <img src="images/<?=$petActual['image']?>" />
                        </div>

                    </div>
                </div>
                </div>
                <div class="col-1 mt-4 meniu"></div>


            </main>
        </div>











        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        </body>
        </html>