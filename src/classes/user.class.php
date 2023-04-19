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
   
    function save($db) {
      $stmt = $db->prepare('
        UPDATE User SET name = ?, username = ?, email = ?, password = ?,
        WHERE idUser = ?
      ');

      $stmt->execute(array($this->idUser, $this->name, $this->username, $this->email, 
                                    $this->password));
    }
    
    static function getUserWithPassword(PDO $db, string $username, string $password) : ?User {

        $stmt = $db->prepare('
        SELECT * FROM User WHERE username = ?
        ');
        $stmt->execute(array($username));
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
        SELECT idUser, name, email, password
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

        $stmt = $db->prepare('SELECT idUser, name, email, password, FROM User LIMIT ?');
        $stmt->execute(array($count));

        $users = array();
        while ($user = $stmt->fetch()) {
        $users[] = new User(
            intval($user['idUser']),
            $user['name'],
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

