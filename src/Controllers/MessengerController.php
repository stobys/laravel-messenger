<?php

namespace Aheenam\Test\Controllers;

use Illuminate\Routing\Controller;

class MessengerController extends Controller
{

    /**
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('messenger::index', [
            'name' => $name
        ]);
    }

}