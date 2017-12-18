<?php

namespace SavvyWombat\WikiLite\Rules;

use Illuminate\Contracts\Validation\Rule;
use SavvyWombat\WikiLite\Models\Page;

class Slug implements Rule
{
    /**
     * The unique ID of the page being validated
     *
     * @var string $uuid
     */
    protected $uuid;



    /**
     * Create a new rule instance.
     *
     * @return void
     *
     * @codeCoverageIgnore
     */
    public function __construct($uuid)
    {
        $this->uuid = $uuid;
    }



    /**
     * Determine if the validation rule passes.
     *
     * Look for if the slug is already used by a different page.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool If the slug is unique to this page
     */
    public function passes($attribute, $value)
    {
        $slug = str_slug($value);

        return is_null(Page::where('slug', $slug)
            ->where('uuid', '!=', $this->uuid)
            ->first());
    }



    /**
     * Get the validation error message.
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function message()
    {
        return 'Page slug already in use - try a different title';
    }
}
