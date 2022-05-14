<?php

namespace App\Http\Controllers\Panel;

class PanelController
{
    public function __construct(){

    }

    public function index(){

        return view('panel.home');
    }
}
