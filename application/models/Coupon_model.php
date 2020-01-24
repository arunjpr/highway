<?php
class Coupon_model extends CI_Model {
    
   public function __construct() {
        parent::__construct();
    }
    
     public function getCouponData($coupon) {
        $this->db->select(array("*"))
                ->from("tbl_coupans")
                ->where(array("tbl_coupans.c_coupan_code" => $coupon, "tbl_coupans.c_coupan_status" >= 1));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    public function getCouponByCupanID($couponId) {
          
        $this->db->select(array("*"))
                ->from("tbl_coupans")
                ->where(array("tbl_coupans.c_id" => $couponId,"tbl_coupans.c_coupan_status" => 2));
        $query = $this->db->get();
       // $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    public function updateCouponApi($data,$id) {
     $this->db->where(['c_id'=>$id]);
        $this->db->update('tbl_coupans',$data);
        if ($id> 0) {
            return $id;
        } else {
            return false;
        }
    }
      
}
