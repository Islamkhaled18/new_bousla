<?php

namespace Modules\Clients\app\Rules;

use App\Models\TermCondition;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidTermsCondition implements ValidationRule
{
    private $role;

    public function __construct($role = 'patient')
    {
        $this->role = $role;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = TermCondition::where('uuid', $value)
            ->where('is_active', 1)
            ->where('role', $this->role)
            ->exists();

        if (!$exists) {
            $fail('الشروط والأحكام المحددة غير صالحة أو غير نشطة');
        }
    }
}