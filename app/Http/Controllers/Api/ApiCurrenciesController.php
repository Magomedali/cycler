<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Deals,Field,Currencies,Pipeline,Stage};
use App\{Role,Permissions,User};
use App\Helpers\ApiHelper;

use App\Events\UpdatedModels;
use App\Exceptions\ModelValidateException;
use Exception;

class ApiCurrenciesController extends Controller
{

    /**
    * GET <baseUrl>/api/currencies
    * role: *
    * permission: read:currencies
    * filters: Yes
    * @return array()
    */
    public function getCurrencies(Request $request){
        $api = new ApiHelper;
        
        $result = $api->getByRequest(new Currencies,$request->all());
        
        return $result; 
    }





    /*
    *
    * GET <baseUrl>/api/currencies/<id>
    *
    */
    public function getCurrency($id){
        
        $model = Currencies::findOrFail($id);

        return $model->getAttributes();
    }




    /*
    * PUT <baseUrl>/api/currencies
    */
    public function createCurrencies(Request $request){

        $answer = array();

        $parameters = $request->toArray();

        $model =  new Currencies;
        
        $success = $model->fill($request->toArray(),true) && $model->save() ? true : false;
        
        if($success){
            event(new UpdatedModels($model,UpdatedModels::CREATED));
        }

        $errors = $model->errors();
        
        if(count($errors))
            throw new ModelValidateException($model);
        

        return [
            'success'=>$success,
            'errors'=>$errors,
        ];
    }






    /*
    *
    * POST <baseUrl>/api/currencies/<id>
    *
    */
    public function editCurrencies($id,Request $request){
        $answer = array();
        
        $model = Currencies::find($id);
        
        if(isset($model->id)){
            $success = $model->fill($request->toArray(),true) && $model->save() ? true : false;
            
            $currency=$model->getAttributes();
            
            if($success){
                event(new UpdatedModels($model,UpdatedModels::UPDATED));
            }

            $errors = $model->errors();
        }else{
            throw new \Exception("Currency not found",404);
        }
        
        if(count($errors))
            throw new ModelValidateException($model);

        return [
            'success'=>$success,
            'currency'=>$currency,
            'errors'=>$errors
        ];
    }






    /*
    *
    * DELETE <baseUrl>/api/currencies/<id>
    *
    */
    public function removeCurrencies($id){
        
        $model = Currencies::find($id);
        $success = false;
        if(isset($model->id)){
            
            $success = $model->delete();
            
            if($success){
                event(new UpdatedModels($model,UpdatedModels::DELETED));
            }

        }else{
            throw new Exception("Currency not found",404);
        }

        return [
            'success'=>$success
        ];
    }


}
