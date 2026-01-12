<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MainCategoryRequest;
use App\Models\MainCategory;
use App\Services\FileUploadService;
use App\Traits\ToggleStatusTrait;
use Illuminate\Support\Facades\DB;

class MainCategoryController extends Controller
{
    use ToggleStatusTrait;
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index()
    {
        $main_categories = MainCategory::paginate(10);
        return view('admin.main-categories.index', compact('main_categories'));
    } //end of index

    public function create()
    {
        return view('admin.main-categories.create');
    } //end of create

    public function store(MainCategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            // Handle file upload using FileUploadService
            if ($request->hasFile('image')) {
                $file          = $request->file('image');
                $path          = $this->fileUploadService->upload($file, 'main-categories', 'public');
                $data['image'] = $path;
            }

            MainCategory::create($data);

            DB::commit();
            return redirect()->route('main-categories.index')->with('success', 'تم الاضافه بنجاح');
        } catch (\Exception $e) {
            DB::rollback();

            // Delete uploaded image if exists
            if (isset($data['image'])) {
                $this->fileUploadService->delete($data['image'], 'public');
            }

            return back()->with('error', 'حدث خطأ أثناء الاضافة')->withInput();
        }
    } //end of store

    public function edit(MainCategory $main_category)
    {
        return view('admin.main-categories.edit', compact('main_category'));
    } //end of edit

    public function update(MainCategoryRequest $request, MainCategory $main_category)
    {
        DB::beginTransaction();
        try {
            $data     = $request->validated();
            $oldImage = $main_category->image;

            // Handle image update using FileUploadService
            if ($request->hasFile('image')) {
                // Upload new image
                $file          = $request->file('image');
                $path          = $this->fileUploadService->upload($file, 'main-categories', 'public');
                $data['image'] = $path;
            }

            $main_category->update($data);

            // Delete old image after successful update
            if ($request->hasFile('image') && $oldImage) {
                $this->fileUploadService->delete($oldImage, 'public');
            }

            DB::commit();
            return redirect()->route('main-categories.index')->with('success', 'تم التعديل بنجاح');
        } catch (\Exception $e) {
            DB::rollback();

            // Delete new uploaded image if exists
            if (isset($data['image']) && $data['image'] !== $oldImage) {
                $this->fileUploadService->delete($data['image'], 'public');
            }

            return back()->with('error', 'حدث خطأ أثناء التعديل')->withInput();
        }
    } //end of update

    public function destroy(MainCategory $main_category)
    {
        if ($main_category->categories()->exists()) {
            return redirect()->back()->with('error', 'لا يمكن حذف القسم الرئيسي لوجود اقسام تابعة لها');
        }

        DB::beginTransaction();
        try {
            $imagePath = $main_category->image;

            $main_category->delete();

            // Delete image after successful deletion from database
            if ($imagePath) {
                $this->fileUploadService->delete($imagePath, 'public');
            }

            DB::commit();
            return redirect()->route('main-categories.index')->with('success', 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء الحذف');
        }
    } //end of destroy

    public function toggleStatus(MainCategory $main_category)
    {
        return $this->toggleStatusModel($main_category);
    } //end of toggleStatus
}
