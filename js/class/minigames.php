<?php

class Minigame{
    protected $mysql;
    protected $db = array(
        'host'=>'localhost',
        'database'=>'virtual_pet_db',
        'user'=>'root',
        'password'=>'',
    );

    public function __construct(){
        $this->connectDB();
    }

    protected function connectDB(){
        $this->mysql = new PDO(
            'mysql:host='.$this->db['host'].';dbname='.$this->db['database'], $this->db['user'], $this->db['password']
        );
        $this->mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function createMinigame($petActual){
        $ppt = "INSERT INTO minigames (nameMinigame, score, petId) VALUES ('Akmuo - Popierius - Žirklės', 0, $petActual)";
        $mysql = $this->mysql->prepare($ppt);
        $mysql->execute();

        $gammer = "INSERT INTO minigames (nameMinigame, score, petId) VALUES ('Kryžiukai - Nuliukai', 0, $petActual)";
        $mysql = $this->mysql->prepare($gammer);
        $mysql->execute();
    }

    public function showMinigames($petActual){
        $sql = "SELECT * FROM minigames WHERE petId = '$petActual'";
        $mysql=$this->mysql->prepare($sql);
        $mysql->execute();
        return $mysql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function retGame($petId, $name){
        $sql = "SELECT * FROM minigames WHERE petId = '$petId' AND nameMinigame = '$idMinigame'";
        $mysql = $this->mysql->prepare($sql);
        $mysql->bindValue(':petId', $petId, PDO::PARAM_INT);
        $mysql->bindValue(':nameMinigame', $name, PDO::PARAM_STR);
        $mysql->execute();
        return $mysql->fetch(PDO::FETCH_ASSOC);
    }

    public function displayGame($nameGame, $item = null){
        if($nameGame == 'akmuo-popierius-žirklės'){
            $items = array('akmuo', 'popierius', 'žirklės');

            if($item == null)
                foreach($items as $item){
                    echo $item;
                }
            else{
                echo str_replace("?item{$item}", "#", $items[$item]);
            }
        }
        else if($nameGame == 'stiprumas'){
            echo "Dar neegzistuoja";
        }
        else if($nameGame == 'Play-the-game'){
            echo "Dar neegzistuoja";
        }
    }

    public function motivate($petId){
        $points = "SELECT SUM(score) FROM minigames WHERE petId = $petId";
        $mysql = $this->mysql->prepare($points);
        $mysql->execute();
        $happy= $mysql->fetchColumn();
        echo $happy;

        $hp = "SELECT petHappy FROM pet WHERE petId = $petId";
        $mysql = $this->mysql->prepare($hp);
        $mysql->execute();
        $time= $mysql->fetchColumn();

        $hunger = "SELECT petHungry FROM pet WHERE petId = $petId";
        $mysql = $this->mysql->prepare($hunger);
        $mysql->execute();
        $timeHunger = $mysql->fetchColumn();

        $kg = "SELECT weight FROM pet WHERE petId = $petId";
        $mysql = $this->mysql->prepare($kg);
        $mysql->execute();
        $weight = $mysql->fetchColumn();

        $time = $time + $happy*2;
        if($time > 100){
            $time = 100;
        }

        $timeHunger = $timeHunger - $happy*2;
        if($timeHunger < 0)
            $timeHunger = 0;

        $weight -= 2;
        if($weight < 0)
            $weight = 0;

        $query = "UPDATE pet SET petHappy = $time, petHungry = $timeHunger, weight = $weight WHERE petId = $petId";
        $mysql=$this->mysql->prepare($query);
        $mysql->execute();

        return $happy;
    }

    protected function calcscore($minigame, $petId){
        $sql = "SELECT score FROM minigames WHERE petId = $petId AND nameMinigame = '$minigame'";
        $mysql = $this->mysql->prepare($sql);
        $mysql->execute();
        $time = $mysql->fetchColumn();

        $newPoint = $time+1;

        $ppt="UPDATE minigames SET score = $newPoint WHERE petId = $petId AND nameMinigame = '$minigame'";
        $mysql=$this->mysql->prepare($ppt);
        $mysql->execute();

        $oi = $this->motivate($petId);
        echo $oi;

    }
//daryta iki čia
    public function play($item, $petId){
        if(!empty($item)){
            $items = array('akmuo', 'popierius', 'zirkles', 'lagarto', 'spock');

            $user_item = $item;
            $comp_item = $items[rand(0, 4)];

            // zirkles corta popierius
            // popierius cobre akmuo
            // akmuo esmaga lagarto
            // Lagarto envenena Spock
            // Spock esmaga (ou derrete) zirkles
            // zirkles decapita lagarto
            // Lagarto come popierius
            // popierius refuta Spock
            // Spock vaporiza akmuo
            // akmuo quebra zirkles

            if(($user_item == 'akmuo' && $comp_item == 'zirkles') ||
                ($user_item == 'zirkles' && $comp_item == 'popierius') ||
                ($user_item == 'popierius' && $comp_item == 'akmuo') ||
                ($user_item == 'akmuo' && $comp_item == 'lagarto') ||
                ($user_item == 'lagarto' && $comp_item == 'spock') ||
                ($user_item == 'spock' && $comp_item == 'zirkles') ||
                ($user_item == 'zirkles' && $comp_item == 'lagarto') ||
                ($user_item == 'lagarto' && $comp_item == 'popierius') ||
                ($user_item == 'popierius' && $comp_item == 'spock') ||
                ($user_item == 'spock' && $comp_item == 'akmuo')){
                $this->calcscore('akmuo - popierius - zirkles', $petId);
                echo "<script type='text/javascript'>alert('Você: $user_item \\nComputador: $comp_item \\nVocê venceu!');javascript:window.location='akmuo-popierius-zirkles.php_senas?idP=$petId';</script>";
            }
            else if ($user_item == $comp_item){
                echo "<script type='text/javascript'>alert('Você: $user_item \\nComputador: $comp_item \\nEmpate!');javascript:window.location='akmuo-popierius-zirkles.php_senas?idP=$petId';</script>";
            }
            else{
                echo "<script type='text/javascript'>alert('Você: $user_item \\nComputador: $comp_item \\nVocê perdeu!');javascript:window.location='akmuo-popierius-zirkles.php_senas?idP=$petId';</script>";
            }

            echo $user_item;
            echo $comp_item;

            //echo '<br><br> <a class="btn btn-outline-success menu-nav" href=""./akmuo-popierius-zirkles.php_senas"" role="button">play de Novo!</a>';
        }
        //else{
        //  echo $this->displayGame('akmuo-popierius-zirkles');
        //}
    }

    public function playgammer($box, $petId){
        $campeao = 'n';

        $jogada = 0;
        for($j = 0; $j <= 8; $j++){
            if($_POST["box".$j] != 'x' && $_POST["box".$j] != '' && $_POST["box".$j] != 'o' || strlen($_POST["box".$j]) > 1)
                echo "<script type='text/javascript'>alert('Operação inválida!');</script>";
            else{
                $box[$j] = $_POST["box".$j];
                if($box[$j] != '')
                    $jogada++;
            }
        }

        //Daqui em diante as posições são preenchidas conforme o user joga, o computador é a bolinha.
        if($jogada == 1 || $jogada == 3 || $jogada == 5 || $jogada == 7 || $jogada == 9){
            $blank = 0;
            for($i = 0; $i <= 8; $i++){
                if($box[$i] == ''){
                    $blank = 1;
                }
            }
            if($blank == 1){
                $i = rand() % 8;
                while($box[$i] != ''){
                    $i = rand() % 8;
                }
                $box[$i] = 'o';
            }
        }
        else
            echo "<script type='text/javascript'>alert('É a sua vez de play!');</script>";

        if($box[0] == 'x' && $box[1] == 'x' && $box[2] == 'x' ||
            $box[3] == 'x' && $box[4] == 'x' && $box[5] == 'x' ||
            $box[6] == 'x' && $box[7] == 'x' && $box[8] == 'x' ||
            $box[0] == 'x' && $box[4] == 'x' && $box[8] == 'x' ||
            $box[2] == 'x' && $box[4] == 'x' && $box[6] == 'x' ||
            $box[0] == 'x' && $box[3] == 'x' && $box[6] == 'x' ||
            $box[1] == 'x' && $box[4] == 'x' && $box[7] == 'x' ||
            $box[2] == 'x' && $box[5] == 'x' && $box[8] == 'x'){
            echo "<script type='text/javascript'>alert('Você venceu!');javascript:window.location=php_senas$petId;php_senascript>";
            $campeao = 'x';
            $this->calcscore('Game da gammer', $petId);
        }
        else if($box[0] == 'o' && $box[1] == 'o' && $box[2] == 'o' ||
            $box[3] == 'o' && $box[4] == 'o' && $box[5] == 'o' ||
            $box[6] == 'o' && $box[7] == 'o' && $box[8] == 'o' ||
            $box[0] == 'o' && $box[4] == 'o' && $box[8] == 'o' ||
            $box[2] == 'o' && $box[4] == 'o' && $box[6] == 'o' ||
            $box[0] == 'o' && $box[3] == 'o' && $box[6] == 'o' ||
            $box[1] == 'o' && $box[4] == 'o' && $box[7] == 'o' ||
            $box[2] == 'o' && $box[5] == 'o' && $box[8] == 'o'){
            echo "<script type='text/javascript'>alert('O computador venceu!');javascript:window.location=php_senas$petId;</script>";
    php_senas     $campeao = 'o';
        }
        else if($campeao == 'n' && $jogada >= 8)
            echo "<script type='text/javascript'>alert('Empate!');javascript:window.location='Game-da-gammer.php?idP=$petId';</script>";

   php_senas  return $box;
    }

    public function ranking(){
        ///$id = $_SESSION["id_user"];
        $sql = "SELECT DISTINCT pet.iduser, pet.namePet, minigames.nameMinigame, minigames.score FROM pet, minigames ORDER BY minigames.score DESC";
        $mysql = $this->mysql->prepare($sql);
        $mysql->execute();
        return $mysql->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>