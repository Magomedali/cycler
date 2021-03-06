<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Validator;

class ModelValidation extends Model{


	public function getCreatedAtAttribute($date){
	    return strtotime($date);
	}

	public function getUpdatedAtAttribute($date){
	    return strtotime($date);
	}


	protected $rules = array();
	

	protected $errors = array();

	public function rules(){
		return $this->rules;
	}

	public function getRules(){
		return $this->rules;
	}




	public function fill(array $data,$validate = false){

		parent::fill($data);

		if($validate && !$this->validate($this->getAttributes())){
			return false;
		}

		return $this;
	}




	public function validate($data = array()){

		$v = Validator::make($data,$this->rules);

		if($v->fails()){
			$this->errors = $v->errors();
			return false;
		}

		return true;
	}






	public function errors(){
		return $this->errors;
	}




	public function hasErrors(){
		return count($this->errors) && 1;
	}


	protected $available = array();



    public function getAvailable(){
		return $this->available;
	}



	public function setAvailable(array $available)
    {
        $this->available = $available;
        return $this;
    }

}