<?php
class Push_notification_model extends CI_Model {
    
   public function __construct() {
        parent::__construct();
    }
   public function addPushNotificationApi($data) {
        $this->db->insert("tbl_push_notification", $data);
        if ($this->db->insert_id() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }   
}
