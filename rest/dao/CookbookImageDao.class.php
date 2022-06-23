<?php

require_once 'BaseDao.class.php';

class CookbookImageDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('cookbook_images');
    }
    public function get_by_id($id)
    {
        $query = "SELECT * FROM cookbook_images WHERE id=:id";
        return @($this->execute_query($query, ['id' => $id]))[0];
    }
}
