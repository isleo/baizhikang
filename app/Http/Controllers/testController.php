<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Validation\Factory as Validator;

class testController extends Controller
{
    public function test() {
        $validator = new Validator();
        $validator->make(['title' => 3], [
            'title' => 'required',
            'body' => 'required',
        ]);
        dd('sfsdfsdf');
    }
}
