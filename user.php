<?php
require_once 'config.php';


class user{
    private $conn;
    public function __construct($conn)
    {
        $this->conn=$conn;
    }
    //create a new user 
    public function creatuser($username ,$email ,$password ,$role){
        $hashedPassword =password_hash($password , PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO `users` (`username`,`email`,`password`, `role`) VALUES (?, ?, ?,?)");
        $stmt->bind_param("ssss", $username,$email, $hashedPassword, $role);
        $stmt->execute();
        return $stmt->affected_rows > 0;
     } 
     //read user by username 
     public function getuserbyname($username){
        $stmt =$this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
     }
// Read a user by user ID
    public function getUserById($userId) {
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}
// Get all users
public function getAllUsers() {
    $result = $this->conn->query("SELECT * FROM users");

    return $result->fetch_all(MYSQLI_ASSOC);
}

}
$user = new User($conn);




