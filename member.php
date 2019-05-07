<?php
require 'php/userClass.php';
require 'php/petClass.php';

$users = new User();
$users->protect();

$pets = new Pet();
$result = $pets->showPets();


if(isset($_POST['petActual']))
    $test = $_POST['petActual'];
else if(count($result) > 0)
    $test = $result[0]['idPet'];

if(!empty($test))
    $petActual = $pets->retPet($test);
else
    header('Location: ./createPet.php');

$_SESSION["idPet"] = $petActual['idPet'];

$pets->controlsGeneral($petActual['idPet']);
$pets->restartPet($petActual['idPet']);


if(isset($_POST['delete'])){
    $pets->deletePet();
}

if(isset($_POST['petHunger'])){
    if(isset($_POST['Whiskas'])){
        $pets->feed($_POST['Whiskas'], $_POST['petHunger']);
    }
    else if(isset($_POST['Mouse'])){
        $pets->feed($_POST['Mouse'], $_POST['petHunger']);
    }

    else if(isset($_POST['Pedigree'])){
        $pets->feed($_POST['Pedigree'], $_POST['petHunger']);
    }
}

if(isset($_POST['bath']) && isset($_POST['petID']))
    $pets->bathing($_POST['petID']);

if(isset($_POST['sleep']) && isset($_POST['petIDSleep']))
    $pets->timeToSleep($_POST['petIDSleep']);

if(isset($_POST['cure']) && isset($_POST['petIDCure']))
    $pets->cure($_POST['petIDCure']);
include 'header_online.php';
include 'modals.php';
?>


<div class="container-fluid">
    <main class="row">
        <div class="col-1 mt-4 meniu"></div>

        <div class=" col mt-4 meniu" >
            <div class="row" style="border: 3px solid navy;text-align: center;"><strong >Gyvūno valdymo meniu</strong></div>
            <br>

            <div class="container" >

                <div class="row">
                    <th scope="col">
                    <?php if($petActual['petState'] == 'sleeping'){ ?>
                        <a disabled class="btn disabled" role="button">
                            <i class="fas fa-utensils"></i>
                        </a>
                    <?php } else{ ?>
                        <a id="feed" class="btn btn-dark" role="button" href="#show-food" data-toggle="modal">
                            <i class="fas fa-utensils"></i>Valgyti
                        </a>
                    <?php } ?>
                    </th>
<!--                    <div class="col- fas fa-utensils">-->
<!--                        <a href=""><button type="button" class="btn btn-dark">Valgyti</button></a>-->
<!---->
<!--                    </div>-->
                </div>
                <br>
                <div class="row">
                    <div scope="col">
                        <form action="member.php" method="post">
                            <input type="hidden" id="bath" name="bath"></input>
                            <input type="hidden" id="petID" name="petID" value="<?=$petActual['idPet'];?>"></input>
                            <button type="submit" class="btn btn-dark">
                                <i class="fas fa-shower"></i>Praustis
                            </button>
                        </form>
                    </div>
<!--                    <div class="col- fas fa-bath">-->
<!--                        <a href=""><button type="button" class="btn btn-dark">Praustis</button></a>-->
<!---->
<!--                    </div>-->
                </div>
                <br>
                <div class="row">

                    <th scope="col">
                        <form action="member.php" method="post">
                            <input type="hidden" id="sleep" name="sleep"></input>
                            <input type="hidden" id="petIDSleep" name="petIDSleep" value="<?=$petActual['idPet'];?>"></input>
                            <?php if($petActual['petState'] == 'dormindo'){?>
                                <button type="submit" class="btn btn-dark">
                                    <i class="fas fa-sun"></i>
                                </button>
                            <?php } else{?>
                                <button type="submit" class="btn btn-dark">
                                    <i class="fas fa-bed"></i>Miegoti
                                </button>
                            <?php } ?>
                        </form>
                    </th>

