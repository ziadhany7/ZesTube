<?php 
require_once '../Controller/DBController.php';


class Playlist{
    private $db;
    private $pID;
    private $playlistName;
    private $chanID;

    public function __construct(){
        $this->db = new DBController();
    }

    public function getPlayListsNames($chnID){
        $this->chanID = $chnID;
        $this->db->startConnection();
        $qry = "SELECT * FROM playlist WHERE channel_ID = '$this->chanID'";
        $result = $this->db->select($qry);
        $this->db->closeConnection();
        return $result;
    }

    public function createPlaylist($pliName,$chnID){
        $this->playlistName = $pliName;
        $this->chanID = $chnID;
        if(!$this->playlistExists($pliName)){
            $this->db->closeConnection();
            $this->db->startConnection();
            $qry = "INSERT INTO playlist (channel_ID, title) VALUES ('$this->chanID','$this->playlistName')";
            $this->db->insert($qry);
            $this->db->closeConnection();
            return "Playlist Created Successfully";
        }else{
            $this->db->closeConnection();
            return "Playlist already exists";
        }

    }

    public function playlistExists($pliName){
        $this->playlistName = $pliName;
        $this->db->startConnection();
        $qry = "SELECT * FROM playlist WHERE title = '$this->playlistName'";
        $result = $this->db->select($qry);
        if(count($result) > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function deletePlaylist($pid){
        $this->pID = $pid;
        $this->db->startConnection();
        $qry = "DELETE FROM playlist WHERE playlist_ID = '$this->pID'";
        if($this->db->delete($qry)){
            $this->db->closeConnection();
            return "Playlist Deleted Successfully";
        }
        else{
            $this->db->closeConnection();
            return "An error occurred while deleting playlist";
        }
    }

    public function getPlaylistInfo($pid){
        $this->pID = $pid;
        $this->db->startConnection();
        $qry = "SELECT * FROM playlist WHERE playlist_ID = '$this->pID'";
        $result = $this->db->select($qry);
        $this->db->closeConnection();
        return $result;
    }

    public function getPlaylistVideos($pid){
        $this->pID = $pid;
        $this->db->startConnection();
        $qry = "SELECT * FROM video WHERE playlist_ID = '$this->pID'";
        $result = $this->db->select($qry);
        $this->db->closeConnection();
        return $result;
    }
}
