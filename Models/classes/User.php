<?php
require_once '../Controller/DBController.php';

class User
{
    protected $db;
    private $id;
    private $FirstName;
    private $LastName;
    private $password;
    private $email;
    private $profilePic;

    public function __construct()
    {
        $this->db = new DBController();
    }


    public function login($em, $pw)
    {
        $this->email = $em;
        $this->password = $pw;
        if ($this->userExists()) {
            $this->db->startConnection();
            $qry = "SELECT * FROM users WHERE email='$this->email'";
            $result = $this->db->select($qry);
            if ($result[0]['password'] == $this->password) {
                $this->id = $result[0]['user_ID'];
                session_start();
                $_SESSION['UserId'] = $this->id;
                $this->db->closeConnection();
                return "Logged in successfully. Redirecting...";
            } else {
                $this->db->closeConnection();
                return "Wrong password. Please try again. Redirecting...";
            }
        } else {
            return "User not found. Try to register first. Redirecting...";
        }
    }


    public function EditProfileInfo($id, $fn, $ln, $em, $pw, $pp)
    {
        $this->id = $id;
        $this->FirstName = $fn;
        $this->LastName = $ln;
        $this->email = $em;
        $this->password = $pw;
        $this->profilePic = $pp;
        $this->db->startConnection();
        $qry = "UPDATE users SET firstName='$this->FirstName', lastName='$this->LastName', email='$this->email', password='$this->password', profilePic='$this->profilePic' WHERE user_ID='$this->id'";
        $result = $this->db->update($qry);
        if ($result) {
            $this->db->closeConnection();
            return "Profile updated successfully. Redirecting...";
        } else {
            $this->db->closeConnection();
            return "Something went wrong. Please try again. Redirecting...";
        }
    }

    public function GetProfileInfo($id)
    {
        $this->id = $id;
        $this->db->startConnection();
        $qry = "SELECT * FROM users WHERE user_ID='$this->id'";
        $result = $this->db->select($qry);
        if (count($result) > 0) {
            $this->FirstName = $result[0]['firstName'];
            $this->LastName = $result[0]['lastName'];
            $this->email = $result[0]['email'];
            $this->password = $result[0]['password'];
            $this->profilePic = $result[0]['profilePic'];
            $this->db->closeConnection();
        } else {
            $this->db->closeConnection();
        }
    }

    public function DeleteProfile($id)
    {
        $this->id = $id;
        $this->db->startConnection();
        $qry = "DELETE FROM users WHERE user_ID='$this->id'";
        $result = $this->db->delete($qry);
        if ($result) {
            $this->db->closeConnection();
            return "Profile Deleted. Redirecting...";
        } else {
            $this->db->closeConnection();
            return "Something went wrong.Redirecting...";
        }
    }


    public function register($fn, $ln, $em, $pw, $pp)
    {
        $this->FirstName = $fn;
        $this->LastName = $ln;
        $this->password = $pw;
        $this->email = $em;
        $this->profilePic = $pp;
        if ($this->userExists()) {
            return "User already exists. Try again";
        } else {
            $this->db->startConnection();
            $qry = "INSERT INTO users (firstName,lastName,email,password,profilePic) VALUES ('$this->FirstName','$this->LastName','$this->email','$this->password','$this->profilePic')";
            if ($this->db->insert($qry)) {
                $this->db->closeConnection();
                return "Registration successful. Redirecting to login";
            } else {
                $this->db->closeConnection();
                return "Error";
            }
        }
    }

    private function userExists()
    {
        $this->db->startConnection();
        $qry = "SELECT * FROM users WHERE email='$this->email'";
        $result = $this->db->select($qry);
        if (count($result) > 0) {
            $this->db->closeConnection();
            return true;
        } else {
            $this->db->closeConnection();
            return false;
        }
    }


    public function getFName()
    {
        return $this->FirstName;
    }

    public function getLName()
    {
        return $this->LastName;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getProfilePic()
    {
        return $this->profilePic;
    }
}
?>