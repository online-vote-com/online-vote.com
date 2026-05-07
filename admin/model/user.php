<?php 
class User {
    private $id_user;
    private $nom_user;
    private $prenom_user;
    private $email;
    private $photo_user;
    private $pwd;
    private $email_token;
    private $numTel;
    private $role_user;
    private $status_user;
    private $email_verifie;
    private $date_creation;
    private $date_modification;

    public function __construct(
        $nom_user,
        $email,
        $pwd,
        $prenom_user = null,
        $numTel = null,
        $photo_user = null
    ) {
        $this->nom_user = $nom_user;
        $this->prenom_user = $prenom_user;
        $this->email = $email;
        $this->pwd = password_hash($pwd, PASSWORD_DEFAULT);
        $this->photo_user = $photo_user;
        $this->numTel = $numTel;

        // Valeurs par défaut (comme dans la BD)
        $this->role_user = 'organisateur';
        $this->status_user = 'actif';
        $this->email_verifie = 0;
        $this->email_token = bin2hex(random_bytes(16));
    }

    // ===== GETTERS =====
    public function getId() { return $this->id_user; }
    public function getNom() { return $this->nom_user; }
    public function getPrenom() { return $this->prenom_user; }
    public function getEmail() { return $this->email; }
    public function getPhoto() { return $this->photo_user; }
    public function getPwd() { return $this->pwd; }
    public function getNumTel() { return $this->numTel; }
    public function getRole() { return $this->role_user; }
    public function getStatus() { return $this->status_user; }
    public function isEmailVerified() { return $this->email_verifie; }

    // ===== SETTERS =====
    public function setNom($nom) { $this->nom_user = $nom; }
    public function setPrenom($prenom) { $this->prenom_user = $prenom; }
    public function setPhoto($photo) { $this->photo_user = $photo; }
    public function setNumTel($numTel) { $this->numTel = $numTel; }

    public function setPassword($pwd) {
        $this->pwd = password_hash($pwd, PASSWORD_DEFAULT);
    }

    public function setRole($role) {
        $this->role_user = $role;
    }

    public function setStatus($status) {
        $this->status_user = $status;
    }

    public function verifyPassword($pwd) {
        return password_verify($pwd, $this->pwd);
    }

    public function verifyEmail() {
        $this->email_verifie = 1;
        $this->email_token = null;
    }
}
?>