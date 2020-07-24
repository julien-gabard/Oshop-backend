<?php

namespace App\Controllers;

use App\Controllers\CoreController;

abstract class CrudController extends CoreController
{
    // Interface CRUD
    abstract public function list();
    abstract public function add();
    abstract public function edit($id);
    abstract public function createAndUpdate();
    abstract public function delete($id);
}