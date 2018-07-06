<?php 
namespace App\Models;



class Field extends ModelValidation
{	
	

	/*
	* Table name in the BD
	*/
	protected $table = "fields_schema";


	/*
	* including created_at and updated_at columns in the table
	*/
	public $timestamps = false;



	/*
	* Fillable model properties
	*/
	protected $fillable = [
        'table', 
        'name', 
        'model_type',
        'data_type',
        'alias',
        'auto_increment',
        'is_nullable',
        'is_unsigned',
        'is_system',
        'format',
        'values',
        'default',
        'max_length',
        'numeric_precision',
        'numeric_scale',
        'key',
        'fk_table',
        'fk_table_column',
        'title',
        'description',
        'minimum',
        'maximum',
        'min_length',
        'stored_as',
        'virtual_as',
        'character_charset',
        'character_collation',
        'is_required',
        'pattern',
    ];



    protected $available = [
        'table', 
        'name', 
        'model_type',
        'data_type',
        'alias',
        'auto_increment',
        'is_nullable',
        'is_unsigned',
        'is_system',
        'format',
        'values',
        'default',
        'max_length',
        'numeric_precision',
        'numeric_scale',
        'key',
        'fk_table',
        'fk_table_column',
        'title',
        'description',
        'minimum',
        'maximum',
        'min_length',
        'stored_as',
        'virtual_as',
        'character_charset',
        'character_collation',
        'is_required',
        'pattern',
    ];



    protected $visible = [
        'table', 
        'name', 
        'model_type',
        'data_type',
        'alias',
        'auto_increment',
        'is_nullable',
        'is_unsigned',
        'is_system',
        'format',
        'values',
        'default',
        'max_length',
        'numeric_precision',
        'numeric_scale',
        'key',
        'fk_table',
        'fk_table_column',
        'title',
        'description',
        'minimum',
        'maximum',
        'min_length',
        'stored_as',
        'virtual_as',
        'character_charset',
        'character_collation',
        'is_required',
        'pattern',
    ];

    protected $rules = array(
            'table'                 =>  ['required','string','max:64'],
            'name'                  =>  ['required','string','max:64'],
            'model_type'            =>  ['required','string','max:32','in:Array,Boolean,Integer,Number,Object,String,$ref'],
            'data_type'             =>  ['required','string','max64'],
            'alias'                 =>  ['max:255', 'string','nullable'],
            'auto_increment'        =>  ['boolean'],
            'is_nullable'           =>  ['boolean'],
            'is_unsigned'           =>  ['boolean','nullable'],
            'is_system'             =>  ['boolean'],
            'format'                =>  ['string','max:255'],
            'values'                =>  ['string','nullable'],
            'default'               =>  ['string','nullable'],
            'max_length'            =>  ['integer','nullable'],
            'numeric_precision'     =>  ['integer','nullable'],
            'numeric_scale'         =>  ['integer','nullable'],
            'key'                   =>  ['string','max:3','in:PRI,MUL,UNI'],
            'fk_table'              =>  ['string','max:64'],
            'fk_table_column'       =>  ['string','max:64'],
            'title'                 =>  ['string','max:64'],
            'description'           =>  ['string','nullable'],
            'minimum'               =>  ['integer','nullable'],
            'maximum'               =>  ['integer','nullable'],
            'min_length'            =>  ['integer','nullable'],
            'stored_ad'             =>  ['string','nullable'],
            'virtual_as'            =>  ['string','nullable'],
            'character_charset'     =>  ['string','max:32','nullable'],
            'character_collation'   =>  ['string','max:32','nullable'],
            'is_required'           =>  ['boolean'],
            'pattern'               =>  ['string','max:255'],
    );



    public function rules(){
    	return $this->rules;
    }






    public static function getSchema(ModelValidation $model){
        return Field::where('table','=',$model->getTable())->orderBy('id')->get(['name','model_type','alias'])->toArray();
    }


}