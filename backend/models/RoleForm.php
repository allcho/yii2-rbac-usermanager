<?php

namespace allcho\rbac\backend\models;

use yii\base\Model;

 
/**
 * Password reset form
 */
class RoleForm extends Model
{

    public $role;
    public $type;
    public $desc;
    public $child;
    
    
        public function rules()
    {
        return [
            [['role', 'type', 'desc'], 'required'], 
            [['role', 'desc'], 'string', 'max' => 64],
            ['type', 'integer', 'max' => 2],
            ['child', 'safe'],
        ];
    }
    
    
    public function attributeLabels()
    {
        return [
            
            'role' => 'Name',
            'type' => 'Role or Permission',
            'desc' => 'Descriptions',
            'child' => 'Add Child'
        ];
    }
 
    

}