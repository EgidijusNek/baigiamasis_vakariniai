
<!doctype html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Virtualus Augintis</title>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-dark ">

    <div class="col-9 collapse navbar-collapse justify-content-center ml-6"><ul class="navbar-nav">
            <li class="nav-item">
                <a href="createPet.php" class="btn btn-md btn-success mr-1">Naujas Gyvūnas</a>
            </li>
            <li class="nav-item">
                <a href="#show-pets" class="btn btn-md btn-primary mr-1" data-toggle="modal">Keisti Gyvūną</a>
            </li>
<!--            <li class="nav-item">-->
<!--                <a class="btn btn-md btn-info" href="#ranking" data-toggle="modal">Žaidimų Rezultatai</a>-->
<!--            </li>-->
        </ul></div>
    <div class="col-3">
<!--        <button type="button" class="btn btn-md btn-secondary" >Pranešimai <span class="badge badge-light">?</span></button>-->
        <a class="btn btn-md btn-danger" href="logout.php">Atsijungti</a>
        </div>
</nav>
<!--<h1 class="display-4 text-center">Sveiki, štai jūsų gyvūnas--><?php //echo $petActual['namePet']; ?><!--!</h1>-->

<!--pridėti teksto eilutę su pasisveikinimu su vartotoju-->
<!--<h1 class="text-center display-4 mt-3">Tavo Virtualus Augintinis</h1>-->

<!-- Modal Keisti gyvūnus -->
<div class="modal fade" id="show-pets" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary" style="color: white;">
                <h4 class="modal-title" id="modalLabel">Mano Augintiniai</h4>
                <button type="button" style="color: white" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php foreach($result as $name){ ?>
                    <form action="member.php" method="post">
                        <input type="hidden" id="petActual" name="petActual" value="<?=$name['idPet'];?>">
                        <?php if($name['idPet'] % 2 == 0){?>
                            <button type="submit" class="btn btn-primary">
                                <?php echo $name['namePet'];?>
                            </button>
                            <button style="float: right;" type="submit" class="btn btn-outline-danger rounded-circle" id="delete" name="delete">
                                <i class="fas fa-skull"></i>
                            </button>
                        <?php } else{ ?>
                            <button type="submit" class="btn btn-info">
                                <?php echo $name['namePet'];?>
                            </button>
                            <button style="float: right;" type="submit" class="btn btn-outline-danger rounded-circle" id="delete" name="delete">
                                <i class="fas fa-skull"></i>
                            </button>
                        <?php }?>
                    </form>
                    <br><br>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!--Modal Žaidimų Rezultatai-->
<div class="modal fade" id="ranking" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning" style="color: white;">
                <h4 class="modal-title" id="modalLabel">Žaidimų Rezultatai</h4>
                <button type="button" style="color: white" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table" align="center"  style="text-align: center;">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col">Vieta</th>
                        <th scope="col">Vartotojo ID</th>
                        <th scope="col">Gyvūnas</th>
                        <th scope="col">Žaidimas</th>
                    </tr>
                    </thead>
                    <?php $i = 1; foreach($listRanking as $item){ ?>
                        <tbody>
                        <tr>
                            <th>
                                <?php echo $i; ?>
                            </th>
                            <th>
                                <?= $item['UserId']; ?>
                            </th>
                            <th>
                                <?=  $item['namePet']; ?>
                            </th>
                            <th>
                                <?=  $item['nameMinigame']; ?>
                            </th>
                        </tr>
                        </tbody>
                        <?php $i++;} ?>
                </table>
                <br><br>
            </div>
        </div>
    </div>
</div>

<!-- Modalas žaidimai -->
<!--<div class="modal fade" id="list-minigames" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">-->
<!--    <div class="modal-dialog" role="document">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header" style="background-color: green; color: white;">-->
<!--                <h4 class="modal-title" id="modalLabel">Žaidimai</h4>-->
<!--                <button type="button" style="color: white" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                    <span aria-hidden="true">&times;</span>-->
<!--                </button>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                --><?php
//                foreach($resGame as $minigame){
//                    $idP = $minigame['idPet'];
//                    $idM = $minigame['nameMinigame'];
//                    ?>
<!--                    <form action="member.php" method="post">-->
<!--                        <input type="hidden" id="petM" name="petM" value="--><?//=$minigame['idPet']?><!--"-->
<!--                        <input type="hidden" id="minigameActual" name="minigameActual" value="--><?//=$minigame['nameMinigame']?><!--"</input>-->
<!--                        --><?php //if($idM == 'Kryžiukai Nuliukai'){?>
<!--                            <button type="submit" class="btn btn-outline-success">-->
<!--                                <img src="https://png.icons8.com/dusk/40/000000/hashtag.png">-->
<!--                            </button>-->
<!--                        --><?php //} else {?>
<!--                            <button type="submit" class="btn btn-outline-primary">-->
<!--                                <img src="https://png.icons8.com/ultraviolet/40/000000/star-trek-gesture.png">-->
<!--                            </button>-->
<!--                        --><?php //}?>
<!--                    </form>-->
<!--                    <br><br>-->
<!--                --><?php //} ?>
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!-- Modalas Maistas -->
<div class="modal fade" id="show-food" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger" style="color: white;">
                <h4 class="modal-title" id="modalLabel">Pamaitink savo augintinį</h4>
                <button type="button" class="close" style="color: white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="member.php" method="post">
                    <button type="submit" class="btn btn-outline-info" id="Rabbit" name="Rabbit" value="Triušis"><img src="https://png.icons8.com/office/40/000000/rabbit.png"></button>
                    <button type="submit" class="btn btn-outline-success" id="Mouse" name="Mouse" value="Pelė"><img src="https://png.icons8.com/color/40/000000/animation.png"></button>
                    <button type="submit" class="btn btn-outline-warning" id="Bird" name="Bird" value="Paukštis"><img src="https://png.icons8.com/color/40/000000/bird.png"></button>
                    <button type="submit" class="btn btn-outline-danger" id="Fruit" name="Fruit" value="Vaisius"><img src="https://png.icons8.com/color/40/000000/strawberry.png"></button>
                    <button type="submit" class="btn btn-outline-dark" id="Bug" name="Bug" value="Vabalas"><img src="https://png.icons8.com/color/40/000000/insect.png"></button>
                    <input type="hidden" id="petHungry" name="petHungry" value="<?=$petActual['idPet'];?>"
                </form>
                <br><br>
            </div>
            <div class="modal-footer">
                <p style="font-weight: bold;">Atsargiai! Kai kurie maisto produktai gali pakenkti gyvūnui...</p>
            </div>
        </div>
    </div>
</div>

<!-- Modalas Svoris -->
<div class="modal fade" id="weight" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info" style="color: white;">
                <h4 class="modal-title" id="modalLabel">Svoris</h4>
                <button type="button" style="color: white" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h1 class="text-center"><?php echo $petActual['weight'];?> Kg<h1>
            </div>
            <?php if($petActual['age'] < 4){?>
                <p class="text-center" style="font-weight: bold;">Tobulas svoris: 7 Kg</p>
                <?php if($petActual['weight'] > 7){?>
                    <p class="text-center" style="font-weight: bold; color: red"><br>Noriu pažaisti! Pradedu nutukti!</p>
                <?php } ?>
            <?php } else {?>
                <p class="text-center" style="font-weight: bold;">Tobulas Svoris: 14 Kg</p>
                <?php if($petActual['weight'] > 14){?>
                    <p class="text-center" style="font-weight: bold; color: red">Noriu pažaisti! Pradedu nutukti!</p>
                <?php } ?>
            <?php }?>
        </div>
    </div>
</div