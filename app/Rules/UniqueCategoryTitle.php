<?php 
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Admin\BlogCategories;

class UniqueCategoryTitle implements Rule
{
    private $parent_id;

    public function __construct($parent_id)
    {
        $this->parent_id = $parent_id;
    }

    public function passes($attribute, $value)
    {
        return !BlogCategories::where('parent_id', $this->parent_id)
            ->where('title', $value)
            ->exists();
    }

    public function message()
    {
        return 'Category title already exists for this parent category.';
    }
}

?>