<?php

class Friend
{

    private $con;

    public $user_one;
    public $user_two;
    public $id;

    public function __construct($db)
    {
        $this->con = $db;
    }

    public function addFriend()
    {
        if ($this->isAlreadyFriends()) {
            return false;
        } else {
            $add_friend = $this->con->prepare("INSERT INTO friend_requests(sender_id,reciever_id) VALUES (?,?)");
            $add_friend->bind_param("ii", $this->user_one, $this->user_two);
            $add_friend->execute();
            return $add_friend;
        }
    }
    public function acceptFriend(){
        $accept_friend = $this->con->prepare("INSERT INTO friends(user_one, user_two) VALUES (?,?)");
        $accept_friend->bind_param("ii",$this->user_one, $this->user_two);
        $accept_friend->execute();
        return $accept_friend;
    }

    public function isAlreadyFriends()
    {
        $check_friends = $this->con->prepare("SELECT id FROM friend_requests WHERE sender_id = ? AND reciever_id = ?");
        $check_friends->bind_param("ii", $this->user_one, $this->user_two);
        $check_friends->execute();
        $check_friends->store_result();
        $check_friends->bind_result($this->id);
        $check_friends->fetch();
        $num_rows = $check_friends->num_rows;
        if ($num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
}
