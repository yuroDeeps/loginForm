<?php
class User {
    private $db;
    private int $id;
    private string $login;
    private string $password;
    private string $firstName;
    private string $lastName;

    public function __construct(string $login, string $password) {
        $this->login = $login;
        $this->password = $password;
        global $db;
        $this->db = &$db;
    }

    public function isAUth() : bool {
        if((isset($this->id)) && $this->id != null) {
            return true;
        } else {
            return false;
        }
    }
    public function login() {
        $q = "SELECT * FROM user WHERE login = ?";
        $preparedQuery = $this->db->prepare($q);
        $preparedQuery->bind_param('s', $this->login);
        $preparedQuery->execute();
        $result = $preparedQuery->get_result();
    }
    public function logout() {

    }

    public function register() {

    }
}
?>