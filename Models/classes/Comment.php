<?php 
require_once '../Controller/DBController.php';
class Comment{
    private $db;
    private $CommID;
    private $date;
    private $UserID;
    private $VideoID;
    private $msg;
    public function __construct()
    {
        $this->db = new DBController();
    }

    public function addComment($msg,$userID,$vidID)
    {
        $this->msg = $msg;
        $this->VideoID =$vidID;
        $this->UserID =$userID;
        
        $qry = "INSERT INTO `comment` ( `user_ID`, `video_ID`, `comment`) VALUES ( '$this->UserID', '$this->VideoID' , '$this->msg')";
        $this->db->startConnection();
        $result = $this->db->insert($qry);
        if ($result) {
            $this->db->closeConnection();
            return "Comment Added successfully.";
        } else {
            $this->db->closeConnection();
            return "Something went wrong.";
        }
    }

    public function deleteComment($id){
        $this->GetComment($id);
        $this->db->startConnection();
        $qry = "DELETE FROM comment WHERE comment_ID = '$this->CommID'";
        $result = $this->db->delete($qry);
        if($result){
            $this->db->closeConnection();
            return "Comment deleted successfully";
        }else{
            $this->db->closeConnection();
            return "An error occurred";
        }
    }

    private function GetComment($id)
    {
        $this->UserID = $id;
        $this->db->startConnection();
        $qry = "SELECT * FROM comment WHERE user_ID='$this->UserID'";
        $result = $this->db->select($qry);
        if (count($result) > 0) {
            $this->msg = $result[0]['comment'];
            $this->UserID = $result[0]['user_ID'];
            $this->VideoID = $result[0]['video_ID'];
            $this->date = $result[0]['ComDate'];
            $this->CommID = $result[0]['comment_ID'];
        }
        $this->db->closeConnection();
    }

    public function displayComments($vidID){
        $this->db->startConnection();
        $qry = "SELECT * FROM comment WHERE video_ID='$vidID'";
        $result = $this->db->select($qry);
        return $result;
    }
}
?>