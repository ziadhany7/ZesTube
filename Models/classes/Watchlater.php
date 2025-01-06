<?php
require_once '../Controller/DBController.php';

class Watchlater
{
    private $db;
    private $UserID;
    private $VideoID;
    public function __construct()
    {
        $this->db = new DBController();
    }

    public function AddToWatchLater($userID, $vidID)
    {
        $this->VideoID = $vidID;
        $this->UserID = $userID;
        if ($this->userExists()) {
            $this->db->startConnection();
            $qry = "DELETE FROM `watchlater` WHERE user_ID='$this->UserID' AND video_ID='$this->VideoID' ";
            $this->db->delete($qry);
            $this->db->closeConnection();
        } 
        else {
            $this->db->startConnection();
            $qry = "INSERT INTO `watchlater` ( `user_ID`, `video_ID`) VALUES ( '$this->UserID', '$this->VideoID' )";
            $this->db->insert($qry);
            $this->db->closeConnection();
        }
    }

    private function userExists()
    {
        $this->db->startConnection();
        $qry = "SELECT * FROM `watchlater` WHERE user_ID='$this->UserID' AND video_ID='$this->VideoID' ";
        $result = $this->db->select($qry);
        if (count($result) > 0) {
            $this->db->closeConnection();
            return true;
        } else {
            $this->db->closeConnection();
            return false;
        }
    }
    public function GetWLvideo($userID)
    {
        $this->UserID = $userID;
        $this->db->startConnection();
        $qry = "SELECT video_ID FROM `watchlater` WHERE user_ID=' $this->UserID'";;
        $result = $this->db->select($qry);
        $this->db->closeConnection();
        return $result;
    }
}
