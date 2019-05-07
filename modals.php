
<div class="modal fade" id="show-pets" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary" style="color: white;">
                <h4 class="modal-title" id="modalLabel">Mano Gyvūnai</h4>
                <button type="button" style="color: white" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php foreach($result as $name){ ?>
                    <form action="member.php" method="post">
                        <input type="hidden" id="petActual" name="petActual" value="<?=$name['idPet'];?>"></input>
                        <?php if($name['idPet'] % 2 == 0){?>
                            <button type="submit" class="btn btn-primary">
                                <?php echo $name['petName'];?>
                            </button>
                            <button style="float: right;"  type="submit" class="btn btn-outline-danger rounded-circle" id="delete" name="delete">
                                <i class="fas fa-skull"></i>
                            </button>
                        <?php } else{ ?>
                            <button  type="submit" class="btn btn-info">
                                <?php echo $name['petName'];?>
                            </button>
                            <button style="float: right;"  type="submit" class="btn btn-outline-danger rounded-circle" id="delete" name="delete">
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



<!-- Modal feed -->
<div class="modal fade" id="show-food" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger" style="color: white;">
                <h4 class="modal-title" id="modalLabel">Maitinti</h4>
                <button type="button" class="close" style="color: white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="member.php" method="post">
                    <button type="submit" class="btn btn-outline-info" id="Whiskas" name="Whiskas" value="Whiskas"><img src="imgs/whiskas.jpeg"></button>
                    <button type="submit" class="btn btn-outline-success" id="Mouse" name="Mouse" value="Mouse"><img src="imgs/mouse.png"></button>
                    <button type="submit" class="btn btn-outline-dark" id="Pedigree" name="Pedigree" value="Pedigree"><img src="imgs/pedigree.jpg"></button>
                    <input type="hidden" id="petHunger" name="petHunger" value="<?=$petActual['idPet'];?>"></input>
                </form>
                <br><br>
            </div>
            <div class="modal-footer">
                <p style="font-weight: bold;">Atsargiai! Kai kurie maisto produktai gali pakenkti tavo augintiniui...</p>
            </div>
        </div>
    </div>
</div>


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
                    <p class="text-center" style="font-weight: bold; color: red"><br>Noriu žaisti! Pradedu nutukti!</p>
                <?php } ?>
            <?php } else {?>
                <p class="text-center" style="font-weight: bold;">Tobulas svoris: 14 Kg</p>
                <?php if($petActual['weight'] > 14){?>
                    <p class="text-center" style="font-weight: bold; color: red">Noriu žaisti! Pradedu nutukti!</p>
                <?php } ?>
            <?php }?>

        </div>
    </div>
</div>