<?php


class Login {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function authenticate($email, $password) {
        try {
            $stmt = $this->pdo->prepare("SELECT id, username, email, password, user_type FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_type'] = $user['user_type'];

                return true;
            } else {
                $_SESSION['message'] = 'Invalid email or password.';
                return false; 
            }
        } catch (PDOException $e) {
            $_SESSION['message'] = 'Error: ' . $e->getMessage();
            return false; 
        }
    }
}
?>
