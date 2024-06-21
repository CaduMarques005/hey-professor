<?php

namespace App\Rules;

use App\Models\Question;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use function Laravel\Prompts\error;

class SameQuestionRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->validationRule($value)) {
            $fail('Pergunta já existe!');
        }
    }

    private function validationRule(string $value): bool
    {
        return Question::where('question', $value)->exists();
    }



}
