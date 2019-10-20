<?php

namespace allcho\rbac\backend\models;

use Yii;
use yii\base\Model;

 
/**
 * Password reset form
 */
class RoleForm extends Model
{

    public $role;
    public $type;
    public $desc;
    public $parent;
    public $child;
    
    
        public function rules()
    {
        return [
            [['role', 'type', 'desc'], 'required'], 
            [['role', 'desc'], 'string', 'max' => 64],
            ['type', 'integer', 'max' => 2],
            [['child', 'parent'], 'safe'],
        ];
    }
    
    
    public function attributeLabels()
    {
        return [
            
            'role' => 'Name',
            'type' => 'Role or Permission',
            'desc' => 'Descriptions',
            'parent' => 'Parent',
            'child' => 'Add Child'
        ];
    }
 
    public function createRole()
    {
        if (!$this->validate()){
    var_dump($this->errors);
    die;
}
        if ($this->validate()) {
            $auth = Yii::$app->getAuthManager();
            if($this->type == 1){
                $role = $auth->createRole($this->role);
                $role->description = $this->desc;
                $auth->add($role);
            }elseif($this->type == 2){
                $permission = $auth->createPermission($this->role);
                $permission->description = $this->desc;
                $auth->add($permission);
            }
            if($this->parent){
                $auth->addChild($this->role, $this->role2);
            }elseif($this->child){
                $auth->addChild($this->role2, $this->role);
            };
            return true;
        } else {
            return false;
        }
    }
    

}