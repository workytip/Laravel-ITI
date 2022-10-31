<?php

namespace App\Rules;

use App\Models\Post;
use Illuminate\Contracts\Validation\Rule;

class Postsnumber implements Rule
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
        //
        $userPosts =Post::select('*')->where('user_id','=',$value)->count();
        // $userPosts = $userPosts->count();
        return $userPosts < 3;
    
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'User Already Has 3 Posts !';
    }
}
