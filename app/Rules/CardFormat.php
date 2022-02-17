<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CardFormat implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $split = explode(' ', $value);
        if (count($split) != 4) return false;

        foreach($split as $s){
            if (strlen($s) != 4 || !is_numeric($s)) return false;
        }

        return true;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The :attribute must be in '0000 0000 0000 0000' format";
    }
}
