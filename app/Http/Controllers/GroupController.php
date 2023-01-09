<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupListRequest;
use App\Http\Requests\GroupStoreRequest;
use App\Http\Requests\GroupUpdateRequest;
use App\Models\Client;
use App\Models\Group;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  GroupListRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(GroupListRequest $request)
    {
        try {
            $request->validated();
            $page = $request->input('page', 1);
            $perPage = $request->input('per_page', 50);
        
            $groups = Group::paginate($perPage, ['*'], 'page', $page);
            return response()->json($groups, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  GroupStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupStoreRequest $request)
    {
        try {
            $group = Group::create($request->validated());
            return response()->json($group, Response::HTTP_CREATED);
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
            $group = Group::findOrFail($id);
            return response()->json($group, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => "Grupo não encontrado"], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GroupUpdateRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GroupUpdateRequest $request, $id)
    {
        $group = Group::find($id);
    
        if (!$group) {
            return response()->json(['error' => 'Grupo não encontrado'], Response::HTTP_NOT_FOUND);
        }

        try {
            $group->update($request->validated());
            return response()->json($group, Response::HTTP_OK);
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
        $group = Group::find($id);
    
        if (!$group) {
            return response()->json(['error' => 'Grupo não encontrado'], Response::HTTP_NOT_FOUND);
        }

        try {
            Group::destroy($id);
            return response()->json(['message' => 'Grupo deletado com sucesso'], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
 
    }


    public function search($name)
    {
        $groups = Group::where('name', 'ilike', '%'.$name.'%')->get();
        
        if (sizeof($groups) == 0){
            return response()->json(['message' => 'Nenhum grupo encontrado com o termo de busca'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($groups, Response::HTTP_OK);
    }


    public function addClient($groupId, $clientId)
    {
        $group = Group::find($groupId);
        $client = Client::find($clientId);

        $clientAlreadyBelongToGroup = $client->group_id == $groupId;
        $clientAlreadyHasAnyGroup = $client->group_id;

        if (!$group) {
            return response()->json(['error' => 'Grupo não encontrado'], Response::HTTP_NOT_FOUND);
        }
        if (!$client) {
            return response()->json(['error' => 'Cliente não encontrado'], Response::HTTP_NOT_FOUND);
        }
        if($clientAlreadyBelongToGroup){
            return response()->json(['message' => 'Cliente já pertence a este grupo'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if($clientAlreadyHasAnyGroup){
            return response()->json(['message' => 'Cliente já pertence a um grupo. Remova-o de seu grupo primeiro. '], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $client->group()->associate($group);
            $client->save();
            $response = [
                'message' => 'Cliente adicionado ao grupo com sucesso',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function removeClient($groupId, $clientId)
    {
        $group = Group::find($groupId);
        $client = Client::find($clientId);

        $clientBelongToGroup = $client->group_id == $groupId;
    
        if (!$group) {
            return response()->json(['error' => 'Grupo não encontrado'], Response::HTTP_NOT_FOUND);
        }
        if (!$client) {
            return response()->json(['error' => 'Cliente não encontrado'], Response::HTTP_NOT_FOUND);
        }
        if(!$clientBelongToGroup){
            return response()->json(['error' => 'O Cliente informado não pertence ao grupo'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        try {
            $client->group()->dissociate($group);
            $client->save();
            return response()->json(['message' => 'Cliente removido do grupo com sucesso.'], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function listClients($groupId)
    {
        $group = Group::find($groupId);

        if (!$group) {
            return response()->json(['error' => 'Grupo não encontrado'], Response::HTTP_NOT_FOUND);
        }
        try{
            $clients = Group::with('clients')->find($groupId);
            return response()->json($clients, Response::HTTP_OK);
        }catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
}
