<?php


namespace App\Services;


use App\Managers\IncidenciaManager;

class CodeGenerator
{
	private $incidenciaManager;

	public function __construct(IncidenciaManager $incidenciaManager)
	{
		$this->incidenciaManager = $incidenciaManager;
	}

//	public function getCode($entity, $year)
//	{
//
//	}
}