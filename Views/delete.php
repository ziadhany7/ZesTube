<?php
    require_once '../Controller/DBController.php';
    require_once '../Models/classes/Notification.php';

    $db = new DBController();
    if(isset($_GET['userID'])){
        $usrID = $_GET['userID'];
        $db->startConnection();
        $qry = "DELETE FROM users WHERE user_ID ='$usrID'";
        $result = $db->delete($qry);
        $db->closeConnection();
        header("Location: adminUsers.php");
    }

    if(isset($_GET['videoID'])){
        $vi_ID = $_GET['videoID'];
        $db->startConnection();
        $qry = "DELETE FROM video WHERE video_ID ='$vi_ID'";
        $result = $db->delete($qry);
        $db->closeConnection();
        header("Location: adminVideos.php");
    }

    if(isset($_GET['channel_ID'])){
        $ch_ID = $_GET['channel_ID'];
        $db->startConnection();
        $qry = "DELETE FROM channel WHERE channel_ID ='$ch_ID'";
        $result = $db->delete($qry);
        $db->closeConnection();
        header("Location: adminChannels.php");
    }

    if(isset($_GET['reportedID']) && isset($_GET['report'])){
        $vi_ID = $_GET['reportedID'];
        $rep_ID = $_GET['report'];
        $db->startConnection();
        $qry = "DELETE FROM video WHERE video_ID ='$vi_ID'";
        $qry1 = "DELETE FROM feedback WHERE report_ID ='$rep_ID'";
        $db->delete($qry);
        $db->delete($qry1);
        $db->closeConnection();
        header("Location: videosReported.php");
    }

?>
