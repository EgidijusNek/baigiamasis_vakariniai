<?php

// jei sesija neegzistuoja tai pradedam
if (!isset($_SESSION))
{
    session_start();
}
// jei atsilogina tai sunaikinam sesija
if (isset($_GET,$_GET["logout"])){
    session_unset();


    session_destroy();
}