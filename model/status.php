<?php


class Status
{   //connection
    private $con;

    // class properties

    public $post_content;
    public $user;

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
}