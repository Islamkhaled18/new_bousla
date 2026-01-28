<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\JobTitle;
use App\Models\User;
use App\Traits\ToggleStatusTrait;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    use ToggleStatusTrait;

    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index()
    {
        $doctors = User::where('type', 'doctor')->where('status', 'accepted')
            ->orderBy('id', 'DESC')
            ->paginate(15);

        return view('admin.doctors.index', compact('doctors'));
    }

    public function show(User $doctor)
    {
        $doctor->load('roles', 'jobTitle', 'area', 'images');
        $job_titles = JobTitle::where('is_active', 1)->get();
        $areas = Area::where('is_active', 1)->get();
        return view('admin.doctors.show', compact('doctor', 'job_titles', 'areas'));
    }

    public function destroy(User $doctor)
    {

        DB::beginTransaction();
        try {
            $imagesToDelete = [];

            $imageFields = [
                'personal_image',
                'logo',
                'id_image_front',
                'id_image_back',
                'graduation_certificate',
                'professional_license',
                'syndicate_card'
            ];

            foreach ($imageFields as $field) {
                if ($doctor->$field) {
                    $imagesToDelete[] = $doctor->$field;
                }
            }

            foreach ($doctor->images as $image) {
                $imagesToDelete[] = $image->photo;
            }

            $doctor->delete();

            DB::commit();

            foreach ($imagesToDelete as $imagePath) {
                $this->fileUploadService->delete($imagePath, 'public');
            }

            return redirect()->route('doctors.index')
                ->with('success', 'تم حذف المشرف بنجاح');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'حدث خطأ أثناء الحذف');
        }
    }

    public function toggleStatus(User $doctor)
    {
        return $this->toggleStatusModel($doctor);
    } //end of toggleStatus
}
