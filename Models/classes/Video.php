<?php 
require_once '../Controller/DBController.php';

class Video{
    private $db;
    private $VID_id;
    private $VID_title;
    private $description;
    private $thumbnail;
    private $channel_ID;
    private $playlist_ID;
    private $date_uploaded;
    private $numOfViews;
    private $video;


    public function __construct(){
        $this->db = new DBController();
    }

    public function uploadVideo($vid,$channID,$vidT,$desc,$thumb,$pID){
        $this->VID_title = $vidT;
        $this->description = $desc;
        $this->thumbnail = $thumb;
        $this->channel_ID = $channID;
        $this->playlist_ID = $pID;
        $this->video = $vid;
        $qry ="INSERT INTO video (video, videoTitle, videoDescrip, videoThumb, channel_ID, playlist_ID) VALUES ('$this->video','$this->VID_title','$this->description','$this->thumbnail','$this->channel_ID','$this->playlist_ID')";
        $this->db->startConnection();
        if($this->db->insert($qry)){
            $this->db->closeConnection();
            return "Video Uploaded Successfully";
        }
        else{
            $this->db->closeConnection();
            return "An error occurred";
        }
    }

    public function deleteVideo($vid_ID){
        $this->db->startConnection();
        $qry = "DELETE FROM video WHERE video_ID = '$vid_ID'";
        if($this->db->delete($qry)){
            $this->db->closeConnection();
            return "Video Deleted Successfully";
        }
        else{
            $this->db->closeConnection();
            return "An error occurred while deleting video";
        }
    }
    
    public function GetVideoInfo($vid){
        $this->video = $vid;
        $this->db->startConnection();
        $qry ="SELECT * FROM video WHERE video='$this->video'";
        $result = $this->db->select($qry);
        if(count($result) > 0){
            $this->VID_id = $result[0]['video_ID'];
            $this->VID_title = $result[0]['videoTitle'];
            $this->description = $result[0]['videoDescrip'];
            $this->thumbnail = $result[0]['videoThumb'];
            $this->channel_ID = $result[0]['channel_ID'];
            $this->playlist_ID = $result[0]['playlist_ID'];
            $this->date_uploaded = $result[0]['dateuploded'];
            $this->numOfViews = $result[0]['numOfViews'];
            $this->db->closeConnection();
        }
        else{
            $this->db->closeConnection();
        }
    }
    public function GetVideoInfo_With_id($vid_id){
        $this->VID_id = $vid_id;
        $this->db->startConnection();
        $qry ="SELECT * FROM video WHERE video_ID=' $this->VID_id '";
        $result = $this->db->select($qry);
        return $result;
    }

    public function getNumOfLikes(){
        $this->db->startConnection();
        $qry = "SELECT count(video_ID) as num_likes FROM likes WHERE video_ID = '$this->VID_id'";
        $result = $this->db->select($qry);

        $nOfLikes = $result[0]['num_likes'];
        $this->db->closeConnection();
        return $nOfLikes;
    }

    public function getNumOfComments(){
        $this->db->startConnection();
        $qry = "SELECT count(video_ID) as num_comments FROM comment WHERE video_ID = '$this->VID_id'";
        $result = $this->db->select($qry);
        $nOfComments = $result[0]['num_comments'];
        $this->db->closeConnection();
        return $nOfComments;
    }

    public function addVideoToPlyList($pid,$vidID){
        $this->playlist_ID = $pid;
        $this->VID_id = $vidID;
        $this->db->startConnection();
        $qry = "UPDATE video SET playlist_ID = '$this->playlist_ID' WHERE video_ID = '$this->VID_id'";
        if($this->db->update($qry)){
            $this->db->closeConnection();
            return "Video Added to playlist";
        }
        else{
            $this->db->closeConnection();
            return "An error occurred";
        }
    }

    public function videoInPlylist($pid,$vidID){
        $this->db->startConnection();
        $qry = "SELECT * FROM video WHERE playlist_ID = '$pid' AND video_ID = '$vidID'";
        $result = $this->db->select($qry);
        if(count($result)>0){
            $this->db->closeConnection();
            return true;
        }
        else{
            $this->db->closeConnection();
            return false;
        }
    }

    public function updateViews($numOfV){
        $this->db->startConnection();
        $qry = "UPDATE video SET numOfViews = '$numOfV' WHERE video_ID = '$this->VID_id'";
        $this->db->update($qry);
        $this->db->closeConnection();
    }

    public function getAllVideos($channelID){
        $this->db->startConnection();
        $qry = "SELECT * FROM video WHERE channel_ID = '$channelID'";
        $result = $this->db->select($qry);
        return $result;
    }
    
    public function getNumOfViews(){
        return $this->numOfViews;
    }

    public function getDateUploaded(){
        return $this->date_uploaded;
    }


    public function getVideoTitle(){
        return $this->VID_title;
    }

    public function getVideoThumbnail(){
        return $this->thumbnail;
    }

    public function getVideoDescription(){
        return $this->description;
    }

    public function getChannelID(){
        return $this->channel_ID;
    }

    public function getVideoID(){
        return $this->VID_id;
    }
}

?>