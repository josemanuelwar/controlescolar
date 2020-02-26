<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\http\Responses;
use Illuminate\Support\Facades\DB;
class loginController extends Controller
{
    /*
    **
    **funcion de ingreso al sistema
    **
    */    
    public function Login(Request $request)
    {
    	$ban=0;
    	if($request->input('Nombre') == null)
    	{
    		$ban=1;
    	}
    	if ($request->input('password') == null) {
    		
    		$ban=1;
    	}

    	if ( $ban == 1) {

    		return redirect('/');
    	}
    	else
    	{
    		$nombre=$request->input('Nombre');
            $password=$request->input('password');
            $email= DB::table('users')->where('email',$nombre)->first();
            
            if ($email  === null) {
                
                echo "no existe el usuario";
             	return redirect('/');
            }
            else
            {
            	if ($email->password == $password) {
                     $value = $request->session()->get('key');
                     //dd($value);
                return redirect('inicio');

            	}	
            }
            
    	}

    }
/*
**
**Registro de usuarios de administracion del sistema
**
*/
    public function Registro(Request $request)
    {
    	$ban=0;
    	
    	if($request->input('Nombre') == null)
    	{
    		$ban=1;
    	}
    	if ($request->input('corre') == null) {
    		
    		$ban=1;
    	}
    	if ($request->input('password') == null) {
    		
    		$ban=1;
    	}

    	if ($ban == 1) {
    		
    		return redirect('Registro');
    	}
    	else
    	{
    		$user = new User;
    		$user->name = $request->input('Nombre');
    		$user->email = $request->input('corre');
    		$user->password = $request->input('password');
    		$user->save();
    		return redirect('/');
    	}
    }
}
