<?php
/**
 * Created by PhpStorm.
 * User: egidi
 * Date: 2019-04-27
 * Time: 22:34
 */

class Pet
{
protected $mysql;
protected $db = array(
    'host'=>'localhost',
    'database'=>'virtual_pet_db',
    'user'=>'root',
    'password'=>'',
);
public function __construct()
{
    $this->connectDB();
}

public function listPets(){
    $id = $_SESSION["user_id"];
    $sql ="SELECT * FROM pet WHERE UserId = $id";
    $mysql =$this->mysql->prepare($sql);
    $mysql->execute();
    return $mysql->fetchAll(PDO::FETCH_ASSOC);
}
public function showPet($mainPet){
    $sql ="SELECT * FROM pet WHERE  = $mainPet";
    $mysql=$this->mysql->prepare($sql);
    $mysql->execute();
    return $mysql->fetch(PDO::FETCH_ASSOC);
}
protected function connectDB(){
    $this->mysql = new PDO(
        'mysql:host='.$this->db['host'].'dbname='.$this->db['database'],$this->db['user'],$this->db['password']
    );
    $this->mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
public function createPet(){
    session_start();
    $id =$_SESSION["user_id"];
    $src ='bb';
    error_log($id);
    if ($_SERVER['REQUEST_METHOD']=='POST'){
        $sql="INSERT INTO pet(petName, petHappiness, petHunger, petHealth, petSleep, petState, image, age, weight, userId) VALUES (':petName', 50, 50, 50, 50, 'normal', '$src', 0, 1, '$id' )";
        $mysql=$this->mysql->prepare($sql);
        $mysql->bindValue(':petName', $_POST['petName'],
        PDO::PARAM_STR);
        try{
            $mysql->execute();
        }catch (PDOException $e){
            echo $e->getMessage();
        }
    }
}
public function get(){
    $query ="SELECT LAST_INSERT_ID()";
    $mysql=$this->mysql->prepare($query);
    $mysql->execute();
    $actual =$mysql->fetchColumn();

    if (!empty($actual))
        return $actual;
}
public function deletePet(){
    $ = $_SESSION[""];
    error_log('no delete', $_SESSION[$]);
    error_log($_SESSION[""]);
}
//tesinys žemiau
if(!empty($petId)){

$sql="DELETE FROM `pet` WHERE `` = $";
$mysql=$this->mysql->prepare($sql);

try{
$mysql->execute();

echo "<script type='text/javascript'>alert('Jūsų augiintinis sėkmingai pašalintas!');javascript:window.location='listagem-pet.php_senas';</script>";
}catch(PDOException $e){
    echo $e->getMessage();
}

                            $minigame = "DELETE FROM minigames WHERE petId = $petId";
                            $mysql=$this->mysql->prepare($minigame);
                            $mysql->execute();
                    //}
                }
                else{
    echo "<script type='text/javascript'>alert('Nėra augintinių, kuriuos būtu galima pašalinti!');javascript:window.location='listagem-pet.php_senas';</script>";
}
            //}
        }

        public function food($foodType, $petId){
    $sql = "SELECT petHungry FROM pet WHERE petId = $petId";
    $mysql = $this->mysql->prepare($sql);
    $mysql->execute();
    $timeHunger = $mysql->fetchColumn();

    $kg = "SELECT weight FROM pet WHERE petId = $petId";
    $mysql = $this->mysql->prepare($kg);
    $mysql->execute();
    $weight = $mysql->fetchColumn();

    $happy = "SELECT petHappiness FROM pet WHERE petId = $petId";
    $mysql = $this->mysql->prepare($happy);
    $mysql->execute();
    $happiness = $mysql->fetchColumn();

    if($foodType == 'Bunny'){
        if($timeHunger <= 90)
            $time = $timeHunger+10;
        else
            $time = (100 - $timeHunger) + $timeHunger;
        $weight += 5;
    }
    else if($foodType == 'Rat'){
        if($timeHunger <= 92)
            $time = $timeHunger+8;
        else
            $time = (100 - $timeHunger) + $timeHunger;
        $weight += 4;
    }
    else if($foodType == 'Bird'){
        if($timeHunger <= 95)
            $time = $timeHunger+5;
        else
            $time = (100 - $timeHunger) + $timeHunger;

        $weight += 3;
    }
    else if($foodType == 'Fruit'){
        if($timeHunger <= 97)
            $time = $timeHunger+3;
        else
            $time = (100 - $timeHunger) + $timeHunger;

        $weight += 2;
    }
    else if($foodType == 'Bug'){

        $sick = "SELECT petHealth FROM pet WHERE petId = $petId";
        $mysql = $this->mysql->prepare($sick);
        $mysql->execute();
        $sickTime = $mysql->fetchColumn();

        $weight += 1;

        if($timeHunger <= 99)
            $time = $timeHunger+1;
        else
            $time = (100 - $timeHunger) + $timeHunger;

        if($sickTime >= 10)
            $sickActual = $sickTime-10;
        else
            $sickActual = 0;

        $querySickness="UPDATE pet SET petHealth = $sickActual WHERE petId = $petId";
        $mysql=$this->mysql->prepare($querySickness);
        $mysql->execute();

        if($sickActual <= 30){
            $qSickness="UPDATE pet SET petState = 'Sickness' WHERE petId = $petId";
            $mysql=$this->mysql->prepare($qSickness);
            $mysql->execute();

        }
    }

    $query="UPDATE pet SET petHunger = $time, weight = $weight WHERE petId = $petId";
    $mysql=$this->mysql->prepare($query);
    $mysql->execute();

//Čia pakeisti
    header('Location: ./listagem-pet.php_senas');
    $this->mainControls($petId);
}

