<?php

require_once 'BaseDao.class.php';

class RecipeImageDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('recipe_images');
    }
    public function get_by_id($id)
    {
        $query = "SELECT * FROM recipe_images WHERE id=:id";
        return @($this->execute_query($query, ['id' => $id]))[0];
    }
}
