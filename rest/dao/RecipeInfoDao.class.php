<?php
require_once 'BaseDao.class.php';

class RecipeInfoDao extends BaseDao{

  public function __construct(){
    parent::__construct('recipe_info');
  }
  public function get_recipe_by_id($id){
    $query = "SELECT * FROM recipe_info WHERE id=:id";
    return @($this->execute_query($query, ['id' => $id]))[0];
  }
}
?>
