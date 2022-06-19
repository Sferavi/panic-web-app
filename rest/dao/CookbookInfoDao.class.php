<?php
require_once 'BaseDao.class.php';

class CookBookInfoDao extends BaseDao{

  public function __construct(){
    parent::__construct('cookbook_info');
  }

  public function get_my_cookbooks($user_id) {
    $query = "SELECT * FROM cookbook_info WHERE user_id=:user_id";
    return @($this->execute_query($query, ['user_id' => $user_id]));
  }
  public function get_cookbook_by_id($id){
    $query = "SELECT * FROM cookbook_info WHERE id=:id";
    return @($this->execute_query($query, ['id' => $id]))[0];
  }
  public function update_cookbook($cookbook, $cookbook_id){
    $entity[':id'] = $cookbook_id;
    $query= 'UPDATE cookbook_info SET ';
    foreach ($cookbook as $key => $value) {
      $query .= $key . '=:' . $key . ', ';
      $entity[':' . $key] = $value;
    }
    $query = rtrim($query,', ') . ' WHERE id=:id';
    return $this->update($entity, $query);
  }
  public function delete_cookbook($id){
    $query = "DELETE FROM cookbook_info WHERE id =:id";
    return $this->execute_query1($query, ['id' => $id]);
  }
}
