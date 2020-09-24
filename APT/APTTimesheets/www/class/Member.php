<?php
namespace Phppot;


class Member
{

    private $ds;

    function __construct()
    {
        require_once "DataSource.php";
        $this->ds = new DataSource();
    }

    function getMemberById($memberId)
    {
        $query = "select * FROM registered_users WHERE id = ?";
        $paramType = "i";
        $paramArray = array($memberId);
        $memberResult = $this->ds->select($query, $paramType, $paramArray);
        
        return $memberResult;
    }
    
    public function processLogin($username, $password) {
        $passwordHash = md5($password);
        $query = "select * FROM registered_users WHERE user_name = ? AND password = ?";
        $paramType = "ss";
        $paramArray = array($username, $passwordHash);
        $memberResult = $this->ds->select($query, $paramType, $paramArray);
        if(!empty($memberResult)) {
            $_SESSION["userId"] = $memberResult[0]["id"];
            $_SESSION["userEmail"] = $memberResult[0]["email"];
            $_SESSION["userType"] = $memberResult[0]["user_type"];
            $_SESSION["userDisplayName"] = $memberResult[0]["display_name"];
            return true;
        }
    }

    public function getMemberUserStatus($memberId) {
        $query = "select user_type FROM registered_users WHERE id = ?";
        $paramType = "i";
        $paramArray = array($memberId);
        $userType = $this->ds->select($query, $paramType, $paramArray);

        return $userType;
    }


}

/* Testing */
//$member = new Member();
//$result = $member->processLogin('kate_91', 'kate@03');
//
//print_r($_SESSION["userEmail"]);


