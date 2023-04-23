<?php
  declare(strict_types = 1);

  class User {
    public int $idUser;
    public string $name;
    public string $username;
    public string $email;
    public string $password;

    public function __construct(int $idUser, string $name, string $username, string $email, string $password)
    {
      $this->idUser = $idUser;
      $this->name = $name;
      $this->username = $username;
      $this->email = $email;
      $this->password = $password;

    }

    public function getName() : string {
        return $this->name;
    }
    public function getUsername() : string {  
        return $this->username;
    }
    public function getEmail() : string {
        return $this->email;
    }
    public function getPassword() : string {// <-errado, acho eu
        return $this->password;
    }
    public function getId() : int{
        return $this->idUser;
    }
      public function setName(string $_name)  {
          $this->name = $_name;
      }
      public function setUsername(string $_username)  {
          $this->username = $_username;
      }
      public function setEmail(string $_email)  {
          $this->email = $_email;
      }
      public function setPassword(string $_password)  {
        $cost = ['cost' => 12];
        $this->password = password_hash($_password, PASSWORD_DEFAULT, $cost);
      }

      function save($db){
          $stmt = $db->prepare('
            UPDATE User SET name = ?, username = ?, email = ?, password = ?
            WHERE idUser = ?
          ');

          $stmt->execute(array($this->name, $this->username, $this->email, $this->password, $this->idUser));
      }

      function getRole($db) : int{
          $stmt = $db->prepare('
            Select idRole From User_Roles WHERE idUser = ?
          ');

          $stmt->execute(array($this->idUser));
          $result = $stmt->fetch();
          return intval($result['idRole']);
      }

    
    static function getUserWithPassword(PDO $db, string $username, string $password) : ?User {

        $stmt = $db->prepare('
        SELECT * FROM User WHERE username = ?
        ');
        $stmt->execute(array(strtolower($username)));
        $user = $stmt->fetch();


        if ($user != false && password_verify($password, $user['password'])) {
            return new User(
                intval($user['idUser']),
                $user['name'],
                $user['username'],
                $user['email'],
                $user['password'],
              );
        } else return null;
    }

    static function getSingleUser(PDO $db, int $id) : User {
      $stmt = $db->prepare('
        SELECT idUser, name,username, email, password
        FROM User 
        WHERE idUser = ?
      ');

      $stmt->execute(array($id));
      $user = $stmt->fetch();
      
      return new User(
        intval($user['idUser']),
        $user['name'],
        $user['username'],
        $user['email'],
        $user['password'],
      );
    }

  
    static function getUsers(PDO $db, int $count) : array {

        $stmt = $db->prepare('SELECT idUser, name,usename, email, password, FROM User LIMIT ?');
        $stmt->execute(array($count));

        $users = array();
        while ($user = $stmt->fetch()) {
        $users[] = new User(
            intval($user['idUser']),
            $user['name'],
            $user['usename'],
            $user['email'],
            $user['password'],
        );
        }
        return $users;
    }

    function getPhoto() : string {

        $default = "/img/profiles/default.png"; // change this from random 1-5
        $attemp = "/img/profiles/profile$this->id.png";
        if (file_exists(dirname(__DIR__).$attemp)) {
          $_SESSION['photo'] = $attemp;
          return $attemp;
        } else return $default;
      } 

  }

?>

