<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Libs\ResultResponse;
use App\Models\Idioms;


class IdiomsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $idioms = Idioms::all();

        $resultResponse = new ResultResponse();
        $resultResponse->setData($idioms);
        $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
        $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        return response()->json($resultResponse);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = $this->validateIdiom($request);
        $resultResponse = new ResultResponse();
        try {


            if (is_null($validator)) {
                $newIdiom = new Idioms([
                    'name' => $request->get('name'),
                    'isocode' => $request->get('isocode'),

                ]);

                $newIdiom->save();
                $resultResponse->setData($newIdiom);
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
            $idioms = Idioms::findOrFail($id);

            $resultResponse->setData($idioms);
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

            $Search = new Idioms([
                'text' => $request->get('text')
            ]);

            $text = $Search->text;
            if ($text) {

                $idioms = Idioms::where('name', 'like', '%' . $text . '%')
                    ->orWhere('isocode', 'like', '%' . $text . '%')
                    ->get();
            }
            if ($idioms->count() == 0) {
                $resultResponse->setData('No hay coincidencia en base de datos');
            } else {
                $resultResponse->setData($idioms);
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
            $idiom = Idioms::findOrFail($id);
            $idiom->name = $request->get('name', $idiom->name);
            $idiom->isocode = $request->get('isocode', $idiom->isocode);
            
            $validator = $this->validateIdiomParcial($request, $idiom->name, $idiom->isocode);
            if (is_null($validator)) {
                $idiom->save();
                $resultResponse->setData($idiom);
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
        $idiom = Idioms::findOrFail($id);
        $resultResponse = new ResultResponse();

        try {
            $validator = $this->validateIdiom($request);
            if (is_null($validator)) {
                $idiom->name = $request->get('name');
                $idiom->isocode = $request->get('isocode');
                $idiom->save();

                $resultResponse->setData($idiom);
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
            $idiom = Idioms::findOrFail($id);
            $idiom->delete();
            $resultResponse->setData($idiom);
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
            $idiom = DB::table('idioms')->delete();
            $resultResponse->setData($idiom);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }
        return response()->json($resultResponse);
    }




    private function validateIdiom($request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|alpha|min:4|max:20',
            'isocode' => [
                'required', 'alpha', 'max:20',
                Rule::unique('idioms', 'isocode')->where('name', $request->get('name'))
            ],
        ], $messages = [
            'required' => 'El campo :attribute es requerido.',
            'alpha' => 'El formato es incorrecto .',
            'unique' => 'Ya existe el nombre e isocode ingresado',

        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
    }
    private function validateIdiomParcial($request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'alpha|min:4|max:20',
            'isocode' => [
                 'alpha', 'max:20',
                Rule::unique('idioms', 'isocode')->where('name', $request->get('name'))
            ],
        ], $messages = [
            'alpha' => 'El formato es incorrecto .',
            'unique' => 'Ya existe el nombre e isocode ingresado',

        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
    }
}
