<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
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
            //bueno es un misterio sale false pero igual entra
            if(request()->ajax())
            {
                //super importante User::query() de otra forma se hecha una vida
                return datatables()->of(User::query())
                        ->addColumn('action', function($data){
                            $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';

                            $button .= '<button type="button" name="delete" id ="btn-eliminar" data-id="'.$data->id.'" class="btn-eliminar btn btn-danger btn-sm">Borrar</button>';
                            return $button;
                        })
                        ->rawColumns(['action'])
                        ->toJson();
            }


        return view('users.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        dd($user);
        //return redirect()->back();
        //return view('users.show', compact('user'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //dd($user);
        $user = User::find($id);
        $roles = Role::get();

        return view('users.edit');
    }



    public function store(Request $request)
    {
        /*
        $rules = array(
            'first_name'    =>  'required',
            'last_name'     =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        */
        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'     => bcrypt($request->password),

        ]);


        return response()->json(['success' => 'Data Added successfully.']);


        /*//dd($request);
        if ($request->ajax()) {



           return "fino";

        }else {
            return "yahora";
        }*/
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {/*
        $user = User::find($id);
        $user->update($request->all());

        $user->roles()->sync($request->get('roles'));

        return redirect()->route('users.edit', [$user])
            ->with('info', 'Usuario guardado con éxito');*/

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        //dd($request);
        //dd($request->ajax());
        if ($request->ajax()) {



            $user = User::find($id);
            //dd($user);
            $user->delete();
            //return Response::json($user);
            //$total_product=Product::all()->count();

        }else {
            return "yahora";
        }

    }
}
