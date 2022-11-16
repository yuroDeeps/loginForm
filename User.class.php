<?php
class User {
    private $db;
    private int $id;
    private string $login;
    private string $passwordHash;
    private string $firstName;
    private string $lastName;

    public function __construct(string $login, string $password) {
        $this->login = $login;
        $this->password_hash = password_hash($password, PASSWORD_ARGON2I);
        global $db;
        $this->db = &$db;
    }

    public function isAUth() : bool {

    }
    public function login() {

    }
    public function logout() {

    }

    public function register() {

    }
}
?>