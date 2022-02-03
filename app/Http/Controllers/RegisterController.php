<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    public function getTest()
    {
        return "API Test Skytel funcionando!";
    }

    public function postRegister( Request $request )
    {
        $token = "";
        $validacion = true;

        $validacion = $this->validarDatos( $request );

        if ( $validacion !== true) {
            return response()->json([
                'error' => $validacion
            ], 200);
        }

        if ( strtolower($request->email) === "john@smith.com" ) {
            
            return response()->json([
                'error' => 'Correo john@smith.com no admitido'
            ], 200);

        }else{

            $token = $this->generarToken( $request->nombre, $request->apellido, $request->tel, $request->email);

            $this->saveBd( $token );

            return response()->json([
                'token' => $token
            ], 200);
        }


    }

    public function generarToken( $nombre, $apellido, $tel, $mail){

        $token = $this->extraerVocales($nombre) . substr($apellido,0,1) . substr($apellido,-1) . $this->extraerNumPares( $tel );

        return $token;
    }

    public function extraerVocales( $cadena ){

        $arrayVocales = array('a','e','i','o','u');
        $vocalesExtraidas ="";

        for ($i=0; $i < strlen( $cadena ) ; $i++) { 

            for ($j=0; $j < count($arrayVocales) ; $j++) { 
                
                if ( $arrayVocales[$j] == strtolower($cadena[$i]) ) {
                   $vocalesExtraidas .= $cadena[$i];
                }
            }
        }

        return $vocalesExtraidas;
    }

    public function extraerNumPares( $number ){

        $resultado=0;
        $array  = array_map('intval', str_split($number));

        for ($i=0; $i < count($array); $i++) { 
            
            if ( ($array[$i] % 2) == 0) {
                $resultado .= $array[$i];
            }
        }

        return substr( $resultado, 1 );
    }

    public function saveBd( $data ){

        // almacenamos el token generado a la base de datos

    }

    public function validarDatos( $datos ){
        $resultado = true;

        if ($datos->nombre == "") {
            $resultado = "Debes agregar el nombre!";
        }else if ( strlen($datos->nombre) > 25) {
            $resultado = "El nombre solo puede ser mayor a 25 caracteres!";
        }

        if ($datos->apellido == "") {
            $resultado = "Debes agregar el apellido!";
        }else if ( strlen($datos->apellido) > 25) {
            $resultado = "El apellido solo puede ser mayor a 25 caracteres!";
        }

        if ($datos->tel == "") {
            $resultado = "Debes agregar el telefono!";
        }else if ( strlen($datos->tel) > 10 || strlen($datos->tel) < 5) {
            $resultado = "El numero de telefono no puede ser menor a 5 numeros, ni mayor a 10!";
        }

        if ($datos->email == "") {
            $resultado = "Debes agregar el email!";
        }else if ( $this->validateEmail( $datos->email ) == 0 ) {
            $resultado = "El correo electronico no tiene un formato valido!";
        }

        return $resultado;
    }

    public function validateEmail($email) {
        $regex = "/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/";
        return preg_match($regex, $email);
    }

}
