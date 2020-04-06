<?php
namespace App\Http\Composers;

use App\ColorSetting;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class ColorComposer{

    public function __construct()
    {

    }

    public function compose(View $view)
    {
        $view->with('colors',ColorSetting::orderBy('id')->get());
    }
}
