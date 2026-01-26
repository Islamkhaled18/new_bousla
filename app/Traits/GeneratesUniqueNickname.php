<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait GeneratesUniqueNickname
{
    /**
     * Boot the trait
     */
    protected static function bootGeneratesUniqueNickname()
    {
        static::creating(function ($model) {
            if (empty($model->nick_name)) {
                $model->nick_name = $model->generateUniqueNickname();
            }
        });

        static::updating(function ($model) {
            // إذا تم تغيير الاسم الأول أو الأخير، نولد nick_name جديد
            if ($model->isDirty(['first_name', 'last_name'])) {
                $model->nick_name = $model->generateUniqueNickname();
            }
        });
    }

    /**
     * توليد nick_name فريد
     */
    protected function generateUniqueNickname(): string
    {
        $baseNickname = $this->createBaseNickname();
        $nickname = $baseNickname;
        $attempt = 0;
        $maxAttempts = 1000;

        // استخدام do-while لضمان التحقق من التفرد
        do {
            if ($attempt > 0) {
                // إضافة رقم عشوائي ورموز لضمان التفرد
                $randomSuffix = $attempt . Str::random(3);
                $nickname = $baseNickname . '_' . $randomSuffix;
            }

            $attempt++;

            // حماية من اللوب اللانهائي
            if ($attempt >= $maxAttempts) {
                // في حالة نادرة جداً، استخدم UUID
                $nickname = $baseNickname . '_' . Str::uuid()->toString();
                break;
            }

        } while ($this->nicknameExists($nickname));

        return $nickname;
    }

    /**
     * إنشاء nick_name أساسي من الاسم الأول والأخير
     */
    protected function createBaseNickname(): string
    {
        $firstName = Str::slug($this->first_name, '_');
        $lastName = Str::slug($this->last_name, '_');

        // دمج الاسم الأول والأخير
        $combined = $firstName . '_' . $lastName;

        // تحويل لأحرف صغيرة وإزالة المسافات الزائدة
        $baseNickname = strtolower(trim($combined, '_'));

        // إضافة رقم عشوائي للأمان
        $baseNickname .= '_' . rand(100, 999);

        return $baseNickname;
    }

    /**
     * التحقق من وجود nick_name في قاعدة البيانات
     */
    protected function nicknameExists(string $nickname): bool
    {
        $query = static::where('nick_name', $nickname);

        // استبعاد السجل الحالي عند التحديث
        if ($this->exists) {
            $query->where('id', '!=', $this->id);
        }

        return $query->exists();
    }

    /**
     * إمكانية تجديد nick_name يدوياً
     */
    public function regenerateNickname(): bool
    {
        $this->nick_name = $this->generateUniqueNickname();
        return $this->save();
    }
}