        public function bath($petId){
    $sql = "SELECT petState FROM pet WHERE petId = $petId";
    $mysql = $this->mysql->prepare($sql);
    $mysql->execute();
    $status = $mysql->fetchColumn();

    $sql = "SELECT petHealth FROM pet WHERE petId = $petId";
    $mysql = $this->mysql->prepare($sql);
    $mysql->execute();
    $hp = $mysql->fetchColumn();


    $cons = "SELECT weight FROM pet WHERE petId = $petId";
    $mysql = $this->mysql->prepare($cons);
    $mysql->execute();
    $c = $mysql->fetchColumn();

    $newHp = $hp + 5;
    $newC = $c - 2;


    if($status == 'dirty'){
        $query="UPDATE pet SET petState = 'normal', petHealth = $newHp, weight = $newC, petHunger = 99 WHERE petId = $petId";
        $mysql=$this->mysql->prepare($query);
        $mysql->execute();
        header('Location: ./listagem-pet.php_senas');
        $this->mainControls($petId);
    }
    else{
        echo "<script type='text/javascript'>alert('Ei! Aš jau esu švarus!');javascript:window.location='listagem-pet.php_senas';</script>";
    }


}

        public function mainControls($petId){
    $times = time();
    $Dtime = $times - $_SESSION["time"];

    $sql = "SELECT petState FROM pet WHERE petId = $petId";
    $mysql = $this->mysql->prepare($sql);
    $mysql->execute();
    $state= $mysql->fetchColumn();

    $kg = "SELECT weight FROM pet WHERE petId = $petId";
    $mysql = $this->mysql->prepare($kg);
    $mysql->execute();
    $weight = $mysql->fetchColumn();

    $time = $this->hungry($Dtime, $state, $petId);
    $happiness = $this->happy($Dtime, $state, $petId);
    $sleep = $this->sleep($Dtime, $state, $petId);
    $health = $this->health($Dtime, $state, $petId);
    $age = $this->age($Dtime, $petId);

    if($time < 0)
        $time = 0;

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

    $status = 'normal';
    $src = 'tails-normal.gif';

    if ($time <= 49){
        $status = 'hungry';
        $src = 'tails-bravo.gif';
    }
    if($time >= 100){
        $status = 'dirty';
        $src = 'tails-dirty-grande.gif';
        $time = 100;
    }
    if($happiness <= 30){
        $status = 'sad';
        $src = 'tails-sad.gif';
    }
    else if(($happiness > 50) && ($time >= 70) && ($sleep >= 70) && ($health >= 70)){
        $status = 'happy';
        $src = 'tails-happy.gif';
    }
    if ($sleep <= 49){
        $status = 'tired';
        $src = 'tails-sad.gif';
    }
    if ($health <= 30 && $health > 0){
        $status = 'sick';
        $src = 'tails-Sickness.gif';
    }
    if($health <= 0){
        $health = 0;
        $status = 'dead';
    }
    if($state == 'dirty'){
        $status = 'dirty';
        $src = 'tails-dirty-grande.gif';
    }
    if($state == 'sleeping'){
        $status = 'sleeping';
        $src = 'tails-sleep.gif';
    }

    $queryState="UPDATE pet SET petHealth = $health, petHappiness = $happiness, petHunger = $time, petSleep = $sleep, petState = '$status', age = $age WHERE petId = $petId";
    $mysql=$this->mysql->prepare($queryState);
    $mysql->execute();
    if($age >= 4){
        $appearance = "UPDATE pet SET image = '$src' WHERE petId = $petId";
        $mysql=$this->mysql->prepare($appearance);
        $mysql->execute();
    }
    else{
        if($status == 'sleeping'){
            $appearance = "UPDATE pet SET image = 'bb-sleep.gif' WHERE petId = $petId";
            $mysql=$this->mysql->prepare($appearance);
            $mysql->execute();
        }
        else if($status == 'dirty'){
            $appearance = "UPDATE pet SET image = 'bb-dirty.gif' WHERE petId = $petId";
            $mysql=$this->mysql->prepare($appearance);
            $mysql->execute();
        }
        else{
            $appearance = "UPDATE pet SET image = 'bb.gif' WHERE petId = $petId";
            $mysql=$this->mysql->prepare($appearance);
            $mysql->execute();
        }
    }

    $_SESSION["times"] = time();

}

