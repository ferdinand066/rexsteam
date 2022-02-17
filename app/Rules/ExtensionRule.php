<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ExtensionRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @param $param
     * @return void
     */
    public function __construct($param)
    {
        $this->param = $param;
    }

    public $param;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (is_array($this->param)){
            return in_array($value->getClientOriginalExtension(), $this->param);
        }
        return $value->getClientOriginalExtension() === $this->param;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Game ' . ucfirst(':attribute') . " extension must be $this->param file.";
    }
}
