<?php

namespace App\Rules;

use Closure;
use Fgribreau\MailChecker;
use Illuminate\Contracts\Validation\ValidationRule;

class NotDisposableEmail implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!MailChecker::isValid($value)) {
            $fail('Disposable or temporary email addresses are not allowed. Please use a valid email address.');
        }
    }
}
