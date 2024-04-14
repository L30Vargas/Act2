<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Libs\ResultResponse;
use App\Models\Platforms;


class PlatformsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $Platforms = Platforms::all();

        $resultResponse = new ResultResponse();
        $resultResponse->setData($Platforms);
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

            // Check the DB if the data is not duplicated

            if (is_null($validator)) {
                $newPlatform = new Platforms([
                    'name' => $request->get('name'),
                ]);

                $newPlatform->save();
                $resultResponse->setData($newPlatform);
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
            $Platforms = Platforms::findOrFail($id);

            $resultResponse->setData($Platforms);
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
            $Search = new Platforms([
                'text' => $request->get('text')
            ]);

            $text = $Search->text;
            if ($text) {

                $platforms = Platforms::where('name', 'like', '%' . $text . '%')
                    ->get();
            }
            if ($platforms->count() == 0) {
                $resultResponse->setData('No hay coincidencia en base de datos');
            } else {
                $resultResponse->setData($platforms);
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
            $platform = Platforms::findOrFail($id);
            $platform->name = $request->get('name', $platform->name);
            $validator = $this->validatePlatformParcial($request, $platform->name, $platform->lastname);
            if (is_null($validator)) {
                $platform->save();
                $resultResponse->setData($platform);
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
        $platform = Platforms::findOrFail($id);
        $resultResponse = new ResultResponse();

        try {
            $validator = $this->validateActor($request);
            if (is_null($validator)) {
               
                $platform->name = $request->get('name');
                $platform->save();
                $resultResponse->setData($platform);
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
            $platform = Platforms::findOrFail($id);
            $platform->delete();
            $resultResponse->setData($platform);
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
            $platfom = DB::table('platforms')->delete();
            $resultResponse->setData($platfom);
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
            'name' => 'required|min:4|max:20|unique:platforms',
        ], $messages = [
            'required' => 'El campo :attribute es requerido.',
            'date_format:Y-m-d' => 'El formato es incorrecto .',
            'alpha' => 'El formato es incorrecto .',
            'unique' => 'La plataforma ya existe',

        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
    }

    private function validatePlatformParcial(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4|max:20|unique:platforms',
        ], $messages = [
            'required' => 'El campo :attribute es requerido.',
            'date_format:Y-m-d' => 'El formato es incorrecto .',
            'alpha' => 'El formato es incorrecto .',
            'unique' => 'La plataforma ya existe',

        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
    }
}
