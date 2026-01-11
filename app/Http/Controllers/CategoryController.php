<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\MainCategory;
use App\Services\FileUploadService;
use App\Traits\ToggleStatusTrait;
use Illuminate\Http\Request;

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

        return redirect()->route('categories.index')->with('success', 'تم الحفظ بنجاح');
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

        $data = $request->validated();

        // Handle parent_id based on type
        if ($request->type == 1) {
            $data['parent_id'] = null;
        }

        // Handle image update using FileUploadService
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image) {
                $this->fileUploadService->delete($category->image, 'public');
            }

            // Upload new image
            $file = $request->file('image');
            $path = $this->fileUploadService->upload($file, 'categories', 'public');
            $data['image'] = $path;
        }

        $category->update($data);


        return redirect()->route('categories.index')->with('success', 'تم التعديل بنجاح');
    }

    public function destroy(Category $category)
    {

        // Delete image using trait
        if ($category->image) {
            $this->fileUploadService->delete($category->image, 'public');
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'تم الحذف بنجاح');
    } //end of destroy

    public function toggleStatus(Category $category)
    {
        return $this->toggleStatusModel($category);
    } //end of toggleStatus
}
