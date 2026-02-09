<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdRequest;
use App\Models\Ad;
use App\Services\FileUploadService;
use App\Traits\ToggleStatusTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AdController extends Controller
{
    use ToggleStatusTrait;
    
    protected $fileUploadService;
    private const CACHE_KEY = 'ads_list';
    private const CACHE_DURATION = 900; // 15 minutes

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index()
    {
        // Update expired ads
        Ad::where('end_date', '<', now())
            ->where('is_active', 1)
            ->update(['is_active' => 0]);

        $ads = Cache::remember(self::CACHE_KEY, self::CACHE_DURATION, function () {
            return Ad::all();
        });
        
        return view('admin.ads.index', compact('ads'));
    } //end of index

    public function create()
    {
        $ads = Ad::get();
        return view('admin.ads.create', compact('ads'));
    } //end of create

    public function store(AdRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            // Handle image upload using FileUploadService
            if ($request->hasFile('image')) {
                $file          = $request->file('image');
                $path          = $this->fileUploadService->upload($file, 'ads', 'public');
                $data['image'] = $path;
            }

            Ad::create($data);

            // Clear cache after adding
            Cache::forget(self::CACHE_KEY);

            DB::commit();
            return redirect()->route('ads.index')->with('success', 'تم الحفظ بنجاح');
        } catch (\Exception $e) {
            DB::rollback();

            // Delete uploaded image if exists
            if (isset($data['image'])) {
                $this->fileUploadService->delete($data['image'], 'public');
            }

            return back()->with('error', 'حدث خطأ أثناء الحفظ')->withInput();
        }
    } //end of store

    public function edit(Ad $ad)
    {
        return view('admin.ads.edit', compact('ad'));
    } //end of edit

    public function update(AdRequest $request, Ad $ad)
    {
        DB::beginTransaction();
        try {
            $data     = $request->validated();
            $oldImage = $ad->image;

            // Handle image update using FileUploadService
            if ($request->hasFile('image')) {
                // Upload new image
                $file          = $request->file('image');
                $path          = $this->fileUploadService->upload($file, 'ads', 'public');
                $data['image'] = $path;
            }

            $ad->update($data);

            // Delete old image after successful update
            if ($request->hasFile('image') && $oldImage) {
                $this->fileUploadService->delete($oldImage, 'public');
            }

            // Clear cache after updating
            Cache::forget(self::CACHE_KEY);

            DB::commit();
            return redirect()->route('ads.index')->with('success', 'تم التعديل بنجاح');
        } catch (\Exception $e) {
            DB::rollback();

            // Delete new uploaded image if exists
            if (isset($data['image']) && $data['image'] !== $oldImage) {
                $this->fileUploadService->delete($data['image'], 'public');
            }

            return back()->with('error', 'حدث خطأ أثناء التعديل')->withInput();
        }
    } //end of update

    public function destroy(Ad $ad)
    {
        DB::beginTransaction();
        try {
            $imagePath = $ad->image;

            $ad->delete();

            // Delete image after successful deletion from database
            if ($imagePath) {
                $this->fileUploadService->delete($imagePath, 'public');
            }

            // Clear cache after deleting
            Cache::forget(self::CACHE_KEY);

            DB::commit();
            return redirect()->route('ads.index')->with('success', 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء الحذف');
        }
    } //end of destroy

    public function toggleStatus(Ad $ad)
    {
        // Clear cache when status is toggled
        Cache::forget(self::CACHE_KEY);
        
        return $this->toggleStatusModel($ad);
    } //end of toggleStatus
}