<?php
// Kai useris bando prisijungti
if (isset($_POST["email"], $_POST["password"])) {

// Egzistuojanciu useriu sarasas
    $users = getUsers();
// Pasiemi reiksmes is log in formos
    $email = $_POST["email"];
    $password = $_POST["password"];
// Tikrinimo ciklas

    foreach ($users as $user){
        // Tikrina ar egzistuoja toks useris su tokiu slaptazodziu
        if ($user["email"] === $email && $user["password"] === $password) {
            // Jei egzistuoja iraso i  sesija
            $_SESSION["user"] = $email;
        }
    }
// Jei neegzistuoja
    if (!isset($_SESSION["user"])) {
        echo "Neteisingi prisijungimo duomenys";
    }

}

function getUsers(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "baigiamasis";

// Prisijungiam prie db
    $conn = new mysqli($servername, $username, $password, $dbname);
    //Vartotoju surinkimo uzklausa
    $sql = "SELECT * FROM users";
    //ivykdom uzklausa duombazei
    $result = $conn->query($sql);
// sukuriam tuscia rezultatu masyva
    $users = [];
//gaunam visu vartotoju sarasa (uzklausos rezultatas)
    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

   //atsijungiam nuo duombazes
   $conn->close();
//grazinam istraukta vartotoju sarasa
   return $users;
}