<?php

require_once 'BaseDao.class.php';

class UsersDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('users');
    }
    public function get_user_by_id($id)
    {
        $query = "SELECT * FROM users WHERE id=:id";
        return @($this->execute_query($query, ['id' => $id]))[0];
    }

    public function get_user_by_email($email)
    {
        $query = "SELECT * FROM users WHERE email=:email";
        return @($this->execute_query($query, ['email' => $email]))[0];
    }

    public function get_user_by_username($username)
    {
        $query = "SELECT * FROM users WHERE username=:username";
        return @($this->execute_query($query, ['username' => $username]))[0];
    }

    public function delete_user($id)
    {
        $query = "DELETE FROM users WHERE id =:id";
        return $this->execute_query1($query, ['id' => $id]);
    }
}
