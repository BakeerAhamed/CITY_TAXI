<?php
class App
{
  

    public $link;
    

    //create a construct

   

 
//SELECT ALL
public function selectAll($query)
{
 $rows = $this->link->query($query);
 $rows->execute();
 
 $allRows = $rows->fetchAll(PDO::FETCH_OBJ);

 if($allRows)
 {
    return $allRows;
 }
 else
 {
    return false;
 }
     
}

}

?>