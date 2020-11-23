<?php


namespace App\Managers;

use Illuminate\Database\Eloquent\Model;

interface ManagerInterface
{
    public function getAll();
    public function getById(int $id);
}
