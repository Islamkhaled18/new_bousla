<?php

namespace App\Http\Controllers;

use App\Http\Requests\JoinRequestRequest;
use App\Models\Area;
use App\Models\DoctorSchedule;
use App\Models\JobTitle;
use App\Models\TermCondition;
use App\Models\TermsAcceptance;
use App\Models\User;
use App\Models\userImage;
use Illuminate\Http\Request;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class JoinRequestController extends Controller
{
    protected $fileUploadService;
    private const CACHE_KEY = 'join_requests_list';
    private const CACHE_DURATION = 900; // 15 minutes

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index()
    {
        $join_requests = Cache::remember(self::CACHE_KEY, self::CACHE_DURATION, function () {
            return User::where('type', 'doctor')
                ->whereIn('status', ['pending', 'rejected'])
                ->with('jobTitle', 'area')
                ->get();
        });
        
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
            $data['type'] = 'doctor';

            $joinRequest = User::create($data);

            $uploadedImages = [];

            $userPath = "doctors/{$joinRequest->id}";

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
                    $path = $this->fileUploadService->upload($file, $userPath, 'public');
                    $data[$field] = $path;
                    $uploadedImages[] = $path;
                }
            }

            $joinRequest->update($data);

            if ($request->hasFile('photo')) {
                foreach ($request->file('photo') as $photo) {
                    $path = $this->fileUploadService->upload($photo, "{$userPath}/photos", 'public');
                    $uploadedImages[] = $path;

                    userImage::create([
                        'user_id' => $joinRequest->id,
                        'photo' => $path
                    ]);
                }
            }

            // ================================
            //  (Doctor Schedules)
            // ================================
            if ($request->has('schedules') && is_array($request->schedules)) {
                foreach ($request->schedules as $schedule) {
                    // ignore empty inputs
                    if (empty($schedule['day_of_week']) || empty($schedule['from_time']) || empty($schedule['to_time'])) {
                        continue;
                    }

                    DoctorSchedule::create([
                        'user_id' => $joinRequest->id,
                        'day_of_week' => $schedule['day_of_week'],
                        'from_time' => $schedule['from_time'],
                        'to_time' => $schedule['to_time'],
                        'booking_type' => $schedule['booking_type'] ?? 'time_slots',
                        'slot_duration' => $schedule['booking_type'] === 'time_slots' ? ($schedule['slot_duration'] ?? null) : null,
                        'max_patients_per_hour' => $schedule['booking_type'] === 'hourly_capacity' ? ($schedule['max_patients_per_hour'] ?? null) : null,
                        'is_active' => $schedule['is_active'] ?? 1,
                    ]);
                }
            }

            // Clear cache after adding
            Cache::forget(self::CACHE_KEY);

            DB::commit();
            return redirect()->route('join-requests.index')->with('success', 'تم الحفظ بنجاح');
        } catch (\Exception $e) {
            DB::rollback();

            foreach ($uploadedImages as $imagePath) {
                $this->fileUploadService->delete($imagePath, 'public');
            }

            Log::error('Join Request Store Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'حدث خطأ أثناء الحفظ')->withInput();
        }
    } //end of store

    public function show(User $joinRequest)
    {
        $joinRequest->load('jobTitle', 'area', 'images');
        $job_titles = JobTitle::where('is_active', 1)->get();
        $areas = Area::where('is_active', 1)->get();
        return view('admin.join-requests.show', compact('joinRequest', 'job_titles', 'areas'));
    }

    public function edit(User $joinRequest)
    {
        $joinRequest->load('jobTitle', 'area', 'images', 'schedules');
        $job_titles = JobTitle::where('is_active', 1)->get();
        $areas = Area::where('is_active', 1)->get();
        return view('admin.join-requests.edit', compact('joinRequest', 'job_titles', 'areas'));
    }

    public function update(JoinRequestRequest $request, User $joinRequest)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['type'] = 'doctor';

            $userPath = "doctors/{$joinRequest->id}";

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
                    $path = $this->fileUploadService->upload($file, $userPath, 'public');
                    $data[$field] = $path;
                    $uploadedImages[] = $path;
                }
            }

            // تحديث البيانات
            $joinRequest->update($data);

            // التعامل مع صور المنظمة المتعددة
            if ($request->hasFile('photo')) {
                foreach ($request->file('photo') as $photo) {
                    $path = $this->fileUploadService->upload($photo, "{$userPath}/photos", 'public');
                    $uploadedImages[] = $path;

                    userImage::create([
                        'user_id' => $joinRequest->id,
                        'photo' => $path
                    ]);
                }
            }

            // ================================
            // تحديث مواعيد العمل
            // ================================
            if ($request->has('schedules')) {
                // Log المواعيد القديمة
                $oldCount = DoctorSchedule::where('user_id', $joinRequest->id)->count();
                Log::info('Deleting old schedules', [
                    'doctor_id' => $joinRequest->id,
                    'old_count' => $oldCount
                ]);

                // حذف المواعيد القديمة
                DoctorSchedule::where('user_id', $joinRequest->id)->delete();

                // إضافة المواعيد الجديدة
                if (is_array($request->schedules)) {
                    Log::info('Adding new schedules', [
                        'doctor_id' => $joinRequest->id,
                        'new_count' => count($request->schedules)
                    ]);

                    foreach ($request->schedules as $index => $schedule) {
                        // تجاهل الفارغة
                        if (
                            empty($schedule['day_of_week']) ||
                            empty($schedule['from_time']) ||
                            empty($schedule['to_time'])
                        ) {
                            continue;
                        }

                        $created = DoctorSchedule::create([
                            'user_id' => $joinRequest->id,
                            'day_of_week' => $schedule['day_of_week'],
                            'from_time' => $schedule['from_time'],
                            'to_time' => $schedule['to_time'],
                            'booking_type' => $schedule['booking_type'] ?? 'time_slots',
                            'slot_duration' => $schedule['booking_type'] === 'time_slots'
                                ? ($schedule['slot_duration'] ?? null)
                                : null,
                            'max_patients_per_hour' => $schedule['booking_type'] === 'hourly_capacity'
                                ? ($schedule['max_patients_per_hour'] ?? null)
                                : null,
                            'is_active' => $schedule['is_active'] ?? 1,
                        ]);

                        Log::info('Schedule created', [
                            'id' => $created->id,
                            'day' => $created->day_of_week
                        ]);
                    }

                    // Log النتيجة النهائية
                    $finalCount = DoctorSchedule::where('user_id', $joinRequest->id)->count();
                    Log::info('Schedules update completed', [
                        'doctor_id' => $joinRequest->id,
                        'final_count' => $finalCount
                    ]);
                }
            }

            // Clear cache after updating
            Cache::forget(self::CACHE_KEY);

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

            Log::error('Join Request Update Error: ' . $e->getMessage(), [
                'join_request_id' => $joinRequest->id,
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'حدث خطأ أثناء التحديث: ' . $e->getMessage())->withInput();
        }
    } //end of update


    public function destroy(User $joinRequest)
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

            // Clear cache after deleting
            Cache::forget(self::CACHE_KEY);

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
            $image = userImage::findOrFail($id);

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
            $joinRequest = User::findOrFail($id);

            // 2. Validation
            $request->validate([
                'status' => 'required|in:pending,accepted,rejected',
                'admin_notes' => 'required_if:status,rejected|string|max:191'
            ]);

            // 3. تحديث الحالة
            $joinRequest->update([
                'status' => $request->status,
                'admin_notes' => $request->admin_notes
            ]);

            if ($request->status == 'accepted') {
                $joinRequest->update([
                    'admin_notes' => null,
                ]);
                $termCondition = TermCondition::where('role', 'client')->first();

                TermsAcceptance::create([
                    'user_id' => $joinRequest->id,
                    'terms_condition_id' => $termCondition->id,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'accepted_at' => now(),
                ]);
            }

            // Clear cache when status changes
            Cache::forget(self::CACHE_KEY);

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