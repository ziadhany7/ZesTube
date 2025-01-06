<?php 
require_once '../Controller/DBController.php';

class Notification{
    private $db;
    private $userID;
    private $notifID;
    private $notification;
    private $notifType;
    private $notifSeen;
    private $usrToNotify;

    public function __construct(){
        $this->db = new DBController();
    }

    public function notify($usrID,$notif,$notifT,$seen,$usrToN){
        $this->db->startConnection();
        $qry = "INSERT INTO notifications (user_ID, notification, notificationType, seen, user_to_notify) VALUES ('$usrID','$notif','$notifT','$seen','$usrToN')";
        $this->db->insert($qry);
        $this->db->closeConnection();
    }

    public function displayNotifications($usrID){
        $this->db->startConnection();
        $qry = "SELECT * FROM notifications WHERE user_to_notify = '$usrID' ORDER BY notif_ID desc";
        $result = $this->db->select($qry);
        $this->db->closeConnection();
        return $result;
    }

    public function getNumberOfNotifications($usrID){
        $this->db->startConnection();
        $qry = "SELECT count(*) as numberOfNotifs FROM notifications WHERE user_to_notify = '$usrID'";
        $result = $this->db->select($qry);
        $this->db->closeConnection();
        return $result[0]['numberOfNotifs'];
    }

    public function markAsRead($nID){
        $this->db->startConnection();
        $qry = "UPDATE notifications SET seen = 1 WHERE user_to_notify = '$nID'";
        $this->db->update($qry);
        $this->db->closeConnection();
    }
}


?>