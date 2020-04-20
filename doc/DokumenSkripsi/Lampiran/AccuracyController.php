<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccuracyController extends Controller
{
    public function calculateMAE($arr)
    {
        return array_sum($arr) / count($arr);
    }

    public function calculateRMSE($arr)
    {
        return sqrt(array_sum($arr) / count($arr));
    }
}
