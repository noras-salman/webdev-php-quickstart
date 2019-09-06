<?php
class UserDao extends Dao{
    
    public $id;
    public $email;
    public $created;
    public $updated;

 function __construct(){
    $this->table_name="user";
    $this->id=Column("id", PrimaryKey(Integer()),"AUTO_INCREMENT");
    $this->email=Column("email",  Varchar(255),"NOT NULL");
    $this->created=Column("created", Timestamp(),"DEFAULT CURRENT_TIMESTAMP");
    $this->updated=Column("updated", Timestamp(),"DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
    $this->addIndex(Index("email"));
    parent::__construct();
 }

 function appendOnQuery($binded,$row){
   $profile=new ProfileDao();
   $profile_result=$profile->queryExtended("WHERE user_id=".$row["id"])->results[0]; //one to onw take first
   $binded->profile=$profile_result;
   return $binded;
   }

}
?>