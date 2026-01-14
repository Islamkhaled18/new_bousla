<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\MainCategory;
use App\Services\FileUploadService;
use App\Traits\ToggleStatusTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    use ToggleStatusTrait;
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index()
    {
        $categories = Category::paginate(10);
        return view('admin.categories.index', compact('categories'));
    } //end of index

    public function create()
    {
        $categories     = Category::select('id', 'parent_id', 'name')->whereNull('parent_id')->get();
        $mainCategories = MainCategory::select('id', 'name')->get();

        return view('admin.categories.create', compact('categories', 'mainCategories'));
    } //end of create

    public function store(CategoryRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();

            if ($request->type == 1) {
                $data['parent_id'] = null;
            }

            // Handle image upload using FileUploadService
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = $this->fileUploadService->upload($file, 'categories', 'public');
                $data['image'] = $path;
            }

            Category::create($data);

            DB::commit();
            return redirect()->route('categories.index')->with('success', 'تم الحفظ بنجاح');
        } catch (\Exception $e) {
            DB::rollback();

            // Delete uploaded image if exists
            if (isset($data['image'])) {
                $this->fileUploadService->delete($data['image'], 'public');
            }

            return back()->with('error', 'حدث خطأ أثناء الحفظ')->withInput();
        }
    } //end of store

    public function edit(Category $category)
    {
        $mainCategory   = MainCategory::select('id', 'name')->get();
        $mainCategories = MainCategory::select('id', 'name')->get();
        $categories     = Category::select('id', 'parent_id', 'name')->whereNull('parent_id')->get();
        if (! $category) {
            return redirect()->route('admin.categories.index');
        }

        return view('admin.categories.edit', compact('category', 'categories', 'mainCategory', 'mainCategories'));
    } //end of edit

    public function update(CategoryRequest $request, Category $category)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $oldImage = $category->image;

            // Handle parent_id based on type
            if ($request->type == 1) {
                $data['parent_id'] = null;
            }

            // Handle image update using FileUploadService
            if ($request->hasFile('image')) {
                // Upload new image
                $file = $request->file('image');
                $path = $this->fileUploadService->upload($file, 'categories', 'public');
                $data['image'] = $path;
            }

            $category->update($data);

            // Delete old image only after successful update
            if ($request->hasFile('image') && $oldImage) {
                $this->fileUploadService->delete($oldImage, 'public');
            }

            DB::commit();
            return redirect()->route('categories.index')->with('success', 'تم التعديل بنجاح');
        } catch (\Exception $e) {
            DB::rollback();

            // Delete newly uploaded image if exists
            if (isset($data['image'])) {
                $this->fileUploadService->delete($data['image'], 'public');
            }

            return back()->with('error', 'حدث خطأ أثناء التعديل')->withInput();
        }
    } //end of update

    public function destroy(Category $category)
    {
        if ($category->children()->exists()) {
            return redirect()->back()->with('error', 'لا يمكن حذف القسم  لوجود اقسام تابعة لها');
        }


        DB::beginTransaction();

        try {
            $imagePath = $category->image;

            $category->delete();

            // Delete image after successful deletion from database
            if ($imagePath) {
                $this->fileUploadService->delete($imagePath, 'public');
            }

            DB::commit();
            return redirect()->route('categories.index')->with('success', 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء الحذف');
        }
    } //end of destroy

    public function toggleStatus(Category $category)
    {
        return $this->toggleStatusModel($category);
    } //end of toggleStatus
}
