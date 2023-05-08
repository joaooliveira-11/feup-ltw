<?php
  declare(strict_types = 1);

  class Ticket {
    private ?int $idTicket;
    private string $title;
    private string $description;
    private int $priority;
    private string $createDate;
    private int $cria;
    private ?int $resolve;
    private int $idDepartment;
    
    public function __construct(?int $idTicket, string $title, string $description, int $priority, string $createDate, int $cria, ?int $resolve, int $idDepartment) {
        $this->idTicket = $idTicket;
        $this->title = $title;
        $this->description = $description;
        $this->priority = $priority;
        $this->createDate = $createDate;
        $this->cria = $cria;
        $this->resolve = $resolve;
        $this->idDepartment = $idDepartment;
    }
    
    public function getIdTicket(): int {
        return $this->idTicket;
    }
    
    public function getTitle(): string {
        return $this->title;
    }
    
    public function getDescription(): string {
        return $this->description;
    }
    
    public function getPriority(): int {
        return $this->priority;
    }

    public function getCreateDate(): string {
        return $this->createDate;
    }

    public function getCria(): int {
        return $this->cria;
    }

    public function getResolve(): int {
        return $this->resolve;
    }

    public function getidDepartment(): int {
        return $this->idDepartment;
    }

    public static function getTicketFromId(PDO $db, int $idTicket){
        $stmt = $db->prepare('SELECT * FROM Ticket WHERE idTicket = ?');
        $stmt->execute(array($idTicket));
        $ticket = $stmt->fetch();
        return new Ticket(
            intval($ticket['idTicket']),
            $ticket['title'],
            $ticket['description'],
            intval($ticket['priority']),
            $ticket['create_date'],
            intval($ticket['cria']),
            intval($ticket['resolve']),
            intval($ticket['idDepartment'])
        );
    }

    public static function getTickets(PDO $db, int $cria): array {
        $stmt = $db->prepare('SELECT * FROM Ticket WHERE cria = ?');
        $stmt->execute(array($cria));
        
        $tickets = array();
        while ($ticket = $stmt->fetch()) {
            $tickets[] = new Ticket(
                intval($ticket['idTicket']),
                $ticket['title'],
                $ticket['description'],
                intval($ticket['priority']),
                $ticket['create_date'],
                intval($ticket['cria']),
                intval($ticket['resolve']),
                intval($ticket['idDepartment'])
            );
        }
        return $tickets;
    }

    public function getTicketDepartmentName(PDO $db): string {
        $stmt = $db->prepare('SELECT name FROM Department WHERE idDepartment = ?');
        $stmt->execute(array($this->idDepartment));
        $department = $stmt->fetch();
        return $department['name'];
    }

    public function getLastTicketStatus(PDO $db): string {
        $stmt = $db->prepare('SELECT idStatus FROM Ticket_Status WHERE idTicket = ? ORDER BY ROWID DESC LIMIT 1');
        $stmt->execute(array($this->idTicket));
        $status = $stmt->fetch();
        if ($status) {
            $stmt = $db->prepare('SELECT stage FROM Status WHERE idStatus = ?');
            $stmt->execute(array($status['idStatus']));
            $statusName = $stmt->fetch();
            return $statusName['stage'];
        } else {
            return '';
        }
    }
    public static function getDepartmentTickets(PDO $db, array $idDepartments){
        $tickets = array();
        foreach($idDepartments as $id) {
            $stmt = $db->prepare('SELECT * FROM Ticket WHERE idDepartment = ?');
            $stmt->execute(array($id));


            while ($ticket = $stmt->fetch()) {
                $tickets[] = new Ticket(
                    intval($ticket['idTicket']),
                    $ticket['title'],
                    $ticket['description'],
                    intval($ticket['priority']),
                    $ticket['create_date'],
                    intval($ticket['cria']),
                    intval($ticket['resolve']),
                    intval($ticket['idDepartment']),
                );
            }
        }
        return $tickets;
    }
    public static function getAssignedTickets(PDO $db, int $resolve){
        $stmt = $db->prepare('SELECT * FROM Ticket WHERE resolve = ?');
        $stmt->execute(array($resolve));

        $tickets = array();
        while ($ticket = $stmt->fetch()) {
            $tickets[] = new Ticket(
                intval($ticket['idTicket']),
                $ticket['title'],
                $ticket['description'],
                intval($ticket['priority']),
                $ticket['create_date'],
                intval($ticket['cria']),
                intval($ticket['resolve']),
                intval($ticket['idDepartment']),
            );
        }
        return $tickets;
    }

    function insert_ticket($db){
        $stmt = $db->prepare('
          INSERT INTO Ticket(title, description, priority, create_date, cria, resolve, idDepartment) VALUES (?,?,?,?,?,?,?)
        ');

        $stmt->execute(array($this->getTitle(), $this->getDescription(), $this->getPriority(), $this->getCreateDate(), $this->getCria(), NULL, $this->getidDepartment()));
    }

    function searchIfRequestedToAssign(PDO $db){
          $stmt = $db->prepare('SELECT idUserReceiving FROM Inquiry WHERE idTicket = ?');
          $stmt->execute(array($this->idTicket));
          $result = $stmt->fetch();
          return intval($result['idUserReceiving']);
    }

    public function get_status_id(PDO $db, string $status) : int{
        $stmt = $db->prepare('SELECT idStatus FROM Status WHERE stage = ? ');
        $stmt->execute(array($status));
        $result = $stmt->fetch();
        return intval($result['idStatus']);
    }

    public static function possibleChangingStatus(PDO $db, string $status): array {
            $stmt = $db->prepare('SELECT stage FROM Status WHERE stage != ?');
            $stmt->execute(array($status));
            $result = array();
            while($stage = $stmt->fetch()){
                $result[] = $stage['stage'];
            }
            return $result;
    }

    public function change_ticket_status(PDO $db,string $status){
        $idstatus = Ticket::get_status_id($db, $status);
        $date = date('d-m-Y');
        $stmt = $db->prepare('
          INSERT INTO Ticket_Status(idTicket, idStatus, date) VALUES (?,?,?)
        ');

        $stmt->execute(array($this->idTicket, $idstatus, $date));
    }
    

    function get_department_id(PDO $db, string $department) : int{
        $stmt = $db->prepare('SELECT idDepartment FROM Department WHERE name = ? ');
        $stmt->execute(array($department));
        $result = $stmt->fetch();
        return intval($result['idDepartment']);
    }


    function possibleChangingDepartment(PDO $db, string $department): array {
        $stmt = $db->prepare('SELECT name FROM Department WHERE name != ?');
        $stmt->execute(array($department));
        $result = array();
        while($department = $stmt->fetch()){
            $result[] = $department['name'];
        }
        return $result;
    }

    
    function change_ticket_department(PDO $db, string $department){
          $iddepartment = get_department_id($db, $department);
          $stmt = $db->prepare('
            UPDATE Ticket SET title = ?, description = ?, priority = ?, create_date = ?, cria = ?, resolve = ?, idDepartment = ?
            WHERE idTicket = ?
          ');

          $stmt->execute(array($this->title, $this->description, $this->priority, $this->createDate, $this->cria, $this->resolve, $iddepartment , $this->idTicket));
    }
}
?>