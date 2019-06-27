<?php

namespace App\Interfaces;

interface ManagerInterface
{
    public function newObject();
    public function create($object);
    public function update($object);
    public function delete($object);
}