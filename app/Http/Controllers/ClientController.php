<?php

namespace App\Http\Controllers;

use App\Models\Client;
// use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Qué información queremos tomar
        $clients = Client::paginate(5);
        // Retornamos lo que queremos ver en la vista
        return view('client.index')->with('clients', $clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:15',
            'due' => 'required|gte:1'
        ]);

        // Paso, como parámetro, todo lo necesario para que haga la inserción en la base de datos.
        // only() es para que no se manden parámetros adicionales de la estructura que no son parte de la estructura del modelo.
        // Forma masiva
        $client = Client::create($request->only('name', 'due', 'comments'));
        // Confirmación de registro exitoso
        Session::flash('mensaje', 'Registro guardado con éxito!');
        // Retorno a /client
        return redirect()->route('client.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('client.form')->with('client', $client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required|max:15',
            'due' => 'required|gte:1'
        ]);

        // Forma individual
        $client->name = $request['name'];
        $client->due = $request['due'];
        $client->comments = $request['comments'];

        // Guardando en base de datos (persistencia)
        $client->save();

        // Confirmación de registro exitoso
        Session::flash('mensaje', 'Registro editado con éxito!');
        // Retorno a /client
        return redirect()->route('client.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();

        // Confirmación de registro exitoso
        Session::flash('mensaje', 'Registro Eliminado con Éxito!');
        // Retorno a /client
        return redirect()->route('client.index');
    }
}
