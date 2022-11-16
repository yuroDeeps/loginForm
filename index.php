<?php
require('ObjectClass/User.class.php');
echo "<pre>";
$db = new mysqli('localhost', 'root', '', 'login_form');
$user = new User("dwalski","taj3neHasło");
//$user->register();
$user->login();
if($user->isAuth()) {
    echo "Użytkownik zalogowany poprawnie";
} else {
    echo "Błąd logowania";
}
?>