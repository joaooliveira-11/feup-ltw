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
    
    public function getIdTicket(): ?int {
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

    public function getResolve(): ?int {
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

    public static function getDepartmentTickets(PDO $db, array $idDepartments, int $idUser){
        $tickets = array();
        foreach($idDepartments as $id) {
            $stmt = $db->prepare('SELECT * FROM Ticket WHERE idDepartment = ?');
            $stmt->execute(array($id));


            while ($ticket = $stmt->fetch()) {
                if(intval($ticket['cria'])!==$idUser && intval($ticket['resolve']!==$idUser)) {
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

    function getTicketHashtags(PDO $db): array {
        $stmt = $db->prepare('SELECT h.idHashtag, h.name FROM Ticket_Hashtags th JOIN Hashtag h ON th.idHashtag = h.idHashtag WHERE th.idTicket = ?');
        $stmt->execute(array($this->idTicket));
        $hashtags = array();
        while ($hashtag = $stmt->fetch()) {
            $hashtags[] = array(
                'id' => intval($hashtag['idHashtag']),
                'name' => $hashtag['name']
            );
        }
        return $hashtags;
    }
    

    public function get_status_id(PDO $db, string $status) : int{
        $stmt = $db->prepare('SELECT idStatus FROM Status WHERE stage = ? ');
        $stmt->execute(array($status));
        $result = $stmt->fetch();
        return intval($result['idStatus']);
    }

    public static function get_status_name(PDO $db, int $status) : string{
        $stmt = $db->prepare('SELECT stage FROM Status WHERE idStatus = ? ');
        $stmt->execute(array($status));
        $result = $stmt->fetch();
        return $result['stage'];
    }

    public static function get_department_name(PDO $db, int $department) : string{
        $stmt = $db->prepare('SELECT name FROM Department WHERE idDepartment = ? ');
        $stmt->execute(array($department));
        $result = $stmt->fetch();
        return $result['name'];
    }

    public static function get_department_from_id(PDO $db, int $department){
        $stmt = $db->prepare('SELECT * FROM Department WHERE idDepartment = ? ');
        $stmt->execute(array($department));
        $result = $stmt->fetch();
        return $result;
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
        if($status === 'OPEN') $idResolve = NULL;
        else $idResolve = $this->resolve;
        $stmt = $db->prepare('
          INSERT INTO Ticket_Status(idTicket, idStatus, idDepartment, agent, date) VALUES (?,?,?,?,?)
        ');
        $stmt->execute(array($this->idTicket, $idstatus, $this->idDepartment, $idResolve, $date));
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
          $iddepartment = Ticket::get_department_id($db, $department);
          $stmt = $db->prepare('
            UPDATE Ticket SET title = ?, description = ?, priority = ?, create_date = ?, cria = ?, resolve = ?, idDepartment = ?
            WHERE idTicket = ?
          ');

          $stmt->execute(array($this->title, $this->description, $this->priority, $this->createDate, $this->cria, NULL, $iddepartment , $this->idTicket));

          $idstatus = 1;
          $date = date('d-m-Y');
          $stmt = $db->prepare('
           INSERT INTO Ticket_Status(idTicket, idStatus, idDepartment, agent, date) VALUES (?,?,?,?,?)
          ');

          $stmt->execute(array($this->idTicket, $idstatus,$iddepartment, NULL,$date));
    }

    public function getTicketHistory(PDO $db): array{
        $stmt = $db->prepare('SELECT * FROM Ticket_Status WHERE idTicket = ? ORDER BY id_random DESC');
        $stmt->execute(array($this->idTicket));
        $changes = array();
        while ($change= $stmt->fetch()) {
            $changes[] = $change;
        }
        return $changes;
    }

    public function getLastReplyFromTicket(PDO $db, $idUser){
        $stmt = $db->prepare('SELECT message FROM Reply WHERE idTicket = ? AND idUser = ? ORDER BY ROWID DESC LIMIT 1');
        $stmt->execute(array($this->idTicket, $idUser));
        $reply = $stmt->fetchColumn();
        return $reply;
    }

    public function getTicketReceiver(PDO $db, int $idUser){
        $stmt = $db->prepare('SELECT cria,resolve FROM Ticket WHERE idTicket = ? ');
        $stmt->execute(array($this->idTicket));
        $users = $stmt->fetch();
        if (intval($users['cria']) === $idUser) return intval($users['resolve']);
        else return intval($users['cria']);
    }

    public function getAllLastReplyFromTicket(PDO $db){
        $stmt = $db->prepare('SELECT r.message, u.username, r.create_date, r.idTicket, r.idUser FROM Reply r JOIN User u ON r.idUser = u.idUser WHERE r.idTicket = ? ORDER BY r.ROWID DESC LIMIT 1');
        $stmt->execute(array($this->idTicket));
        $reply = $stmt->fetch(PDO::FETCH_ASSOC);
        return $reply;
    }

}
?>