<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;

final class IndexController extends Controller
{
    public function __invoke(): Factory|View|Application
    {
        return view('index');
    }
}
