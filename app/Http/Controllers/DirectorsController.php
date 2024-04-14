<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Libs\ResultResponse;
use App\Models\Directors;
use Illuminate\Validation\Rule;

class DirectorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $Directors = Directors::all();

        $resultResponse = new ResultResponse();
        $resultResponse->setData($Directors);
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
        $validator = $this->validateActor($request);
        $resultResponse = new ResultResponse();

        try {


            if (is_null($validator)) {
                $newDirector = new Directors([
                    'name' => $request->get('name'),
                    'lastname' => $request->get('lastname'),
                    'DoB' => $request->get('DoB'),
                    'nacionalidad' => $request->get('nacionalidad')
                ]);
                $newDirector->save();
                $resultResponse->setData($newDirector);
                $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
            } else {
                $resultResponse->setData($validator);
            }
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }
        return response()->json($resultResponse); //$validator);//  
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        try {
            $resultResponse = new ResultResponse();
            $Directors = Directors::findOrFail($id);

            $resultResponse->setData($Directors);
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
            $Search = new Directors([
                'text' => $request->get('text')
            ]);

            $text = $Search->text;
            if ($text) {

                $directors = Directors::where('name', 'like', '%' . $text . '%')
                    ->orWhere('lastname', 'like', '%' . $text . '%')
                    ->orWhere('DoB', 'like', '%' . $text . '%')
                    ->orWhere('nacionalidad', 'like', '%' . $text . '%')
                    ->get();
            }
            if ($directors->count() == 0) {
                $resultResponse->setData('No hay coincidencia en base de datos');
            } else {
                $resultResponse->setData($directors);
                $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
            }
        } catch (\Exception $e) {
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
            $director = Directors::findOrFail($id);
            $director->name = $request->get('name', $director->name);
            $director->lastname = $request->get('lastname', $director->lastname);
            $director->DoB = $request->get('DoB', $director->DoB);
            $director->nacionalidad = $request->get('nacionalidad', $director->nacionalidad);
            $director->save();
            $validator = $this->validateDirectorParcial($request, $director->name, $director->lastname);
            if (is_null($validator)) {
            $resultResponse->setData($director);
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

            $director = new Directors([
                'name' => $request->get('name'),
                'lastname' => $request->get('lastname'),
                'DoB' => $request->get('DoB'),
                'nacionalidad' => $request->get('nacionalidad'),
                'campo' => $request->get('campo'),
                'text' => $request->get('text'),
            ]);

            if ($director['name'] != Null) {
                $field = 'name';
            } elseif ($director['lastname'] != Null) {
                $field = 'lastname';
            } elseif ($director['DoB'] != Null) {
                $field = 'DoB';
            } elseif ($director['nacionalidad'] != Null) {
                $field = 'nacionalidad';
            }



            $director = Directors::where($field, $director[$field])
                ->update([$director['campo'] => $director['text']]);
            if ($director) {
                $resultResponse->setData($director);
                $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
            } else {
                $resultResponse->setData('Valor del registro no coincide con la busqueda');
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
        $director = Directors::findOrFail($id);


        $resultResponse = new ResultResponse();
        try {
            $validator = $this->validateActor($request);
            if (is_null($validator)) {

                $director->name = $request->get('name');
                $director->lastname = $request->get('lastname');
                $director->DoB = $request->get('DoB');
                $director->nacionalidad = $request->get('nacionalidad');
                $director->save();

                $resultResponse->setData($director);
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
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $resultResponse = new ResultResponse();

        try {
            $director = Directors::findOrFail($id);
            $director->delete();
            $resultResponse->setData($director);
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
            $director = DB::table('directors')->delete();
            $resultResponse->setData($director);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }
        return response()->json($resultResponse);
    }

    private function validateActor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|alpha|min:4|max:20',
            'lastname' => [
                'required', 'alpha', 'max:20',
                Rule::unique('directors', 'lastname')->where('name', $request->get('name'))
            ],
            'DoB' => 'required|date_format:Y-m-d',
            'nacionalidad' => 'required|alpha'
        ], $messages = [
            'required' => 'El campo :attribute es requerido.',
            'date_format:Y-m-d' => 'El formato es incorrecto .',
            'alpha' => 'El formato es incorrecto .',
            'unique' => 'Ya existe el nombre y apellido ingresado',

        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
    }

    private function validateDirectorParcial(Request $request, $name = null, $lastname = null)
    {


        $validator = Validator::make($request->all(), [
            'name' => [
                'alpha', 'min:4', 'max:20',
                Rule::unique('directors', 'name')->where('lastname', $lastname)
            ],
            'lastname' => [
                'alpha', 'min:4', 'max:20',
                Rule::unique('directors', 'lastname')->where('name', $name)
            ],
            'DoB' => 'date_format:Y-m-d',
            'nacionalidad' => 'alpha|min:4|max:255',
        ], $messages = [
            'date_format:Y-m-d' => 'El formato es incorrecto .',
            'alpha' => 'El formato es incorrecto .',
            'unique' => 'Ya existe el nombre y apellido ingresado',

        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
    }
}
