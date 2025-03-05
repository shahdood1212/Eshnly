<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

class ClientController extends Controller
{
    
    public function index()
    {
        $clients = Client::all();
        return ClientResource::collection($clients);
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:15',
        ]);

        $client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // تشفير الباسورد
            'phone' => $request->phone,
        ]);

        return new ClientResource($client);
    }

    
    public function show(Client $client)
    {
        return new ClientResource($client);
    }

    
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:clients,email,' . $client->id,
            'password' => 'sometimes|string|min:6',
            'phone' => 'sometimes|string|max:15',
        ]);

        $data = $request->only(['name', 'email', 'phone']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $client->update($data);
        return new ClientResource($client);
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return response()->json(['message' => 'Client deleted successfully'],200);
    }
}
