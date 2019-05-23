<?php


namespace App\Services;


class MessageGenerator
{

    private $texto;

    public function __construct($texto)
    {
        $this->texto = $texto;
    }

    public function getMensajeIncidencia()
    {
        $mensaje = 'Pero mira que mensaje más majo!!';

        return $mensaje;
    }

    public function comprobarTexto($texto = null)
    {
//        return strpos($texto, 'inci');
        return strpos($texto, $this->texto);
    }
}