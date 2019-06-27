<?php


namespace App\Services;


class ValidatorService
{

    public function validarDNI($dni)
    {
        $validacion = true;
        $texto_validacion = 'El DNI introducido no tiene el formato correcto';

        if ($dni != '') {

            $numero = substr($dni, 0, -1);
            $letra = strtoupper(substr($dni, -1));

            // Comprobamos que sea el formato correcto y la letra cumpla el algoritmo
            if (preg_match("/\d{1,8}[a-z]/i", $dni) === 0 ||
                $letra != substr("TRWAGMYFPDXBNJZSQVHLCKE", strtr($numero, "XYZ", "012")%23, 1))
                $validacion = false;

        }else
            $validacion = false;

        return array('estado' => $validacion, 'texto' => $texto_validacion);

    }

}