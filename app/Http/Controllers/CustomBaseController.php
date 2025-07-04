<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class CustomBaseController extends BaseController
{
    /**
     * Método declarado para evitar errores de Intelephense.
     */
    public function middleware($middleware, array $options = [])
    {
        return parent::middleware($middleware, $options);
    }
}
