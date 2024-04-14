<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Libs\ResultResponse;
use App\Models\actSer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ActSerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    public function index()
    {
        //
        $actSer = actSer::all();

        $resultResponse = new ResultResponse();
        $resultResponse->setData($actSer);
        $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
        $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        return response()->json($resultResponse);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = $this->validateActser($request);
        $resultResponse = new ResultResponse();
        try {
            if (is_null($validator)) {
                    $newActser = new actSer([
                    'actor_id' => $request->get('actor_id'),
                    'serie_id' => $request->get('serie_id'),
                 
                ]);

                $newActser->save();

                $resultResponse->setData($newActser);
                $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
            } else {
                $resultResponse->setData($validator);
            }
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }
        return response()->json($resultResponse);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        try {
            $resultResponse = new ResultResponse();
            $actSer = actSer::findOrFail($id);

            $resultResponse->setData($actSer);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }

        return response()->json($resultResponse);
    }

    public function detail(Request $request)
    {
        $resultResponse = new ResultResponse();
        try {
            $Search = new actSer([
                'text' => $request->get('text')
            ]);
            $text = $Search->text;
            if ($text) {
                $actser = actSer::where('actor_id', '=', $text )
                    ->orWhere('serie_id', '=',  $text )
                   ->get();
            }
            if ($actser->count() == 0) {
                $resultResponse->setData('No hay coincidencia en base de datos');
            } else {
                $resultResponse->setData($actser);
                $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
            }} catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }

        return response()->json($resultResponse);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function patch(Request $request, $id)
    {
        //
         
        $resultResponse = new ResultResponse();


        try {
            $actser = actSer::findOrFail($id);
            $actser->actor_id = $request->get('actor_id', $actser->actor_id);
            $actser->serie_id = $request->get('serie_id', $actser->serie_id);
            $validator = $this->validateActSerParcial($request);
            if (is_null($validator)) {
            $actser->save();

            $resultResponse->setData($actser);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        } else {
            $resultResponse->setData($validator);
        }
        
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }
        return response()->json($resultResponse);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $actser = actSer::findOrFail($id);
        $resultResponse = new ResultResponse();
        try {

            $validator =  $this->validateActser($request);
            if (is_null($validator)) {
            $actser->actor_id = $request->get('actor_id');
            $actser->serie_id = $request->get('serie_id');
          
            $actser->save();

            $resultResponse->setData($actser);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        } else {
            $resultResponse->setData($validator);
        }
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }
        return response()->json($resultResponse);
    }

    public function bulkUpdate(Request $request)
    {
     
        $resultResponse = new ResultResponse();
        try {

            $actser = new actSer([
                'actor_id' => $request->get('actor_id'),
                'serie_id' => $request->get('serie_id'),
                'campo' => $request->get('campo'),
                'text' => $request->get('text'),
                
            ]);
            if ($actser['actor_id'] != Null) {
                $field = 'actor_id';
            } elseif ($actser['serie_id'] != Null) {
                $field = 'serie_id';}
          
            $actser = actSer::where($field, $actser[$field])
                     ->update([$actser['campo'] => $actser['text']]);

                $resultResponse->setData($actser);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }
        return response()->json($resultResponse);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $resultResponse = new ResultResponse();

        try {
            $actser = Actser::findOrFail($id);
            $actser->delete();
            $resultResponse->setData($actser);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }
        return response()->json($resultResponse);
    }

    public function destroyAll()
    {
        //
        $resultResponse = new ResultResponse();

        try {
            $actser = DB::table('act_sers')->delete();
            $resultResponse->setData($actser);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }
        return response()->json($resultResponse);
    }

    private function validateActser($request)
    {
        $validator = Validator::make($request->all(), [
            'actor_id' => 'required|numeric',
            'serie_id' => ['required','numeric',
        Rule::unique('act_sers','serie_id')->where('actor_id',$request->get('actor_id'))],
          
        ], $messages = [
            'required' => 'El campo :attribute es requerido.',
            'unique' => 'La relacion actorid y serieid ya ha sido registrada'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
    }

    private function validateActSerParcial(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'actor_id' => 'numeric',
            'serie_id' => ['numeric',
        Rule::unique('act_sers','serie_id')->where('actor_id',$request->get('actor_id'))],
          
        ], $messages = [
            'unique' => 'La relacion actorid y serieid ya ha sido registrada'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
    }
}
