<?php

class Pet{
    protected $mysql;

    protected $db = array(
        'host'=>'localhost',
        'database'=>'virtual-pet-db',
        'user'=>'root',
        'password'=>'',
    );

    public function __construct(){
        $this->conectDB();
    }

    public function showPets(){
        $id = $_SESSION["id_user"];
        $sql = "SELECT * FROM pet WHERE idUser = $id";
        $mysql=$this->mysql->prepare($sql);
        $mysql->execute();
        return $mysql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function retPet($petActual){
        $sql="SELECT * FROM pet WHERE idPet = $petActual";
        $mysql=$this->mysql->prepare($sql);
        $mysql->execute();
        return $mysql->fetch(PDO::FETCH_ASSOC);
    }

    protected function conectDB(){
        $this->mysql = new PDO(
            'mysql:host='.$this->db['host'].';dbname='.$this->db['database'], $this->db['user'], $this->db['password']
        );
        $this->mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function createPet(){
//        session_start();
        $id = $_SESSION["id_user"]??0;
        $src = 'bb';

        error_log($id);
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $sql="INSERT INTO pet (petName, petHappiness, petHunger, petHealth, petSleep, petState, image, age, weight, idUser) VALUES (:petName, 50, 50, 50, 50, 'normal', '$src', 0, 1, :userid)";
            $mysql=$this->mysql->prepare($sql);
            $mysql->bindValue(':petName', $_POST['namePet'],PDO::PARAM_STR);
            $mysql->bindValue(':userid', (int) $id, PDO::PARAM_INT);

            try{
                $mysql->execute();
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }

    public function retIDPet(){
        $query = "SELECT LAST_INSERT_ID()";
        $mysql=$this->mysql->prepare($query);
        $mysql->execute();
        $actual = $mysql->fetchColumn();

        if(!empty($actual))
            return $actual;

    }

    public function deletePet(){
        $idPet = $_SESSION["idPet"];
        error_log('no delete', $_SESSION["idPet"]);
        error_log( $_SESSION["idPet"]);


        if(!empty($idPet)){
            $sql="DELETE FROM `pet` WHERE `idPet` = $idPet";
            $mysql=$this->mysql->prepare($sql);

            try{
                $mysql->execute();

                echo "<script type='text/javascript'>alert('Augintinis sėkmingai pašalintas!');javascript:window.location='member.php';</script>";
            }catch(PDOException $e){
                echo $e->getMessage();
            }

            $minigame = "DELETE FROM minigames WHERE idPet = $idPet";
            $mysql=$this->mysql->prepare($minigame);
            $mysql->execute();
        }
        else{
            echo "<script type='text/javascript'>alert('Nėra jokių augintinių!');javascript:window.location='member.php';</script>";
        }
    }

    public function feed($foodType, $idPet){
        $sql = "SELECT petHunger FROM pet WHERE idPet = $idPet";
        $mysql = $this->mysql->prepare($sql);
        $mysql->execute();
        $hungerOld = $mysql->fetchColumn();

        $kg = "SELECT weight FROM pet WHERE idPet = $idPet";
        $mysql = $this->mysql->prepare($kg);
        $mysql->execute();
        $weight = $mysql->fetchColumn();

        $happy = "SELECT petHappiness FROM pet WHERE idPet = $idPet";
        $mysql = $this->mysql->prepare($happy);
        $mysql->execute();
        $happiness = $mysql->fetchColumn();

        if($foodType == 'Whiskas'){
            if($hungerOld <= 90)
                $hunger = $hungerOld+10;
            else
                $hunger = (100 - $hungerOld) + $hungerOld;
            $weight += 5;
        }
        else if($foodType == 'Mouse'){
            if($hungerOld <= 92)
                $hunger = $hungerOld+8;
            else
                $hunger = (100 - $hungerOld) + $hungerOld;
            $weight += 4;
        }
//        else if($foodType == ''){
//            if($hungerOld <= 95)
//                $hunger = $hungerOld+5;
//            else
//                $hunger = (100 - $hungerOld) + $hungerOld;
//
//            $weight += 3;
//        }
//        else if($foodType == ''){
//            if($hungerOld <= 97)
//                $hunger = $hungerOld+3;
//            else
//                $hunger = (100 - $hungerOld) + $hungerOld;
//
//            $weight += 2;
//        }
        else if($foodType == 'Pedigree'){
            $sick = "SELECT petHealth FROM pet WHERE idPet = $idPet";
            $mysql = $this->mysql->prepare($sick);
            $mysql->execute();
            $sickOld = $mysql->fetchColumn();

            $weight += 1;

            if($hungerOld <= 99)
                $hunger = $hungerOld+1;
            else
                $hunger = (100 - $hungerOld) + $hungerOld;

            if($sickOld >= 10)
                $sickActual = $sickOld-10;
            else
                $sickActual = 0;

            $querySick="UPDATE pet SET petHealth = $sickActual WHERE idPet = $idPet";
            $mysql=$this->mysql->prepare($querySick);
            $mysql->execute();

            if($sickActual <= 30){
                $qSick="UPDATE pet SET petState = 'sick' WHERE idPet = $idPet";
                $mysql=$this->mysql->prepare($qSick);
                $mysql->execute();

            }
        }

        $query="UPDATE pet SET petHunger = $hunger, weight = $weight WHERE idPet = $idPet";
        $mysql=$this->mysql->prepare($query);
        $mysql->execute();

        header('Location: ./member.php');
        $this->controlsGeneral($idPet);
    }

    public function bathing($idPet){
        $sql = "SELECT petState FROM pet WHERE idPet = $idPet";
        $mysql = $this->mysql->prepare($sql);
        $mysql->execute();
        $state = $mysql->fetchColumn();

        $sql = "SELECT petHealth FROM pet WHERE idPet = $idPet";
        $mysql = $this->mysql->prepare($sql);
        $mysql->execute();
        $hp = $mysql->fetchColumn();


        $cons = "SELECT weight FROM pet WHERE idPet = $idPet";
        $mysql = $this->mysql->prepare($cons);
        $mysql->execute();
        $c = $mysql->fetchColumn();

        $newHp = $hp + 5;
        $newC = $c - 2;


        if($state == 'dirty'){
            $query="UPDATE pet SET petState = 'normal', petHealth = $newHp, weight = $newC, petHunger = 99 WHERE idPet = $idPet";
            $mysql=$this->mysql->prepare($query);
            $mysql->execute();
            header('Location: ./member.php');
            $this->controlsGeneral($idPet);
        }
        else{
            echo "<script type='text/javascript'>alert('Ei! Aš jau esu švarus!');javascript:window.location='member.php';</script>";
        }


    }

    public function controlsGeneral($idPet){
        $time = time();
        $Dtime = $time - $_SESSION["time"];

        $sql = "SELECT petState FROM pet WHERE idPet = $idPet";
        $mysql = $this->mysql->prepare($sql);
        $mysql->execute();
        $state= $mysql->fetchColumn();

        $kg = "SELECT weight FROM pet WHERE idPet = $idPet";
        $mysql = $this->mysql->prepare($kg);
        $mysql->execute();
        $weight = $mysql->fetchColumn();

        $hunger = $this->hungry($Dtime, $state, $idPet);
        $happiness = $this->happy($Dtime, $state, $idPet);
        $sleep = $this->sleep($Dtime, $state, $idPet);
        $health = $this->health($Dtime, $state, $idPet);
        $age = $this->age($Dtime, $idPet);

        if($hunger < 0)
            $hunger = 0;

        if($happiness < 0)
            $happiness = 0;
        else if($happiness > 100)
            $happiness = 100;

        if($sleep > 100)
            $sleep = 100;
        else if($sleep < 0)
            $sleep = 0;

        if($health < 0)
            $health = 0;
        else if($health > 100)
            $health = 100;

        $state = 'normal';
        $src = 'cat-normal.gif';

        if ($hunger <= 49){
            $state = 'hunger';
            $src = 'cat-hungry.gif';
        }
        if($hunger >= 100){
            $state = 'dirty';
            $src = 'bb-dirty.gif';
            $hunger = 100;
        }
        if($happiness <= 30){
            $state = 'sad';
            $src = 'cat-sad.gif';
        }
        else if(($happiness > 50) && ($hunger >= 70) && ($sleep >= 70) && ($health >= 70)){
            $state = 'happy';
            $src = 'cat-happy.gif';
        }
        if ($sleep <= 49){
            $state = 'tired';
            $src = 'cat-sad.gif';
        }
        if ($health <= 30 && $health > 0){
            $state = 'sick';
            $src = 'cat-sick.gif';
        }
        if($health <= 0){
            $health = 0;
            $state = 'dead';
        }
        if($state == 'dirty'){
            $state = 'dirty';
            $src = 'dirty-big.gif';
        }
        if($state == 'sleeping'){
            $state = 'sleeping';
            $src = 'cat-sleeping.gif';
        }

        $queryState="UPDATE pet SET petHealth = $health, petHappiness = $happiness, petHunger = $hunger, petSleep = $sleep, petState = '$state', age = $age WHERE idPet = $idPet";
        $mysql=$this->mysql->prepare($queryState);
        $mysql->execute();
        if($age >= 4){
            $appearance = "UPDATE pet SET image = '$src' WHERE idPet = $idPet";
            $mysql=$this->mysql->prepare($appearance);
            $mysql->execute();
        }
        else{
            if($state == 'sleeping'){
                $appearance = "UPDATE pet SET image = 'bb-sleep.gif' WHERE idPet = $idPet";
                $mysql=$this->mysql->prepare($appearance);
                $mysql->execute();
            }
            else if($state == 'dirty'){
                $appearance = "UPDATE pet SET image = 'bb-dirty.gif' WHERE idPet = $idPet";
                $mysql=$this->mysql->prepare($appearance);
                $mysql->execute();
            }
            else{
                $appearance = "UPDATE pet SET image = 'bb.gif' WHERE idPet = $idPet";
                $mysql=$this->mysql->prepare($appearance);
                $mysql->execute();
            }
        }

        $_SESSION["time"] = time();
    }

    public function restartPet($idPet){
        $sql = "SELECT petState FROM pet WHERE idPet = $idPet";
        $mysql = $this->mysql->prepare($sql);
        $mysql->execute();
        $state= $mysql->fetchColumn();

        if($state == 'dead'){
            $queryNew="UPDATE pet, minigames SET pet.petHealth = 50, pet.petHappiness = 50, pet.petHunger = 50, pet.petSleep = 50, petState = 'normal', pet.age = 0, pet.weight = 1, pet.image = 'bb.gif', minigames.score = 0 WHERE pet.idPet = $idPet AND minigames.idPet = $idPet AND minigames.nameMinigame = 'Kryziukai Nuliukai'";
            $mysql=$this->mysql->prepare($queryNew);
            $mysql->execute();
            echo "<script type='text/javascript'>alert('Deja Tavo augintinis numirė! Netrukus jis bus sukurtas iš naujo, o žaidimo rezultatai atstatyti į pradinius!');javascript:window.location='member.php';</script>";
        }
    }

    public function age($Dtime, $idPet){
        $age = "SELECT age FROM pet WHERE idPet = $idPet";
        $mysql = $this->mysql->prepare($age);
        $mysql->execute();
        $age = $mysql->fetchColumn();

        $state = "SELECT petState FROM pet WHERE idPet = $idPet";
        $mysql = $this->mysql->prepare($state);
        $mysql->execute();
        $status = $mysql->fetchColumn();

        $id = $Dtime/600;
        $age = $age + $id;

        if($age >= 8)
            $age = 8;


        return $age;
    }

    public function hungry($Dtime, $state, $idPet){
        $sql = "SELECT petHunger FROM pet WHERE idPet = $idPet";
        $mysql = $this->mysql->prepare($sql);
        $mysql->execute();
        $hunger= $mysql->fetchColumn();

        if ($state == 'normal' || $state == 'sad' || $state == 'sick'){
            $hunger = $Dtime/120;
        }
        if ($state == 'happy'){
            $hunger = $Dtime/180;
        }
        if ($state == 'tired' || $state == 'dirty' || $state == 'sleeping'){
            $hunger = $Dtime/100;
        }
        if ($state == 'hunger'){
            $hunger = $Dtime/60;
        }
        if($state == 'dead')
            $hunger = 0;

        $hunger = $hunger - $hunger;
        return $hunger;
    }

    public function happy($Dtime, $state, $idPet){
        $sql = "SELECT petHappiness FROM pet WHERE idPet = $idPet";
        $mysql = $this->mysql->prepare($sql);
        $mysql->execute();
        $happy= $mysql->fetchColumn();

        if ($state == 'normal' || $state == 'dirty'){
            $happiness = $Dtime/180;
        }
        if ($state == 'happy'){
            $happiness = $Dtime/250;
        }
        if ($state == 'tired' || $state == 'sleeping'){
            $happiness = $Dtime/100;
        }
        if ($state == 'sad'){
            $happiness = $Dtime/60;
        }
        if ($state == 'hunger'){
            $happiness = $Dtime/80;
        }
        if ($state == 'sick'){
            $happiness = $Dtime/80;
        }
        if($state == 'dead')
            $happiness = 0;

        if($state == 'sleeping')
            $happy = $happy + $happiness;
        else
            $happy = $happy - $happiness;

        return $happy;
    }

    public function sleep($Dtime, $state, $idPet){
        $sql = "SELECT petSleep FROM pet WHERE idPet = $idPet";
        $mysql = $this->mysql->prepare($sql);
        $mysql->execute();
        $sleep= $mysql->fetchColumn();

        if ($state == 'normal' || $state == 'dirty'){
            $sleep = $Dtime/250;
        }
        if ($state == 'happy'){
            $sleep = $Dtime/300;
        }
        if ($state == 'tired' || $state == 'sleeping'){
            $sleep = $Dtime/60;
        }
        if ($state == 'sad'){
            $sleep = $Dtime/100;
        }
        if ($state == 'hunger'){
            $sleep = $Dtime/80;
        }
        if ($state == 'sick'){
            $sleep = $Dtime/70;
        }
        if($state == 'dead')
            $sleep = 0;

        if($state == 'sleeping')
            $sleep = $sleep + $sleep;
        else
            $sleep = $sleep - $sleep;

        return $sleep;
    }

    public function health($Dtime, $state, $idPet){
        $sql = "SELECT petHealth FROM pet WHERE idPet = $idPet";
        $mysql = $this->mysql->prepare($sql);
        $mysql->execute();
        $health= $mysql->fetchColumn();

        if ($state == 'normal' || $state == 'dirty'){
            $health = $Dtime/250;
        }
        if ($state == 'happy'){
            $health = $Dtime/300;
        }
        if ($state == 'tired'){
            $health = $Dtime/60;
        }
        if ($state == 'sad'){
            $health = $Dtime/180;
        }
        if ($state == 'hunger'){
            $health = $Dtime/100;
        }
        if ($state == 'sick'  || $state == 'sleeping'){
            $health = $Dtime/60;
        }
        if($state == 'dead')
            $health = 0;

        if($state == 'sleeping')
            $health = $health + $health;
        else
            $health = $health - $health;

        return $health;
    }

    public function cure($idPet){
        $sick = "SELECT petHealth FROM pet WHERE idPet = $idPet";
        $mysql = $this->mysql->prepare($sick);
        $mysql->execute();
        $statusSick = $mysql->fetchColumn();

        $sql = "SELECT petState FROM pet WHERE idPet = $idPet";
        $mysql = $this->mysql->prepare($sql);
        $mysql->execute();
        $state = $mysql->fetchColumn();

        if($statusSick <= 30){
            $newHealth = $statusSick + 10;
            if($newHealth > 30){
                $newStatus = 'normal';
            }

        }
        else if($state != 'sick'){
            $newHealth = 30;
            $newStatus = 'sick';
        }
        else{
            $newHealth = $statusSick;
            $newStatus = $state;
        }

        $queryHealth="UPDATE pet SET petHealth = $newHealth, petState = '$newStatus' WHERE idPet = $idPet";
        $mysql=$this->mysql->prepare($queryHealth);
        $mysql->execute();

        header('Location: ./member.php');
        $this->controlsGeneral($idPet);


    }

    public function timeToSleep($idPet){
        $sql = "SELECT petState FROM pet WHERE idPet = $idPet";
        $mysql = $this->mysql->prepare($sql);
        $mysql->execute();
        $state = $mysql->fetchColumn();

        $cans = "SELECT petSleep FROM pet WHERE idPet = $idPet";
        $mysql = $this->mysql->prepare($cans);
        $mysql->execute();
        $sleep = $mysql->fetchColumn();

        $query="UPDATE pet SET petState = 'sleeping' WHERE idPet = $idPet";
        $mysql=$this->mysql->prepare($query);
        $mysql->execute();

        if($state == 'sleeping'){
            if($sleep >= 50){
                $query="UPDATE pet SET petState = 'normal' WHERE idPet = $idPet";
                $mysql=$this->mysql->prepare($query);
                $mysql->execute();
            }
            else{
                $query="UPDATE pet SET petState = 'tired' WHERE idPet = $idPet";
                $mysql=$this->mysql->prepare($query);
                $mysql->execute();
            }
        }
        header('Location: ./member.php');
        $this->controlsGeneral($idPet);
    }

}
?>

