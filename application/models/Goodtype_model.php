<?php
class Goodtype_model extends CI_Model {
    
   public function __construct() {
        parent::__construct();
    }


    

    
    
//    function addVehicleApi($data) {
//        $this->db->insert("vehicle", $data);
//        if ($this->db->insert_id() > 0) {
//            return $this->db->insert_id();
//            //return true;
//        } else {
//            return false;
//        }
//    }
    
      public  function getGoodTypeDataApi($user_id) {
        $this->db->where([
                'g_t_add_by'=>$user_id
                ]);
        $query =$this->db->get('tbl_good_type');
        if($query->num_rows() > 0){
            $data= $query->result();
            $counter=0;
            $cat=array();
            foreach($data as $row){
                $cat[$counter]['GoodTypeId']='';
                $cat[$counter]['GoodTypeTitle']='';
                $cat[$counter]['GoodTypeId']=$row->g_t_id;
                $cat[$counter]['GoodTypeTitle']=$row->g_t_title;
                $counter++;
            }
            return $cat;
        }
    }
    
     public  function getApproxLoadDataApi($user_id) {
        $this->db->where([
                'a_l_add_by'=>$user_id
                ]);
        $query =$this->db->get('tbl_approx_load');
        if($query->num_rows() > 0){
            $data= $query->result();
            $counter=0;
            $cat=array();
            foreach($data as $row){
                $cat[$counter]['ApproxLoadId']='';
                $cat[$counter]['ApproxLoadTitle']='';
                $cat[$counter]['ApproxLoadId']=$row->a_l_id;
                $cat[$counter]['ApproxLoadTitle']=$row->a_l_title;
                $counter++;
            }
            return $cat;
        }
    }
     public function getGoodTypeListApi() {
        $this->db->where(array('g_t_delete'=>0,'g_t_status'=>1));
        $query =$this->db->get('tbl_good_type');
            if($query->num_rows() > 0){
                $data= $query->result();
                $counter=0;
                $cat=array();
                foreach($data as $row){
                    $cat[$counter]['GoodsTypeId']=$row->g_t_id;
                    $cat[$counter]['GoodsTypeTitle']=$row->g_t_title;
                    $counter++;
                }
                return $cat;
            }
            else {
            return array();
        }
         
        
    }
    
}
