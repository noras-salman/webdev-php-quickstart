<?php
class ProfileDao extends Dao{
    
    public $id;
    public $user_id;
    public $name;
    public $role;
    public $created;
    public $updated;

 function __construct(){
    $this->table_name="profile";
    $this->id=Column("id", PrimaryKey(Integer()),"AUTO_INCREMENT");
    $this->user_id=Column("user_id",  ForeignKey(Integer(),"user","id"),"NOT NULL");
    $this->name=Column("name",  Text(),"NOT NULL");
    $this->role=Column("role",  Varchar(12),"NOT NULL");
    $this->created=Column("created", Timestamp(),"DEFAULT CURRENT_TIMESTAMP");
    $this->updated=Column("updated", Timestamp(),"DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
 
    parent::__construct();
 }
}
?>