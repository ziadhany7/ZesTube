<?php
require_once '../Controller/DBController.php';

class Channel
{
    private $db;
    private $channelName;
    private $channel_ID;
    private $totalViews;
    private $noReports;
    private $dateCreated;
    private $userID;

    public function __construct()
    {
        $this->db = new DBController();
        $this->totalViews=0;
    }


    public function CreateChannel($cn, $usrID)
    {
        $this->channelName = $cn;
        $this->userID = $usrID;

        if ($this->ChannelNameExists($cn)) {
            return "Channel Already Exists";
        } else {
            $this->db->startConnection();
            $qry = "INSERT INTO channel (channelName, user_ID) VALUES ('$this->channelName', '$usrID')";
            if ($this->db->insert($qry)) {
                $this->db->closeConnection();
                return "Channel created successfully";
            } else {
                $this->db->closeConnection();
                return "An Error has occurred";
            }
        }
    }


    public function GetChannelInfoUsrID($usrID)
    {
        $this->userID = $usrID;

        if ($this->ChannelExists($this->userID)) {
            $this->db->startConnection();
            $qry = "SELECT * FROM channel WHERE user_ID = '$this->userID'";

            $result = $this->db->select($qry);

            if (count($result) > 0) {
                $this->channelName = $result[0]['channelName'];
                $this->channel_ID = $result[0]['channel_ID'];
                $this->dateCreated = $result[0]['DateCreated'];
                $this->noReports = $result[0]['numOfReports'];
            }
            $this->db->closeConnection();
            return true;
        } else {
            return false;
        }
    }

    public function GetChannelInfoChannID($chnID)
    {
        $this->channel_ID = $chnID;
        $this->db->startConnection();
        $qry = "SELECT * FROM channel WHERE channel_ID = '$this->channel_ID'";

        $result = $this->db->select($qry);

        if (count($result) > 0) {
            $this->channelName = $result[0]['channelName'];
            $this->dateCreated = $result[0]['DateCreated'];
            $this->noReports = $result[0]['numOfReports'];
            $this->userID = $result[0]['user_ID'];
        }
        $this->db->closeConnection();
    }



    public function EditChannelInfo($usrID, $cName)
    {
        $this->userID = $usrID;
        $this->channelName = $cName;
        if ($this->ChannelNameExists($this->channelName)) {
            return "Channel Already Exists";
        } else {
            $this->db->startConnection();
            $qry = "UPDATE channel SET channelName = '$this->channelName' WHERE user_ID = '$this->userID'";
            if ($this->db->update($qry)) {
                $this->db->closeConnection();
                return "Name Changed Successfully";
            } else {
                $this->db->closeConnection();
                return "An Error Occurred";
            }
        }
    }

    public function ChannelExists($id)
    {
        $this->userID = $id;
        $this->db->startConnection();
        $qry = "SELECT * FROM channel WHERE user_ID = '$this->userID'";
        $result = $this->db->select($qry);
        if (count($result) > 0) {
            $this->db->closeConnection();
            return true;
        } else {
            $this->db->closeConnection();
            return false;
        }
    }

    public function ChannelNameExists($cn)
    {
        $this->channelName = $cn;
        $this->db->startConnection();
        $qry = "SELECT * FROM channel WHERE channelName = '$this->channelName'";
        $result = $this->db->select($qry);
        if (count($result) > 0) {
            $this->db->closeConnection();
            return true;
        } else {
            $this->db->closeConnection();
            return false;
        }
    }

    public function getTotalViews()
    {
        $this->db->startConnection();
        $qry = "SELECT * FROM video WHERE channel_ID = '$this->channel_ID'";
        $result = $this->db->select($qry);
        foreach ($result as $row){
            $this->totalViews = $this->totalViews+$row['numOfViews'];
        }
        return $this->totalViews;
    }

    public function getNumOfReports()
    {
        return $this->noReports;
    }

    public function getUserID()
    {
        return $this->userID;
    }

    public function getChannelID()
    {
        return $this->channel_ID;
    }


    public function getDateCreated()
    {
        return $this->dateCreated;
    }


    public function getChannelName()
    {
        return $this->channelName;
    }

    public function getNumberOfSubscribers($chId)
    {
        $this->db->startConnection();
        $qry = "SELECT count(Channel_ID) as num_of_subs FROM subscribe WHERE channel_ID = '$chId'";
        $result = $this->db->select($qry);
        $noOfSubs = $result[0]['num_of_subs'];
        $this->db->closeConnection();
        return $noOfSubs;
    }

    public function getNumOfVideos($chId)
    {
        $this->db->startConnection();
        $qry = "SELECT count(video) as num_of_videos FROM video WHERE channel_ID = '$chId'";
        $result = $this->db->select($qry);
        $noOfVideos = $result[0]['num_of_videos'];
        $this->db->closeConnection();
        return $noOfVideos;
    }
}
?>