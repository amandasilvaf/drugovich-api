<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientListRequest;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Models\Client;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class ClientController extends Controller
{
    /**
     * Display a paginated list of the resource.
     * @param ClientListRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(ClientListRequest $request)
    {
        try {
            $request->validated();
            $page = $request->input('page', 1);
            $perPage = $request->input('per_page', 50);
        
            $clients = Client::paginate($perPage, ['*'], 'page', $page);
            return response()->json($clients, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientStoreRequest $request)
    {
        try {
            $clients = Client::create($request->validated());
            return response()->json($clients, Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $client = Client::findOrFail($id);
            return response()->json($client, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => "Cliente não encontrado"], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientUpdateRequestt  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientUpdateRequest $request, $id)
    {   
        $client = Client::find($id);
    
        if (!$client) {
            return response()->json(['error' => 'Cliente não encontrado'], Response::HTTP_NOT_FOUND);
        }

        try {
            $client->update($request->validated());
            return response()->json($client->load('group'), Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);
    
        if (!$client) {
            return response()->json(['error' => 'Cliente não encontrado'], Response::HTTP_NOT_FOUND);
        }

        try {
            Client::destroy($id);
            return response()->json(['message' => 'Cliente deletado com sucesso'], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function search($name)
    {
        // $clients = Client::where('name', 'ilike', '%'.$name.'%')->get();
        $clients = Client::whereRaw("name ilike ?", ["%{$name}%"])->get();
        
        if (sizeof($clients) == 0){
            return response()->json(['message' => 'Nenhum cliente encontrado com o termo de busca'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($clients, Response::HTTP_OK);
    }
}
