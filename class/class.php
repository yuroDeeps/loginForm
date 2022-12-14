<?php
class User {
    private int $id;
    private mysqli $db;
    private string $login;
    private string $password;
    private string $firstName;
    private string $lastName;

    public function __construct(string $login, string $password) {
        $this->login = $login;
        $this->password = $password;
        $this->firstName = "";
        $this->lastName = "";
        global $db;
        $this->db = &$db;
    }
    public function __serialize() : array {
        return array(   
                        'id' => $this->id,
                        'login' => $this->login,
                        'password' => $this->password,
                        'firstName' => $this->firstName,
                        'lastName' => $this->lastName,
                    );
    }
    public function __unserialize(array $data) {
        $this->id = $data['id'];
        $this->login = $data['login'];
        $this->password = $data['password'];
        $this->firstName = $data['firstName'];
        $this->lastName = $data['lastName'];
        global $db;
        $this->db = &$db;
    } 
    public function register() : bool {
        $passwordHash = password_hash($this->password, PASSWORD_ARGON2I);
        $query = "INSERT INTO user VALUES (NULL, ?, ?, ?, ?)";
        $preparedQuery = $this->db->prepare($query); 
        $preparedQuery->bind_param('ssss', $this->login, $passwordHash, 
                                            $this->firstName, $this->lastName);
        $result = $preparedQuery->execute();
        return $result;
    }

    public function login() : bool {
        $query = "SELECT * FROM user WHERE login = ? LIMIT 1";
        $preparedQuery = $this->db->prepare($query); 
        $preparedQuery->bind_param('s', $this->login);
        $preparedQuery->execute();
        $result = $preparedQuery->get_result();
        if($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $passwordHash = $row['password'];
            if(password_verify($this->password, $passwordHash)) {
                $this->id = $row['id'];
                $this->firstName = $row['firstName'];
                $this->lastName = $row['lastName'];
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function setFirstName(string $firstName) {
        $this->firstName = $firstName;
    }
    public function setLastName(string $lastName) {
        $this->lastName = $lastName;
    }
    public function getName() : string {
        return $this->firstName . " " . $this->lastName;
    }
    public function save() : bool {
        $q = "UPDATE user SET
                firstName = ?,
                lastName = ?
                WHERE id = ?";
        $preparedQuery = $this->db->prepare($q);
        $preparedQuery->bind_param("ssi", $this->firstName, $this->lastName, $this->id);
        return $preparedQuery->execute();
    }
    public function changePassword(string $newPassword) : bool {
        $this->password_hash = password_hash($newPassword, PASSWORD_ARGON2I);
        $q = "UPDATE user SET
                password = ?
                WHERE id = ?";
        $preparedQuery = $this->db->prepare($q);
        $preparedQuery->bind_param("si", $this->password_hash, $this->id);
        return $preparedQuery->execute();
    }
}

?>