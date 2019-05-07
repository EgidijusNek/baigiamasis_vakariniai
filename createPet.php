<?php
/**
 * Created by PhpStorm.
 * User: egidi
 * Date: 2019-05-01
 * Time: 17:55
 */
include 'header_online.php';
require 'php/userClass.php';
$users=new User();

require 'php/petClass.php';
$pets=new Pet();
$pets->createPet();
$idPet = $pets->retIDPet();

//require 'php/minigamesClass.php';
//$game = new Minigame();
//if(!empty($idPet))
//    $game->createMinigame($idPet);

if(array_key_exists('create' ,$_POST))
    printf('<script>document.location="http://gyvuno.kurimas/member.php"</script>');

//    header('Location: ./member.php');

?>
<main class="container-fluid">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="jumbotron text-center registracijos_forma">
                <h1>Sukurk savo augintinį!</h1>
                <p>Sugalvok vardą savo virtualiam augintiniui ir įvesk jį žemiau!</p>
                <p>
                <form action="createPet.php" method="post" class="form-signin registracijos_forma">
                    <div class="form-group">
                        <input type="text" class="form-control" id="inputName" name="petName" placeholder="Vardas:" required>
                    </div>
                    <button name="create" class="btn btn-lg btn-danger btn-block" type="submit">
                        Kurti!
                    </button>
                    <a href="member.php" class="btn btn-lg btn-primary btn-block">Eiti į pagrindinį puslapį</a>
                </form>
            </div>
        </div>

</main>

<?php
include 'footer.php';
?>
