<?php

namespace Modules\Clients\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\Clients\app\Transformers\DoctorFilterResource;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');

        $doctors = User::activeDoctors()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'LIKE', "%{$search}%")
                        ->orWhere('last_name', 'LIKE', "%{$search}%")
                        ->orWhere('public_name', 'LIKE', "%{$search}%")
                        ->orWhereHas('jobTitle', function ($q) use ($search) {
                            $q->where('name', 'LIKE', "%{$search}%");
                        });
                });
            })
            ->with(['jobTitle', 'area'])
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => [
                'doctors' => DoctorFilterResource::collection($doctors),
            ],
        ], 200);
    }
}
