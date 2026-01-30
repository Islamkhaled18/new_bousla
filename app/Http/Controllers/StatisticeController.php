<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StatisticeController extends Controller
{
    public function statistices()
    {
         $doctors = User::activeDoctors()
        ->withCount('favoritedBy')
        ->orderBy('favorited_by_count', 'desc')
        ->get();

        return view('admin.statistices.index', compact('doctors'));
    }
}
