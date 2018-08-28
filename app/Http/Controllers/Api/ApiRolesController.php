<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Deals,Field,Currency,Pipeline,Stage};
use App\{Role,Permissions,User};
use App\Helpers\ApiHelper;
use App\Events\UpdatedModels;
use App\Exceptions\ModelValidateException;
use Exception;
class ApiRolesController extends Controller
{


    /**
     * 
     * @return void
     */
    public function __construct()
    {
       
    }


    /*
    *
    * GET <baseUrl>/api/roles
    *
    */
    public function getRoles(Request $request){

        $api = new ApiHelper;
        
        $result = $api->getByRequest(new Role,$request->all());
        
        return $result; 
    }



    /*
    *
    * GET <baseUrl>/api/roles/<id>
    *
    */
    public function getRole($id){

        $model = Role::findOrFail($id);

        return response()->json([$model->getAttributes()]);
    }

    
    /*
    *
    * PUT <baseUrl>/api/roles
    *
    */
    public function create(Request $request){

        $answer = array();

        $parameters = $request->toArray();

        $model = new Role;
        
        $success = $model->fill($request->toArray(),true) && $model->save() ? true : false;
        
        if($success){
            event(new UpdatedModels($model,UpdatedModels::CREATED));
        }

        $errors = $model->errors();
        
        if(count($errors))
            throw new ModelValidateException($model);

        return [
            'success'=>$success,
            'requestData'=>$parameters,
            'errors'=>$errors
        ];
    }








    /*
    *
    * POST <baseUrl>/api/roles/<id>
    *
    */
    public function update($id,Request $request){
        
        
        $model = Role::find($id);
        
        if(isset($model->id)){

            if(boolval($model->is_system))
                throw new Exception("Role is system entity. You can`t update it!",500);

            $success = $model->fill($request->toArray(),true) && $model->save() ? true : false;
            
            if($success){
                event(new UpdatedModels($model,UpdatedModels::UPDATED));
            }

            $stage=$model->getAttributes();
            
            $errors = $model->errors();
        }else{
            throw new Exception("Stage not found",404);
        }
        
        if(count($errors))
            throw new ModelValidateException($model);

        return [
            'success'=>$success,
            'role'=>$stage,
            'errors'=>$errors
        ];
    }





    /*
    *
    * DELETE <baseUrl>/api/roles/<id>
    *
    */
    public function delete($id){
        
        $model = Role::find($id);
        

        $success = false;

        if(isset($model->id)){
            
            if(boolval($model->is_system))
                throw new Exception("Role is system entity. You can`t delete system role!",500);

            $success = $model->delete();
            if($success){
                event(new UpdatedModels($model,UpdatedModels::DELETED));
            }
        }else{
            throw new Exception("Stage not found",404);
        }

        return [
            'success'=>$success
        ];
    }

}
