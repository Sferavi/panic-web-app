<?php
require_once 'BaseDao.class.php';

class RecipeInfoDao extends BaseDao{

  public function __construct(){
    parent::__construct('recipe_info');
  }
  public function get_all_favorite_recipes($user_id){
    $query = "SELECT * FROM recipe_info WHERE favorite!=0";
    return @($this->execute_query($query, []));
  }
  public function get_recipe_by_id($id){
    $query = "SELECT * FROM recipe_info WHERE id=:id";
    return @($this->execute_query($query, ['id' => $id]))[0];
  }
  public function update_recipe($recipe, $recipe_id){
    $entity[':id'] = $recipe_id;
    $query= 'UPDATE recipe_info SET ';
    foreach ($recipe as $key => $value) {
      $query .= $key . '=:' . $key . ', ';
      $entity[':' . $key] = $value;
    }
    $query = rtrim($query,', ') . ' WHERE id=:id';
    return $this->update($entity, $query);
  }
  public function delete_recipe($id){
    $query = "DELETE FROM recipe_info WHERE id =:id";
    return $this->execute_query1($query, ['id' => $id]);
  }
  public function get_my_recipes($user_id) {
    $query = "SELECT * FROM recipe_info WHERE user_id=:user_id";
    return @($this->execute_query($query, ['user_id' => $user_id]));
  }
}
?>
