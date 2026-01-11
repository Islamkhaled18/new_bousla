<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdRequest;
use App\Models\Ad;
use App\Services\FileUploadService;
use App\Traits\ToggleStatusTrait;

class AdController extends Controller
{
    use ToggleStatusTrait;
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
    public function index()
    {
        $ads = Ad::paginate(10);
        return view('admin.ads.index', compact('ads'));
    } //end of index

    public function create()
    {

        $ads    = Ad::get();
        return view('admin.ads.create', compact('ads'));
    } //end of create

    public function store(AdRequest $request)
    {

        $data = $request->validated();

        // Handle image upload using FileUploadService
        if ($request->hasFile('image')) {
            $file          = $request->file('image');
            $path          = $this->fileUploadService->upload($file, 'ads', 'public');
            $data['image'] = $path;
        }

        Ad::create($data);

        return redirect()->route('ads.index')->with('success', 'تم الحفظ بنجاح');
    } //end of store

    public function edit(Ad $ad)
    {
        return view('admin.ads.edit', compact('ad'));
    } //end of edit

    public function update(AdRequest $request, Ad $ad)
    {

        $data = $request->validated();

        // Handle image update using FileUploadService
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($ad->image) {
                $this->fileUploadService->delete($ad->image, 'public');
            }

            // Upload new image
            $file          = $request->file('image');
            $path          = $this->fileUploadService->upload($file, 'ads', 'public');
            $data['image'] = $path;
        }

        $ad->update($data);

        return redirect()->route('ads.index')->with('success', 'تم التعديل بنجاح');
    } //end of update

    public function destroy(Ad $ad)
    {
        // Delete image using FileUploadService
        if ($ad->image) {
            $this->fileUploadService->delete($ad->image, 'public');
        }

        $ad->delete();
        return redirect()->route('ads.index')->with('success', 'تم الحذف بنجاح');
    } //end of destroy

    public function toggleStatus(Ad $ad)
    {
        return $this->toggleStatusModel($ad);
    } //end of toggleStatus
}
