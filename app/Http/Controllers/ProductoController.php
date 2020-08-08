<?php

namespace App\Http\Controllers;

use App\Producto;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Validator;




class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=Auth::user();


        //dd(request()->ajax());

        if(request()->ajax())
        {
            //super importante User::query() de otra forma se hecha una vida
            return datatables()->of(Producto::query())
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';

                        $button .= '<button type="button" name="delete" id ="btn-eliminar"    data-id="'.$data->id.'" class="btn-eliminar btn btn-danger btn-sm">Borrar</button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->toJson();
        }


        return view('productos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return "tiene permiso de crear";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if ($request->ajax()) {

            $rules = array(
                //valida que el campo sea unico en la tabla
                'nombre'     =>  'required|unique:productos',
                'precio'     =>  'required|numeric'
            );


            $messages = [
                'nombre.required' => 'El campo nombre no puede estar vacio.',
                'nombre.unique' =>'El nombre del producto  ya se encuentra registrado.',
                'precio.required' => 'Agrega un precio al producto.',
                'precio.numeric' => 'El precio debe ser un número'
            ];

            $error = Validator::make($request->all(), $rules,$messages);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }

            Producto::create([
                'nombre'      => $request->nombre,
                'precio'     => $request->precio,

            ]);


            return response()->json(['success' => 'Data Added successfully.']);
        }else {
            return redirect()->back()->withInput();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        return "tiene permiso de ver";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        return "tiene permiso de editar";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        return "tiene permiso para actualizar";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        //dd($request);


        //$decrypted = Crypt::decrypt($id);


        if ($request->ajax()) {

            try {
                $producto = Producto::find( $id);
                //dd($producto);
                $producto->delete();
            } catch (\Throwable $th) {
                return "algo salio mal";
            }







        }else {
            return "es muy importante el header del token en el scrip aqui deberia redirigir con un try a una 404";
        }

    }
}
