<?php
  declare(strict_types = 1);

  class Ticket {
    private int $idTicket;
    private string $title;
    private string $description;
    private int $priority;
    private string $createDate;
    private int $cria;
    private int $resolve;
    private int $idDepartment;
    
    public function __construct(int $idTicket, string $title, string $description, int $priority, string $createDate, int $cria, int $resolve, int $idDepartment) {
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
                intval($ticket['idDepartment']),
            );
        }
        return $tickets;
    }
}
?>