
<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class User extends Controller {

    public function __construct(){
        parent:: __construct();
        $this->call->model('user_model');
    }

    
    public function original() {
        
        
            
            
            $data['user'] = $this->user_model->views();
        
      
        $this->call->view('users/home', $data); 
    }


    

    public function views($page = 1) {
        $limit = 5; // Limit per page
        $offset = ($page - 1) * $limit;
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : ''; // Get the search term from query params
    
        // Count total rows based on search
        $totalRows = $this->user_model->count($searchTerm);
        
        // Get filtered users based on the search term
        $data['users'] = $this->user_model->getPaginatedData($limit, $offset, $searchTerm);
        $data['total_pages'] = ceil($totalRows / $limit);
        $data['current_page'] = $page;
    
        
        echo json_encode($data);
    
    }
    
    
    public function register(){
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $fname = $this->io->post('firstname');
            $lname = $this->io->post('lastname');
            $gender = $this->io->post('gender');
            $address = $this->io->post('address');
            $email = $this->io->post('email');

            
            $result = $this->user_model->register($fname, $lname, $gender, $address, $email);
        
        if ($result) {
            echo json_encode(['success' => true]);
            
            
            exit(); 
        } else {
            echo json_encode(['success' => false]);
            
            
        }

        }

        // Display the registration form if no POST request
        $this->call->view('users/register');
    }  

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle AJAX request for updating user
            header('Content-Type: application/json');
            
            // Get data from the form submission
            $id = $this->io->post('id');
            $fname = $this->io->post('firstname');
            $lname = $this->io->post('lastname');
            $gender = $this->io->post('gender');
            $address = $this->io->post('address');
            $email = $this->io->post('email');
    
            // Update the user's data in the database
            $result = $this->user_model->update($id, $fname, $lname, $gender, $address, $email);
    
            if ($result) {
                echo json_encode(['success' => true]);
                
                
                
            } else {
                echo json_encode(['success' => false]);
                
                
            }
    
            
        }
    
        $data['user'] = $this->user_model->readedit($id);
        $this->call->view('users/edit', $data);
    }
    
    


    
    

    public function delete($id){
        $this->user_model->delete($id);
        echo json_encode(['success' => true]);
    }

}
?>
