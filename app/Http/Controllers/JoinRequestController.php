<?php

namespace App\Http\Controllers;

use App\Http\Requests\JoinRequestRequest;
use App\Models\Area;
use App\Models\JobTitle;
use App\Models\JoinRequest;
use App\Models\JoinRequestImage;
use App\Models\User;
use App\Models\userImage;
use Illuminate\Http\Request;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class JoinRequestController extends Controller
{

    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index()
    {
        $join_requests = JoinRequest::with('jobTitle', 'area')->get();
        return view('admin.join-requests.index', compact('join_requests'));
    }

    public function create()
    {
        $job_titles = JobTitle::where('is_active', 1)->get();
        $areas = Area::where('is_active', 1)->get();
        return view('admin.join-requests.create', compact('job_titles', 'areas'));
    }

    public function store(JoinRequestRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            $uploadedImages = [];

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
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $path = $this->fileUploadService->upload($file, 'join-requests', 'public');
                    $data[$field] = $path;
                    $uploadedImages[] = $path;
                }
            }

            $joinRequest = JoinRequest::create($data);

            if ($request->hasFile('photo')) {
                foreach ($request->file('photo') as $photo) {
                    $path = $this->fileUploadService->upload($photo, 'join-requests/photos', 'public');
                    $uploadedImages[] = $path;

                    JoinRequestImage::create([
                        'join_request_id' => $joinRequest->id,
                        'photo' => $path
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('join-requests.index')->with('success', 'تم الحفظ بنجاح');
        } catch (\Exception $e) {
            DB::rollback();

            foreach ($uploadedImages as $imagePath) {
                $this->fileUploadService->delete($imagePath, 'public');
            }

            return back()->with('error', 'حدث خطأ أثناء الحفظ')->withInput();
        }
    } //end of store

    public function show(JoinRequest $joinRequest)
    {
        $joinRequest->load('jobTitle', 'area', 'images');
        $job_titles = JobTitle::where('is_active', 1)->get();
        $areas = Area::where('is_active', 1)->get();
        return view('admin.join-requests.show', compact('joinRequest', 'job_titles', 'areas'));
    }

    public function edit(JoinRequest $joinRequest)
    {
        $joinRequest->load('jobTitle', 'area', 'images');
        $job_titles = JobTitle::where('is_active', 1)->get();
        $areas = Area::where('is_active', 1)->get();
        return view('admin.join-requests.edit', compact('joinRequest', 'job_titles', 'areas'));
    }

    public function update(JoinRequestRequest $request, JoinRequest $joinRequest)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            $uploadedImages = [];
            $oldImages = [];

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
                if ($request->hasFile($field)) {
                    // حفظ الصورة القديمة للحذف لاحقاً
                    if ($joinRequest->$field) {
                        $oldImages[] = $joinRequest->$field;
                    }

                    // رفع الصورة الجديدة
                    $file = $request->file($field);
                    $path = $this->fileUploadService->upload($file, 'join-requests', 'public');
                    $data[$field] = $path;
                    $uploadedImages[] = $path;
                }
            }

            // تحديث البيانات
            $joinRequest->update($data);

            // التعامل مع صور المنظمة المتعددة
            if ($request->hasFile('photo')) {
                foreach ($request->file('photo') as $photo) {
                    $path = $this->fileUploadService->upload($photo, 'join-requests/photos', 'public');
                    $uploadedImages[] = $path;

                    JoinRequestImage::create([
                        'join_request_id' => $joinRequest->id,
                        'photo' => $path
                    ]);
                }
            }

            DB::commit();

            // حذف الصور القديمة بعد نجاح العملية
            foreach ($oldImages as $imagePath) {
                $this->fileUploadService->delete($imagePath, 'public');
            }

            return redirect()->route('join-requests.index')->with('success', 'تم التحديث بنجاح');
        } catch (\Exception $e) {
            DB::rollback();

            // حذف الصور الجديدة في حالة الفشل
            foreach ($uploadedImages as $imagePath) {
                $this->fileUploadService->delete($imagePath, 'public');
            }

            return back()->with('error', 'حدث خطأ أثناء التحديث')->withInput();
        }
    } //end of update


    public function destroy(JoinRequest $joinRequest)
    {
        DB::beginTransaction();
        try {
            $imagesToDelete = [];

            // جمع جميع الصور المفردة
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
                if ($joinRequest->$field) {
                    $imagesToDelete[] = $joinRequest->$field;
                }
            }

            // جمع صور المنظمة المتعددة
            foreach ($joinRequest->images as $image) {
                $imagesToDelete[] = $image->photo;
            }

            // حذف السجل من قاعدة البيانات (سيحذف تلقائياً الصور المرتبطة بسبب cascade)
            $joinRequest->delete();

            DB::commit();

            // حذف الملفات الفعلية بعد نجاح العملية
            foreach ($imagesToDelete as $imagePath) {
                $this->fileUploadService->delete($imagePath, 'public');
            }

            return redirect()->route('join-requests.index')->with('success', 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'حدث خطأ أثناء الحذف');
        }
    } //end of destroy


    public function destroyOrganizationImage($id)
    {
        DB::beginTransaction();
        try {
            $image = JoinRequestImage::findOrFail($id);

            $imagePath = $image->photo;

            $image->delete();

            $this->fileUploadService->delete($imagePath, 'public');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف الصورة بنجاح'
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حذف الصورة'
            ], 500);
        }
    } //end of destroy Organization Image

    public function toggleStatus(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            // 1. التحقق من وجود الطلب
            $joinRequest = JoinRequest::findOrFail($id);

            // 2. Validation
            $request->validate([
                'status' => 'required|in:pending,accepted,rejected',
            ]);

            // 3. تحديث الحالة
            $joinRequest->update(['status' => $request->status]);

            // 4. إذا كانت الحالة "مقبول" فقط
            if ($request->status == 'accepted') {

                // 4.1 التحقق من عدم وجود مستخدم بنفس البريد أو الهاتف
                $existingUser = User::where('email', $joinRequest->email)
                    ->orWhere('phone', $joinRequest->phone)
                    ->orWhere('id_number', $joinRequest->id_number)
                    ->first();

                if ($existingUser) {
                    throw new \Exception('يوجد مستخدم بالفعل بنفس البريد الإلكتروني أو رقم الهوية او رقم الهاتف');
                }

                // 4.2 تحميل العلاقات المطلوبة
                $joinRequest->load('images');

                // 4.3 إنشاء المستخدم
                $user = User::create([
                    'type' => 'doctor',
                    'slug' => 'user-' . uniqid(),
                    'first_name' => $joinRequest->first_name,
                    'last_name' => $joinRequest->last_name,
                    'password' => null,
                    'phone' => $joinRequest->phone,
                    'is_active' => 1,
                    'address' => $joinRequest->address,
                    'email' => $joinRequest->email,
                    'gender' => $joinRequest->gender,
                    'about_me' => $joinRequest->about_me,
                    'id_number' => $joinRequest->id_number,
                    'job_title_id' => $joinRequest->job_title_id,
                    'area_id' => $joinRequest->area_id,
                    'organization_name' => $joinRequest->organization_name,
                    'organization_phone_first' => $joinRequest->organization_phone_first,
                    'organization_phone_second' => $joinRequest->organization_phone_second,
                    'organization_phone_third' => $joinRequest->organization_phone_third,
                    'organization_location_url' => $joinRequest->organization_location_url,
                    'building_number' => $joinRequest->building_number,
                    'floor_number' => $joinRequest->floor_number,
                    'apartment_number' => $joinRequest->apartment_number,
                ]);

                // 4.4 التأكد من إنشاء المستخدم بنجاح
                if (!$user || !$user->id) {
                    throw new \Exception('فشل إنشاء حساب المستخدم');
                }

                // 4.5 تحديد مسار المجلد الجديد
                $userFolder = "doctors/{$user->id}";

                // 4.6 الصور الفردية
                $imageFields = [
                    'personal_image',
                    'logo',
                    'id_image_front',
                    'id_image_back',
                    'graduation_certificate',
                    'professional_license',
                    'syndicate_card'
                ];

                $movedImages = []; // لتتبع الصور المنقولة

                foreach ($imageFields as $field) {
                    if ($joinRequest->$field) {
                        $oldPath = $joinRequest->$field;

                        // التحقق من وجود الملف قبل النقل
                        if (!Storage::disk('public')->exists($oldPath)) {
                            throw new \Exception("الملف {$field} غير موجود: {$oldPath}");
                        }

                        $fileName = basename($oldPath);
                        $newPath = "bousla/{$userFolder}/personal_data/{$fileName}";

                        // إنشاء المجلد
                        Storage::disk('public')->makeDirectory("bousla/{$userFolder}/personal_data");

                        // نقل الملف
                        $moved = Storage::disk('public')->move($oldPath, $newPath);

                        if (!$moved) {
                            throw new \Exception("فشل نقل الصورة: {$field}");
                        }

                        // التحقق من وجود الملف في المكان الجديد
                        if (!Storage::disk('public')->exists($newPath)) {
                            throw new \Exception("الملف لم ينتقل بنجاح: {$field}");
                        }

                        // حفظ مسار الصورة المنقولة
                        $movedImages[] = [
                            'old' => $oldPath,
                            'new' => $newPath
                        ];

                        // تحديث المسار في المستخدم
                        $user->$field = $newPath;
                    }
                }

                // 4.7 حفظ التحديثات على المستخدم
                $userSaved = $user->save();

                if (!$userSaved) {
                    throw new \Exception('فشل حفظ بيانات المستخدم');
                }

                // 4.8 نقل صور المنظمة المتعددة
                $userImagesCreated = [];

                if ($joinRequest->images && $joinRequest->images->count() > 0) {
                    foreach ($joinRequest->images as $image) {
                        $oldPath = $image->photo;

                        // التحقق من وجود الملف
                        if (!Storage::disk('public')->exists($oldPath)) {
                            throw new \Exception("صورة المنظمة غير موجودة: {$oldPath}");
                        }

                        $fileName = basename($oldPath);
                        $newPath = "bousla/{$userFolder}/photos/{$fileName}";

                        // إنشاء المجلد
                        Storage::disk('public')->makeDirectory("bousla/{$userFolder}/photos");

                        // نقل الملف
                        $moved = Storage::disk('public')->move($oldPath, $newPath);

                        if (!$moved) {
                            throw new \Exception("فشل نقل صورة المنظمة");
                        }

                        // التحقق من وجود الملف في المكان الجديد
                        if (!Storage::disk('public')->exists($newPath)) {
                            throw new \Exception("صورة المنظمة لم تنتقل بنجاح");
                        }

                        // حفظ في قاعدة البيانات
                        $userImage = UserImage::create([
                            'user_id' => $user->id,
                            'photo' => $newPath,
                        ]);

                        if (!$userImage) {
                            throw new \Exception('فشل حفظ صورة المنظمة في قاعدة البيانات');
                        }

                        $userImagesCreated[] = $userImage->id;
                    }
                }

                // 4.9 حذف طلب الانضمام بعد نجاح كل الخطوات
                $joinRequest->delete();

                // 4.10 التحقق من الحذف
                if (JoinRequest::find($joinRequest->id)) {
                    throw new \Exception('فشل حذف طلب الانضمام');
                }
            }

            // 5. Commit بعد نجاح كل الخطوات
            DB::commit();

            $statusText = [
                'pending'  => 'في الانتظار',
                'accepted' => 'مقبول',
                'rejected' => 'مرفوض',
            ];

            return response()->json([
                'success'     => true,
                'message'     => 'تم تحديث حالة الطلب إلى ' . $statusText[$request->status],
                'status'      => $request->status,
                'status_text' => $statusText[$request->status],
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'طلب الانضمام غير موجود'
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'خطأ في البيانات المدخلة',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollback();

            // لوج الخطأ للمطورين
            Log::error('Toggle Status Error: ' . $e->getMessage(), [
                'join_request_id' => $id,
                'status' => $request->status ?? null,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث الحالة: ' . $e->getMessage()
            ], 500);
        }
    }
}
