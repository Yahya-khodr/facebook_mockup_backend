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
        if ($this->alreadyRequested()) {
            return false;
        } else {
            $add_friend = $this->con->prepare("INSERT INTO friend_requests(sender_id,reciever_id) VALUES (?,?)");
            $add_friend->bind_param("ii", $this->user_one, $this->user_two);
            $add_friend->execute();
            return $add_friend;
        }
    }
    public function acceptFriend()
    {
        if ($this->alreadyFriends()) {
            return false;
        } else {
            $accept_friend = $this->con->prepare("INSERT INTO friends(user_one, user_two) VALUES (?,?)");
            $accept_friend->bind_param("ii", $this->user_one, $this->user_two);
            $accept_friend->execute();
            return $accept_friend;
        }
    }
    public function alreadyFriends()
    {
        $check_friend = $this->con->prepare("SELECT friends_id FROM friends WHERE user_one =? AND user_two = ?");
        $check_friend->bind_param("ii", $this->user_one, $this->user_two);
        $check_friend->execute();
        $check_friend->store_result();
        $check_friend->bind_result($this->id);
        $check_friend->fetch();
        $num_rows = $check_friend->num_rows;
        if ($num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function alreadyRequested()
    {
        $check_request = $this->con->prepare("SELECT id FROM friend_requests WHERE sender_id = ? AND reciever_id = ?");
        $check_request->bind_param("ii", $this->user_one, $this->user_two);
        $check_request->execute();
        $check_request->store_result();
        $check_request->bind_result($this->id);
        $check_request->fetch();
        $num_rows = $check_request->num_rows;
        if ($num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function blockFriend()
    {
        $block_friend = $this->con->prepare("INSERT INTO blocked_list(blocked_user, blocked_by) VALUES (?,?)");
        $block_friend->bind_param("ii", $this->user_one, $this->user_two);
        $block_friend->execute();
        $this->removeFriend();
        $this->deleteRequest($this->user_one, $this->user_two);
        return $block_friend;
    }

    public function unblockFriend(){
        
    }

    public function removeFriend()
    {
        $remove_friend = $this->con->prepare("DELETE FROM friends WHERE user_one =? AND user_two =? OR user_one =? AND user_two = ?");
        $remove_friend->bind_param("iiii", $this->user_one, $this->user_two, $this->user_two, $this->user_one);
        $remove_friend->execute();
        return $remove_friend;
    }

    public function deleteRequest($sender, $reciever)
    {
        $delete_request = $this->con->prepare("DELETE FROM friend_requests WHERE sender_id = $sender AND reciever_id = $reciever");
        $delete_request->execute();
        return $delete_request;
    }
}
