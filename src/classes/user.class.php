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

      function getUserRole($db) : int{
          $stmt = $db->prepare('Select idRole From User_Roles WHERE idUser = ? ORDER BY ROWID DESC LIMIT 1');
          $stmt->execute(array($this->idUser));
          $role = $stmt->fetch();
          return intval($role['idRole']);
      }


      function getRoleName($db, int $role) : string{
          $stmt = $db->prepare('SELECT name FROM Role WHERE idRole = ?');
          $stmt->execute(array($role));
          $rolename = $stmt->fetch();
          return $rolename['name'];
      }

      function getDepartments($db) {
          $stmt = $db->prepare('
            Select idDepartment From User_Departments WHERE idUser = ?
          ');

          $stmt->execute(array($this->idUser));
          $result = array();

          while ($idDepartment = $stmt->fetch()){
              $result[] = $idDepartment['idDepartment'];
          }
          return $result;

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

    static function getUsersFromDepartment(PDO $db, $idDepartment){
        $stmt = $db->prepare('
            SELECT User.idUser, User.name, User.username, User.email, User.password, COUNT(Ticket.idTicket) as ticket_count
            FROM User
            INNER JOIN User_Departments ON User.idUser = User_Departments.idUser
            LEFT JOIN Ticket ON User.idUser = Ticket.resolve
            WHERE User_Departments.idDepartment = ?
            GROUP BY User.idUser, User.name, User.username, User.email, User.password
            ORDER BY ticket_count
          ');
        $stmt->execute(array($idDepartment));

        $users = array();
        while ($user = $stmt->fetch()) {
            $users[] = array($user['name'],$user['ticket_count'], $user['idUser']);
        }
        return $users;
    }
      static function getDepartmentName(PDO $db, $idDepartment){
          $stmt = $db->prepare('
            SELECT name FROM Department WHERE idDepartment = ?
          ');
          $stmt->execute(array($idDepartment));
          return $stmt->fetch();
      }

  
    static function getUsers(PDO $db, int $count) : array {

        $stmt = $db->prepare('SELECT idUser, name,username, email, password, FROM User LIMIT ?');
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

