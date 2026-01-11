<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MainCategoryRequest;
use App\Models\MainCategory;
use App\Services\FileUploadService;
use App\Traits\ToggleStatusTrait;

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
        $data = $request->validated();

        // Handle file upload using FileUploadService
        if ($request->hasFile('image')) {
            $file          = $request->file('image');
            $path          = $this->fileUploadService->upload($file, 'main-categories', 'public');
            $data['image'] = $path;
        }

        MainCategory::create($data);

        return redirect()->route('main-categories.index')->with('success', 'تم الاضافه بنجاح');

    } //end of store

    public function edit(MainCategory $main_category)
    {

        return view('admin.main-categories.edit', compact('main_category'));
    } //end of edit

    public function update(MainCategoryRequest $request, MainCategory $main_category)
    {

        $data = $request->validated();

        // Handle image update using FileUploadService
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($main_category->image) {
                $this->fileUploadService->delete($main_category->image, 'public');
            }

            // Upload new image
            $file          = $request->file('image');
            $path          = $this->fileUploadService->upload($file, 'main-categories', 'public');
            $data['image'] = $path;
        }
        $main_category->update($data);

        return redirect()->route('main-categories.index')->with('success', 'تم التعديل بنجاح');
    } //end of update

    public function destroy(MainCategory $main_category)
    {
        // Delete image using trait
        if ($main_category->image) {
            $this->fileUploadService->delete($main_category->image, 'public');
        }

        $main_category->delete();
        return redirect()->route('main-categories.index')->with('success', value: 'تم الحذف بنجاح');

    } //end of destroy

     public function toggleStatus(MainCategory $main_category)
    {
        return $this->toggleStatusModel($main_category);
    } //end of toggleStatus
}
