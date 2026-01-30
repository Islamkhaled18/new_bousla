<?php

namespace Modules\Clients\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\Clients\app\Transformers\DoctorByJobTitleResource;

class FavoriteController extends Controller
{
    /**
     * Toggle favorite (add/remove)
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id'
        ]);

        $clientId = auth()->id();
        $doctorId = $request->doctor_id;

       
        $doctor = User::where('id', $doctorId)
            ->where('type', 'doctor')
            ->first();

        if (!$doctor) {
            return response()->json([
                'success' => false,
                'message' => 'الطبيب غير موجود'
            ], 404);
        }

      
        $favorite = Favorite::where('client_id', $clientId)
            ->where('doctor_id', $doctorId)
            ->first();

        if ($favorite) {
         
            $favorite->delete();
            return response()->json([
                'success' => true,
                'message' => 'تم حذف الطبيب من المفضله',
                'is_favorite' => false
            ]);
        } else {
           
            Favorite::create([
                'client_id' => $clientId,
                'doctor_id' => $doctorId
            ]);
            return response()->json([
                'success' => true,
                'message' => 'تم اضافة الطبيب للمفضله',
                'is_favorite' => true
            ]);
        }
    }

    /**
     * Get all favorites for current client
     */
    public function index()
    {
        $favorites = auth()->user()
            ->favorites()
            ->with(['jobTitle', 'area'])
            ->get();

        return response()->json([
            'success' => true,
            'data' =>  DoctorByJobTitleResource::collection($favorites)
        ]);
    }

    /**
     * Check if doctor is favorite
     */
    public function check($doctorId)
    {
        $isFavorite = Favorite::where('client_id', auth()->id())
            ->where('doctor_id', $doctorId)
            ->exists();

        return response()->json([
            'success' => true,
            'is_favorite' => $isFavorite
        ]);
    }
}
