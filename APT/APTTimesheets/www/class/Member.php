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

    /*
     * newMemberArr keys : user_name, display_name, password, user_type, supervisorId
     */
    public function createNewMember($newMemberArr) {
        $md5Password = md5($newMemberArr['password']);

        if (empty($newMemberArr['user_name']) or empty($newMemberArr['password'])) {
            echo "Username or password is empty";
            //echo "vals:" . $newMemberArr['user_name'] . $newMemberArr['password'];
            return 0;
        } else {
            $query = "INSERT INTO registered_users (user_name, display_name, password, email, user_type, supervisorId)
                        VALUES (?,?,?,?,?,?)";
            $paramType = "sssssi";
            $paramArray = array($newMemberArr['user_name'],
                                $newMemberArr['display_name'],
                                $newMemberArr['password'],
                                $newMemberArr['email'],
                                $newMemberArr['user_type'],
                                $newMemberArr['supervisorId']);
            $newUserQueryResult = $this->ds->insert($query, $paramType, $paramArray);

            echo $newUserQueryResult;
        }
    }

    public function deleteMember($userId) {
        $query = "DELETE FROM registered_users WHERE id=?";
        $paramType = "i";
        $paramArray = array($userId);
        $deleteUserResult = $this->ds->select($query, $paramType, $paramArray);

        echo 'member with user id: ' . $userId . ' deleted';
    }


}

/* Testing */
//$member = new Member();
//$result = $member->processLogin('kate_91', 'kate@03');
//
//print_r($_SESSION["userEmail"]);

$newMemberDetails =
[
    'user_name'=>'smith',
    'display_name'=>'Mr Smith',
    'password'=>'password',
    'email'=>'email@email.com',
    'user_type'=>'submitter',
    'supervisorId'=>1
];

$memberHandler = new Member();
//$memberHandler->createNewMember($newMemberDetails);
//$memberHandler->deleteMember(7);

