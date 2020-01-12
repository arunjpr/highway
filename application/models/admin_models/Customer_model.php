<?php  
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Customer_model extends CI_Model { 
    public function __construct() { 
        parent::__construct(); 
    }
    private $_users = 'users';  
    
    public function check_login_info() {
        $username_or_email_address = $this->input->post('username_or_email_address', true);
        $password = $this->input->post('password', true);
        $this->db->select('*')
                ->from('users')
                ->where("(Name = '$username_or_email_address' OR Email = '$username_or_email_address')")
                ->where('password', md5($password))
                ->where("(Role_Id = '1' OR Role_Id = '2')")
                ->where('Status', 1)
                ->where('deletion_status', 0)
                ->where('Role_Id <= ', 5);
        $query_result = $this->db->get();
//         echo  $this->db->last_query();die;
        $result = $query_result->row();
        return $result;

    }
    
    public function add_customer_data($data) { 
        //echo '<pre>' ;print_r($data);die;
        $this->db->insert($this->_users, $data); 
        
        return $this->db->insert_id(); 
    }  
	
    public function get_customer_info() { 
        $this->db->select('*') 
                ->from('users')
                ->where('Role_Id', 4)
                ->where('deletion_status', 0)
                ;
        $query_result = $this->db->get(); 
        $result = $query_result->result_array(); 
        return $result; 
    } 

    public function get_Customer_by_customer_id($customer_id) { 
        $result = $this->db->get_where($this->_users, array('Id' => $customer_id , 'deletion_status' => 0)); 
        return $result->row_array(); 
    } 

    public function published_customer_by_id($customer_id) { 
        $this->db->update($this->_users, array('Status' => 1), array('Id' => $customer_id));  
        return $this->db->affected_rows(); 
    } 

    public function unpublished_customer_by_id($customer_id) { 
        $this->db->update($this->_users, array('Status' => 0), array('Id' => $customer_id)); 
        return $this->db->affected_rows(); 
    } 

    public function update_customer($customer_id, $data) { 
        $this->db->update($this->_users, $data, array('Id' => $customer_id)); 
        return $this->db->affected_rows(); 
    } 
	
    public function remove_customer_by_id($customer_id) { 
        $this->db->update($this->_users, array('deletion_status' => 1), array('Id' => $customer_id)); 
        return $this->db->affected_rows(); 
    } 
    public function newCustomerList(){
        $this->db->select("Id,Role_id,Name,Image,Mobile,created_on")
        ->from('users')
        ->where('Role_id',2) 
        ->order_by("Id", "desc")
        ->limit(6)      
                ;
        $query=$this->db->get();
        //echo  $this->db->last_query();die;
        //$result =$query->result_array();
         if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=array();
                foreach($data as $row){
                    $cat[$counter]['Id']=$row->Id;
                    $cat[$counter]['Name']= ucwords($row->Name);
                    $cat[$counter]['Mobile']= $row->Mobile;
                    $cat[$counter]['created_on']= $row->created_on;
                    $customerImage = $row->Image;
                    $filename ="assets/backend/img/customer/profile/$customerImage";
                     $defaultImage ="assets/backend/img/customer/profile/customer.png";
                    if((file_exists($filename)) && $customerImage!=''){                        
                        $cat[$counter]['customerImage']=$filename; 
                    } else {
                        $cat[$counter]['customerImage']=$defaultImage; 
                    }
                   
                    $counter++;
                }
                return $cat;
            } else {
            return array();
        } 
         
    }
    
}

