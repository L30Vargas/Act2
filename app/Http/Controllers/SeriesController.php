<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Libs\ResultResponse;
use App\Models\Series;

class SeriesController extends Controller
{
    public function index()
    {
        //
        $series = Series::all();

        $resultResponse = new ResultResponse();
        $resultResponse->setData($series);
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
        $validator = $this->validateSerie($request);
        $resultResponse = new ResultResponse();
        try {


            if (is_null($validator)) {
                $newSerie = new Series([
                    'name' => $request->get('name'),
                    'url' => $request->get('url'),
                    'platform_id' => $request->get('platform_id'),
                    'director_id' => $request->get('director_id'),
                    'idiom_id' => $request->get('idiom_id')
                ]);

                $newSerie->save();
                $resultResponse->setData($newSerie);
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
            $series = Series::findOrFail($id);

            $resultResponse->setData($series);
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
            $Search = new Series([
                'text' => $request->get('text')
            ]);

            $text = $Search->text;
            if ($text) {

                $series = Series::where('name', 'like', '%' . $text . '%')
                    ->orWhere('url', 'like', '%' . $text . '%')
                    ->orWhere('platform_id', 'like', '%' . $text . '%')
                    ->orWhere('director_id', 'like', '%' . $text . '%')
                    ->orWhere('idiom_id', 'like', '%' . $text . '%')
                    ->get();
            }
            if ($series->count() == 0) {
                $resultResponse->setData('No hay coincidencia en base de datos');
            } else {
                $resultResponse->setData($series);
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
        $this->validateSerie($request);
        $resultResponse = new ResultResponse();

        try {
            $serie = Series::findOrFail($id);
            $serie->name = $request->get('name', $serie->name);
            $serie->url = $request->get('url', $serie->url);
            $serie->platform_id = $request->get('platform_id', $serie->platform_id);
            $serie->director_id = $request->get('director_id', $serie->director_id);
            $serie->idiom_id = $request->get('idiom_id', $serie->idiom_id);
            $validator = $this->validateSerieParcial($request, $serie->name, $serie->url);
            if (is_null($validator)) {
            $serie->save();
            $resultResponse->setData($serie);
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
        $serie = Series::findOrFail($id);
        $resultResponse = new ResultResponse();
        try {
            $validator = $this->validateSerie($request);
            if (is_null($validator)) {
                $serie->name = $request->get('name');
                $serie->url = $request->get('url');
                $serie->platform_id = $request->get('platform_id');
                $serie->director_id = $request->get('director_id');
                $serie->idiom_id = $request->get('idiom_id');

                $serie->save();

                $resultResponse->setData($serie);
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

            $serie = new Series([
                'name' => $request->get('name'),
                'url' => $request->get('url'),
                'platform_id' => $request->get('platform_id'),
                'director_id' => $request->get('director_id'),
                'idiom_id' => $request->get('idiom_id'),
                'text' => $request->get('text'),
                'campo' => $request->get('campo'),

            ]);

            if ($serie['name'] != Null) {
                $field = 'name';
            } elseif ($serie['url'] != Null) {
                $field = 'url';
            }elseif ($serie['platform_id'] != Null) {
                $field = 'platform_id';
            } elseif ($serie['director_id'] != Null) {
                $field = 'director_id';
            }elseif ($serie['idiom_id'] != Null) {
                $field = 'idiom_id';
            } 

            $serie = Series::where($field, $serie[$field])
                ->update([$serie['campo'] => $serie['text']]);
            if ($serie) {
                $resultResponse->setData($serie);
                $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
            } else {
                $resultResponse->setData('Valor del registro no coincide con la busqueda');
            }
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }
        return response()->json($resultResponse);//
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $resultResponse = new ResultResponse();

        try {
            $serie = Series::findOrFail($id);
            $serie->delete();
            $resultResponse->setData($serie);
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
            $serie = DB::table('series')->delete();
            $resultResponse->setData($serie);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        } catch (\Exception $e) {
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }
        return response()->json($resultResponse);
    }

    private function validateSerie($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255',
            'url' => [
                'required', 'max:255',
                Rule::unique('series', 'url')->where('name', $request->get('name'))
            ],
            'platform_id' => 'numeric',
            'platform_id' => 'numeric',
            'director_id' => 'numeric',
            'idiom_id' => 'numeric',
        ], $messages = [
            'required' => 'El campo :attribute es requerido.',
            'alpha' => 'El formato es incorrecto .',
            'unique' => 'Ya existe la serie ingresada',

        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
    }
    private function validateSerieParcial(Request $request, $name = null, $url = null )
    {
        $validator = Validator::make($request->all(), [
            'name' =>  [
                'max:255',
               Rule::unique('series', 'name')->where('url', $url)
           ],
            'url' => [
                 'max:255',
                Rule::unique('series', 'url')->where('name', $name)
            ],
            'platform_id' => 'numeric',
            'platform_id' => 'numeric',
            'director_id' => 'numeric',
            'idiom_id' => 'numeric',
        ], $messages = [
            'numeric' => 'El campo :attribute es requerido.',
            'alpha' => 'El formato es incorrecto .',
            

        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
    }
}