<!--                    <div class="col- fas fa-bed">-->
<!--                        <a href=""><button type="button" class="btn btn-dark"> Miegoti</button></a>-->
<!---->
<!--                    </div>-->
                </div>
                <br>
<!--                <div class="row">-->
<!--                    <div class="col- fas fa-gamepad">-->
<!--                        <a href=""><button type="button" class="btn btn-dark">Žaisti</button></a>-->
<!---->
<!--                    </div>-->
<!--                </div>-->
<!--                <br>-->
                <div class="row">

                    <th scope="col">
                        <form action="member.php" method="post">
                            <input type="hidden" id="cure" name="cure"></input>
                            <input type="hidden" id="petIDCure" name="petIDCure" value="<?=$petActual['idPet'];?>"></input>
                            <button type="submit" class="btn btn-dark">
                                <i class="fas fa-syringe"></i>Gydyti
                            </button>
                        </form>
                    </th>
<!--                    <div class="col- fas fa-first-aid">-->
<!--                        <a href=""><button type="button" class="btn btn-dark">Gydyti</button></a>-->
<!---->
<!--                    </div>-->
                </div>
                <br>
                <div class="row">
                    <th scope="col">
                        <form action="member.php" method="post">
                            <input type="hidden" id="cure" name="cure"></input>
                            <input type="hidden" id="petIDCure" name="petIDCure" value="<?=$petActual['idPet'];?>"></input>
                            <button type="submit" class="btn btn-dark">
                                <i class="fas fa-syringe"></i>Svoris
                            </button>
                        </form>
                    </th>
<!--                    <div class="col- fas fa-weight">-->
<!--                        <a href=""><button type="button" class="btn btn-dark">Svoris</button></a>-->
<!---->
<!--                    </div>-->
                </div>
                <br>
            </div>



        </div>
        <!--                Pagrindinis ekranas-->
        <div class="col-8 mt-4 ekranas meniu">
            <div class="row">

<!--                info pateikimas-->
                <div class="col-7">info
                        <div align="center" style="width: 50%; margin-left: 25%;">
                            <table id="timeActual" style="width: 80%; margin-top: 2%;">
                                <thead class="table-dark">
                                <tr>
                                    <th scope="col">Laimė</th>
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
                                                <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?=$petActual['petHappiness']; ?>%; color: black;" aria-valuenow="<?=$petActual['petHappiness']; ?>" aria-valuemin="0" aria-valuemax="100"><?=$petActual['petHappiness']; ?>%</div>
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
        <div class="container-fluid">
            <main class="row">
                <div class="col-1 mt-4 meniu"></div>


    <div class=" col bg-primary mt-4 meniu" >
        <div class="row" style="border: 3px solid navy;text-align: center;"><strong >Gyvūno valdymo meniu</strong></div>
        <br>

        <div class="container" >

            <div class="row">
                <div class="col- fas fa-utensils">
                    <a href=""><button type="button" class="btn btn-dark">Valgyti</button></a>

                </div>
            </div>
            <br>
            <div class="row">
                <div class="col- fas fa-bath">
                    <a href=""><button type="button" class="btn btn-dark">Praustis</button></a>

                </div>
            </div>
            <br>
            <div class="row">
                <div class="col- fas fa-bed">
                    <a href=""><button type="button" class="btn btn-dark"> Miegoti</button></a>

                </div>
            </div>
            <br>
            <div class="row">
                <div class="col- fas fa-gamepad">
                    <a href="final/index.html"><button type="button" class="btn btn-dark">Žaisti</button></a>

                </div>
            </div>
            <br>
            <div class="row">
                <div class="col- fas fa-first-aid">
                    <a href=""><button type="button" class="btn btn-dark">Gydyti</button></a>

                </div>
            </div>
            <br>
            <div class="row">
                <div class="col- fas fa-weight">
                    <a href=""><button type="button" class="btn btn-dark">Svoris</button></a>

                </div>
                <div class="col-1 mt-4 meniu"></div>


    </main>
</div>











<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>


<?php
include 'footer.php';
?>

