<?php
// Kai useris bando prisijungti
if (isset($_POST["email"], $_POST["password"])) {

// Egzistuojanciu useriu sarasas
    $users = [
        [
            "email" => "mantas",
            "password" => "aldona",
        ],
        [
            "email" => "manazs",
            "password" => "aldonaz",
        ],
        [
            "email" => "alynka",
            "password" => "jabenia",
        ],
    ];
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