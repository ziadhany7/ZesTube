<?php
require_once '../Controller/DBController.php';

class Subscribe
{
    private $db;
    private $UserID;
    private $ChannID;

    public function __construct()
    {
        $this->db = new DBController();
    }

    public function subscribe($userID, $channID)
    {
        $this->ChannID = $channID;
        $this->UserID = $userID;
        if ($this->userExists()) {
            $this->db->startConnection();
            $qry = "DELETE FROM `subscribe` WHERE User_ID='$this->UserID' AND Channel_ID='$this->ChannID' ";
            $this->db->delete($qry);
            $this->db->closeConnection();
            return "unsubscribed";
        } 
        else {
            $this->db->startConnection();
            $qry = "INSERT INTO `subscribe` ( `User_ID`, `Channel_ID`) VALUES ( '$this->UserID', '$this->ChannID' )";
            $this->db->insert($qry);
            $this->db->closeConnection();
            return "subscribed";
        }
    }

    private function userExists()
    {
        $this->db->startConnection();
        $qry = "SELECT * FROM `subscribe` WHERE User_ID='$this->UserID' AND Channel_ID='$this->ChannID' ";
        $result = $this->db->select($qry);
        if (count($result) > 0) {
            $this->db->closeConnection();
            return true;
        } else {
            $this->db->closeConnection();
            return false;
        }
    }

    public function getSubs($cID)
    {
        $this->db->startConnection();
        $qry = "SELECT User_ID FROM subscribe WHERE channel_ID = '$cID'";
        $result = $this->db->select($qry);
        return $result;
    }

    public function GetSubChann($userID)
    {
        $this->UserID = $userID;
        $this->db->startConnection();
        $qry = "SELECT Channel_ID FROM `subscribe` WHERE user_ID=' $this->UserID'";;
        $result = $this->db->select($qry);
        $this->db->closeConnection();
        return $result;
    }
}
