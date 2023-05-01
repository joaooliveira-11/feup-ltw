<?php
declare(strict_types = 1);

class Inquiry
{
    private ?int $idInquiry;
    private int $idUserReceiving;
    private ?int $idUserGiving;
    private int $idTicket;
    private string $type;
    private string $date;

    public function __construct(?int $idInquiry, int $idUserReceiving, ?int $idUserGiving, int $idTicket, string $type, string $date)
    {
        $this->idInquiry = $idInquiry;
        $this->idUserReceiving = $idUserReceiving;
        $this->idUserGiving = $idUserGiving;
        $this->idTicket = $idTicket;
        $this->type = $type;
        $this->date = $date;
    }

    public function getIdInquiry(): int
    {
        return $this->idInquiry;
    }

    public function getUserReceiving(): int
    {
        return $this->idUserReceiving;
    }

    public function getUserGiving(): int
    {
        return $this->idUserGiving;
    }

    public function getTicket(): int
    {
        return $this->idTicket;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public static function getUserInquiries(PDO $db, int $idUser): array
    {
        $stmt = $db->prepare('SELECT * FROM Inquiry WHERE idUserReceiving = ?');
        $stmt->execute(array($idUser));
        $inquiries = array();
        while ($inquiry = $stmt->fetch()) {
            $inquiries[] = new Inquiry(
                intval($inquiry['idInquiry']),
                intval($inquiry['idUserReceiving']),
                intval($inquiry['idUserGiving']),
                intval($inquiry['idTicket']),
                $inquiry['type'],
                $inquiry['date']
            );
        }
        return $inquiries;
    }

    public static function deleteInquiry(PDO $db, int $idInquiry){
        $stmt = $db->prepare('DELETE FROM Inquiry WHERE idInquiry = ?');
        $stmt->execute(array($idInquiry));
    }



}