<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\JobTitle;
use App\Models\User;
use App\Traits\ToggleStatusTrait;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    use ToggleStatusTrait;

    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index()
    {
        $clients = User::where('type', 'client')
            ->orderBy('id', 'DESC')
            ->paginate(15);

        return view('admin.clients.index', compact('clients'));
    }

    public function show(User $client)
    {
        $client->load('images');
        $job_titles = JobTitle::where('is_active', 1)->get();
        $areas = Area::where('is_active', 1)->get();
        return view('admin.clients.show', compact('client', 'job_titles', 'areas'));
    }

    public function destroy(User $client)
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
                if ($client->$field) {
                    $imagesToDelete[] = $client->$field;
                }
            }

            foreach ($client->images as $image) {
                $imagesToDelete[] = $image->photo;
            }

            $client->delete();
            DB::commit();

            foreach ($imagesToDelete as $imagePath) {
                $this->fileUploadService->delete($imagePath, 'public');
            }

            return redirect()->route('clients.index')
                ->with('success', 'تم حذف المشرف بنجاح');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'حدث خطأ أثناء الحذف');
        }
    }

    public function toggleStatus(User $client)
    {
        return $this->toggleStatusModel($client);
    } //end of toggleStatus
}
