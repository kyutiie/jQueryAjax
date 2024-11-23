


<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class User_model extends Model {
    private $pdo;

    public function __construct(){
        
        $dsn = 'mysql:host=localhost;dbname=crisporo_rica_mae;charset=utf8mb4';
        $username = 'root';
        $password = '';
        
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }


    public function getPaginatedData($limit, $offset, $searchTerm = '') {
        $sql = "SELECT * FROM rmgc_users WHERE 
                rmgc_first_name LIKE :search OR 
                rmgc_last_name LIKE :search OR 
                rmgc_email LIKE :search 
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->pdo->prepare($sql);
        $searchTerm = "%$searchTerm%"; // Prepare search term for LIKE query
        $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function count($searchTerm = '') {
        $sql = "SELECT COUNT(*) FROM rmgc_users WHERE 
                rmgc_first_name LIKE :search OR 
                rmgc_last_name LIKE :search OR 
                rmgc_email LIKE :search";
        
        $stmt = $this->pdo->prepare($sql);
        $searchTerm = "%$searchTerm%"; // Prepare search term for LIKE query
        $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
    
        return $stmt->fetchColumn();
    }
    
    
    public function search(){
        $stmt = $this->pdo->query("SELECT `id`, `rmgc_last_name`, `rmgc_first_name`, `rmgc_email`, `rmgc_gender`, `rmgc_address` FROM `rmgc_users`");
        return $stmt->fetchAll(); 
        
    }
    public function views() {
        $stmt = $this->pdo->query("SELECT * FROM `rmgc_users`" );
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    public function register($fname, $lname, $gender, $address, $email) {
        $sql = "INSERT INTO rmgc_users (rmgc_first_name, rmgc_last_name, rmgc_email, rmgc_gender, rmgc_address) 
                VALUES (:fname, :lname, :email, :gender, :address)";
        $stmt = $this->pdo->prepare($sql);

       
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':address', $address);

        
        return $stmt->execute();
    }

    public function readedit($id) {
        $sql = "SELECT * FROM rmgc_users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);  // Fetch single row as associative array
    }




    public function update($id, $fname, $lname, $gender, $address, $email) {
        $sql = "UPDATE rmgc_users SET rmgc_first_name = :fname, rmgc_last_name = :lname, rmgc_email = :email, 
                rmgc_gender = :gender, rmgc_address = :address WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);


        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);


        return $stmt->execute();



    }



    public function delete($id) {
        $sql = "DELETE FROM rmgc_users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();



    }
}
?>
