<?php


class Status
{   //connection
    private $con;

    // class properties

    public $post_content;
    public $user;
    public $like;

    // functions
    public function __construct($db)
    {
        $this->con = $db;
    }
    public function createStatus()
    {
        $create_status = $this->con->prepare("INSERT INTO posts(post_content, created_by) VALUES (?,?)");
        $create_status->bind_param("ss", $this->post_content, $this->user);
        $create_status->execute();
        return $create_status;
    }

    public function updateStatus($id)
    {
        $update_status = $this->con->prepare("UPDATE posts SET post_content = ? WHERE post_id = $id ");
        $update_status->bind_param("s", $this->post_content);
        $update_status->execute();
        return $update_status;
    }

    public function deleteStatus($id)
    {
        $delete_status = $this->con->prepare("DELETE FROM posts WHERE post_id  =$id");
        $delete_status->execute();
        return $delete_status;
    }

    public function likeStatus($id)
    {
        $this->like++;
        $like_status = $this->con->prepare("UPDATE posts SET likes= ? WHERE post_id = $id");
        $like_status->bind_param("i", $this->like);
        $like_status->execute();
        return $like_status;
    }
    public function getAllStatus($id)
    {
        $all_status = $this->con->prepare("SELECT * FROM posts p , friends f, users u 
         WHERE not exists (SELECT 1 FROM blocked_list b WHERE b.blocked_by = ? AND b.blocked_user = u.id)
         AND WHERE f.user_one = ? AND f.user_two = u.id OR f.user_two = ? AND f.user_one = u.id ");
        $all_status->bind_param("iii", $id, $id, $id);
        $all_status->execute();
        return $all_status;
    }
}