        public function rebootPet($petId){
    $sql = "SELECT petState FROM pet WHERE petId = $petId";
    $mysql = $this->mysql->prepare($sql);
    $mysql->execute();
    $state= $mysql->fetchColumn();

    if($state == 'dead'){
        $querynew="UPDATE pet, minigames SET pet.petHealth = 50, pet.petHappiness = 50, pet.petHunger = 50, pet.petSleep = 50, petState = 'normal', pet.age = 0, pet.weight = 1, pet.image = 'bb.gif', minigames.score = 0 WHERE pet.petId = $petId AND minigames.petId = $petId AND minigames.nameMinigame = 'Akmuo - Popierius - Žirklės' OR minigames.nameMinigame = 'Kryžiukai - Nuliukai'";
        $mysql=$this->mysql->prepare($querynew);
        $mysql->execute();
        echo "<script type='text/javascript'>alert('Deja Jūsų augintinis numirė! Žaidimas bus paleistas iš naujo!');javascript:window.location=php_senas;</scphp_senast>";
    }
}

        public function age($Dtime, $petId){
    $age = "SELECT age FROM pet WHERE petId = $petId";
    $mysql = $this->mysql->prepare($age);
    $mysql->execute();
    $age = $mysql->fetchColumn();

    $state = "SELECT petState FROM pet WHERE petId = $petId";
    $mysql = $this->mysql->prepare($state);
    $mysql->execute();
    $status = $mysql->fetchColumn();

    $id = $Dtime/600;
    $age = $age + $id;

    if($age >= 8)
        $age = 8;

    return $age;
}

        public function hungry($Dtime, $state, $petId){
    $sql = "SELECT petHunger FROM pet WHERE petId = $petId";
    $mysql = $this->mysql->prepare($sql);
    $mysql->execute();
    $hunger= $mysql->fetchColumn();

    if ($state == 'normal' || $state == 'sad' || $state == 'Sickness'){
        $time = $Dtime/120;
    }
    if ($state == 'happy'){
        $time = $Dtime/180;
    }
    if ($state == 'tired' || $state == 'dirty' || $state == 'sleeping'){
        $time = $Dtime/100;
    }
    if ($state == 'hungry'){
        $time = $Dtime/60;
    }
    if($state == 'dead')
        $time = 0;

    $hunger = $hunger - $time;
    return $hunger;
}

        public function happy($Dtime, $state, $petId){
    $sql = "SELECT petHappiness FROM pet WHERE petId = $petId";
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
    if ($state == 'hungry'){
        $happiness = $Dtime/80;
    }
    if ($state == 'Sickness'){
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

        public function sleep($Dtime, $state, $petId){
    $sql = "SELECT petSleep FROM pet WHERE petId = $petId";
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
    if ($state == 'hungry'){
        $sleep = $Dtime/80;
    }
    if ($state == 'Sickness'){
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

        public function health($Dtime, $state, $petId){
    $sql = "SELECT petHealth FROM pet WHERE petId = $petId";
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
    if ($state == 'hungry'){
        $health = $Dtime/100;
    }
    if ($state == 'Sickness'  || $state == 'sleeping'){
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

        public function cure($petId){
    $sick = "SELECT petHealth FROM pet WHERE petId = $petId";
    $mysql = $this->mysql->prepare($sick);
    $mysql->execute();
    $statusSickness = $mysql->fetchColumn();

    $sql = "SELECT petState FROM pet WHERE petId = $petId";
    $mysql = $this->mysql->prepare($sql);
    $mysql->execute();
    $status = $mysql->fetchColumn();

    if($statusSickness <= 30){
        $newHealth = $statusSickness + 10;
        if($newHealth > 30){
            $newStatus = 'normal';
        }

    }
    else if($status != 'Sickness'){
        $newHealth = 30;
        $newStatus = 'Sickness';
    }
    else{
        $newHealth = $statusSickness;
        $newStatus = $status;
    }

    $queryHealth="UPDATE pet SET petHealth = $newHealth, petState = '$newStatus' WHERE petId = $petId";
    $mysql=$this->mysql->prepare($queryHealth);
    $mysql->execute();

    header('Location: ./listagem-pet.php');
  php_senasthis->mainControls($petId);


}

        public function goToSleep($petId){
    $sql = "SELECT petState FROM pet WHERE petId = $petId";
    $mysql = $this->mysql->prepare($sql);
    $mysql->execute();
    $status = $mysql->fetchColumn();

    $cans = "SELECT petSleep FROM pet WHERE petId = $petId";
    $mysql = $this->mysql->prepare($cans);
    $mysql->execute();
    $sleep = $mysql->fetchColumn();

    $query="UPDATE pet SET petState = 'sleeping' WHERE petId = $petId";
    $mysql=$this->mysql->prepare($query);
    $mysql->execute();

    if($status == 'sleeping'){
        if($sleep >= 50){
            $query="UPDATE pet SET petState = 'normal' WHERE petId = $petId";
            $mysql=$this->mysql->prepare($query);
            $mysql->execute();
        }
        else{
            $query="UPDATE pet SET petState = 'tired' WHERE petId = $petId";
            $mysql=$this->mysql->prepare($query);
            $mysql->execute();
        }
    }

    header('Location: ./listagem-pet.php');
  php_senasthis->mainControls($petId);
}

?>






































































