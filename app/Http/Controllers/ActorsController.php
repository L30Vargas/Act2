<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Libs\ResultResponse;
use App\Models\Actors;
use Illuminate\Validation\Rule;


class ActorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        //
        $actors = Actors::all();

        $resultResponse = new ResultResponse();
        $resultResponse->setData($actors);
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

            // $duplicate = Actors::where([['name', '=', $request->get('name')], ['lastname', '=', $request->get('lastname')]])->doesntExist();

            if (is_null($validator)) {
                $newActor = new Actors([
                    'name' => $request->get('name'),
                    'lastname' => $request->get('lastname'),
                    'DoB' => $request->get('DoB'),
                    'nacionalidad' => $request->get('nacionalidad')
                ]);
                $newActor->save();
                $resultResponse->setData($newActor);
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
            $actors = Actors::findOrFail($id);

            $resultResponse->setData($actors);
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
            $Search = new Actors([
                'text' => $request->get('text')
            ]);

            $text = $Search->text;
            if ($text) {
                $actors = Actors::where('name', 'like', '%' . $text . '%')
                    ->orWhere('lastname', 'like', '%' . $text . '%')
                    ->orWhere('DoB', 'like', '%' . $text . '%')
                    ->orWhere('nacionalidad', 'like', '%' . $text . '%')
                    ->get();
            }
            if ($actors->count() == 0) {
                $resultResponse->setData('No hay coincidencia en base de datos');
            } else {
                $resultResponse->setData($actors);
                $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
            }
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }

        return response()->json($resultResponse); //$actors);//
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function patch(Request $request, $id)
    {
        //

        $resultResponse = new ResultResponse();

        try {
            $actor = Actors::findOrFail($id);
            $actor->name = $request->get('name', $actor->name);
            $actor->lastname = $request->get('lastname', $actor->lastname);
            $actor->DoB = $request->get('DoB', $actor->DoB);
            $actor->nacionalidad = $request->get('nacionalidad', $actor->nacionalidad);

            $validator = $this->validateActorParcial($request, $actor->name, $actor->lastname);
            if (is_null($validator)) {
                $actor->save();
                $resultResponse->setData($actor);
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
        $actor = Actors::findOrFail($id);
        $resultResponse = new ResultResponse();
        try {
            $validator = $this->validateActor($request);
            if (is_null($validator)) {

                $actor->name = $request->get('name');
                $actor->lastname = $request->get('lastname');
                $actor->DoB = $request->get('DoB');
                $actor->nacionalidad = $request->get('nacionalidad');
                $actor->save();

                $resultResponse->setData($actor);
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

            $actor = new Actors([
                'name' => $request->get('name'),
                'lastname' => $request->get('lastname'),
                'DoB' => $request->get('DoB'),
                'nacionalidad' => $request->get('nacionalidad'),
                'campo' => $request->get('campo'),
                'text' => $request->get('text'),
            ]);

            if ($actor['name'] != Null) {
                $field = 'name';
            } elseif ($actor['lastname'] != Null) {
                $field = 'lastname';
            } elseif ($actor['DoB'] != Null) {
                $field = 'DoB';
            } elseif ($actor['nacionalidad'] != Null) {
                $field = 'nacionalidad';
            }

            $actor = Actors::where($field, $actor[$field])
                ->update([$actor['campo'] => $actor['text']]);

            if ($actor) {
                $resultResponse->setData($actor);
                $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
            } else {
                $resultResponse->setData('Valor del registro no coincide con la busqueda');
            }
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }
        return response()->json($resultResponse); //$request);//
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $resultResponse = new ResultResponse();

        try {
            $actor = Actors::findOrFail($id);
            $actor->delete();
            $resultResponse->setData($actor);
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
            $actor = DB::table('actors')->delete();
            $resultResponse->setData($actor);
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
                Rule::unique('actors', 'lastname')->where('name', $request->get('name'))
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

    private function validateActorParcial(Request $request, $name = null, $lastname = null)
    {


        $validator = Validator::make($request->all(), [
            'name' => [
                'alpha', 'min:4', 'max:20',
                Rule::unique('actors', 'name')->where('lastname', $lastname)
            ],
            'lastname' => [
                'alpha', 'min:4', 'max:20',
                Rule::unique('actors', 'lastname')->where('name', $name)
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
