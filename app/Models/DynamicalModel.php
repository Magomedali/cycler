<?php

namespace App\Models;

use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\DB;

trait DynamicalModel{


	protected $fields_table = "fields_schema"; 


	public static function init($id = null){

		$model = new self;
		
		$schema = $model->getSchema();
		
		$model->loadSchema($schema);

		if($id){
			$keyname = $model->getKeyName();
			$loadedModel = $model->find($id);
			if(isset($loadedModel->{$keyname})){
				$model = $loadedModel->loadSchema($schema);
			}
		}

		return $model;
	}

	




	public function getSchema(){
		return DB::table($this->fields_table)->where('table',$this->getTable())->orderBy('id')->get()->toArray();
	}






	public function loadSchema($schema = array()){
		
		$available = array();
		$fillable = array();
		$visible = array();
		$hidden = array();

		//unable default timestamps
		$this->timestamps = false;

		foreach ($schema as $field) {
			array_push($available, $field->name);
			
			if(!$field->auto_increment)
				array_push($fillable, $field->name);


			if($field->key == "PRI"){
				$this->setKeyName($field->name);
				$this->setIncrementing($field->auto_increment && true);
				$this->setKeyType($field->data_type);
			}

			
			array_push($visible, $field->name);
			
			$this->createRule($field);
			

			//array_push($hidden, $field->name);
		}

		$this->setAvailable($available);
		$this->setVisible($visible);
		$this->setHidden($hidden);
		$this->setFillable($fillable);

		return $this;
	}






	public function setFillable($fillable = array()){
		$this->fillable = $fillable;
	}



	public function createRule(Object $field){
		
		if(!$field->auto_increment && $field->is_required){
			$this->setRule($field->name,'required');
		}

		if($field->data_type == "enum"){
			$values = json_decode($field->values);
			if(is_array($values) && count($values)){
				$rule = "in:".implode(",", $values);
				$this->setRule($field->name, $rule);
			}
		}

		if($field->is_nullable){
			$this->setRule($field->name, "nullable");
		}

	}


	public function setRule($attribute,$rule){

		$attrRules = isset($this->rules[$attribute]) ? $this->rules[$attribute] : array();
		
		array_push($attrRules, $rule);

		$this->rules[$attribute] = $attrRules;
	}
}