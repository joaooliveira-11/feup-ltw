<?php
  class Session {
    private array $messages;
    private User $user;

    public function __construct() {
      session_start();

      if (!isset($_SESSION['csrf'])) {
        $_SESSION['csrf'] = $this->generate_random_token();
      }

      $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
      unset($_SESSION['messages']);
    }

    public function generate_random_token() {
      return bin2hex(openssl_random_pseudo_bytes(32));
    }
    

    public function isLoggedIn() : bool {
      return isset($_SESSION['id']);    
    }

    public function logout() {
      session_destroy();
    }

    public function getId() : ?int {
      return isset($_SESSION['id']) ? $_SESSION['id'] : null;    
    }

    public function getName() : ?string {
      return isset($_SESSION['name']) ? $_SESSION['name'] : null;
    }

    public function setId(int $id) {
      $_SESSION['id'] = $id;
    }

    public function setUsername(string $username) {
      $_SESSION['username'] = $username;
    }

    public function addMessage(string $type, string $text) {
        $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
        $notificationId = uniqid();
        print_r(array('type' => $type, 'text' => $text));
        echo "<script> let notification = document.createElement('div');
        notification.id = '" . $notificationId . "';
        notification.classList.add('notification', '" . $type . "');
        notification.textContent = '" . $type . " -> " . $text . "';
        document.body.appendChild(notification);
        setTimeout(function() {
            let element = document.getElementById('" . $notificationId . "');
            if (element) {
                element.remove();
            }
        }, 5000); </script>";
    }

    public function getMessages() {
      return $this->messages;
    }

    public function check_tokens(String $tokens) : bool {
      if ($_SESSION['csrf'] !== $tokens) {
          return false;
      }
      return true;
    }
  }
?>