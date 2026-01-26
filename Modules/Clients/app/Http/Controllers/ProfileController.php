<?php

namespace Modules\Clients\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Clients\app\Http\Requests\ProfileRequest;
use App\Services\FileUploadService;

class ProfileController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }


    // ProfileController.php
    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'type' => 'client',
            'gender' => $request->gender,
            'id_number' => $request->id_number,
        ];

        if ($request->filled('password') && $request->filled('current_password')) {
            $data['password'] = Hash::make($request->password);
        }

        $oldImage = $user->personal_image;

        if ($request->hasFile('personal_image')) {
            $file = $request->file('personal_image');
           
            $path = $this->fileUploadService->upload($file, 'clients/' . $user->id, 'public');
            $data['personal_image'] = $path;
        }

        $user->update($data);

        // Delete old image after successful update
        if ($request->hasFile('personal_image') && $oldImage) {
            $this->fileUploadService->delete($oldImage, 'public');
        }

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث البيانات بنجاح',
        ], 200);
    }
}
