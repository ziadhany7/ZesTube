<?php
require_once '../Controller/DBController.php';

class Like
{
    private $db;
    private $likeID;
    private $UserID;
    private $VideoID;
    public function __construct()
    {
        $this->db = new DBController();
    }

    public function Like($userID, $vidID)
    {
        $this->VideoID = $vidID;
        $this->UserID = $userID;
        if ($this->userExists()) {
            $this->db->startConnection();
            $qry = "DELETE FROM `likes` WHERE user_ID='$this->UserID' AND video_ID='$this->VideoID' ";
            $this->db->delete($qry);
            $this->db->closeConnection();
            return "unliked";
        } 
        else {
            $this->db->startConnection();
            $qry = "INSERT INTO `likes` ( `user_ID`, `video_ID`) VALUES ( '$this->UserID', '$this->VideoID' )";
            $this->db->insert($qry);
            $this->db->closeConnection();
            return "liked";
        }
    }

    private function userExists()
    {
        $this->db->startConnection();
        $qry = "SELECT * FROM `likes` WHERE user_ID='$this->UserID' AND video_ID='$this->VideoID' ";
        $result = $this->db->select($qry);
        if (count($result) > 0) {
            $this->db->closeConnection();
            return true;
        } else {
            $this->db->closeConnection();
            return false;
        }
    }
    public function GetLvideo($userID)
    {
        $this->UserID = $userID;
        $this->db->startConnection();
        $qry = "SELECT video_ID FROM `likes` WHERE user_ID=' $this->UserID'";;
        $result = $this->db->select($qry);
        $this->db->closeConnection();
        return $result;
    }
}
