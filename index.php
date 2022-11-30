<?php

use Steampixel\Route;

require_once('config.php');
require_once('class/class.php');

Route::add('/',function () {
        //ten kod wywoła się na głównej stronie
        echo "Strona główna";
});

Route::add('/login', function() {
    echo "Strona logowania";
});

Route::run('/loginForm');
?>