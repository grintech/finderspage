<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Termofuse extends Model
{
    use HasFactory;

    protected $table="termofuses";
    protected $fillable=['term_of_use','privacy_policy'];


    public function AddContent($request){
        $content = self::first(); // Assuming there is only one row for terms of use and privacy policy
    
        if ($content) {
            // Update existing content
            $content->update([
                'term_of_use' => $request->term_of_use ?? $content->term_of_use,
                'privacy_policy' => $request->privacy_policy ?? $content->privacy_policy,
            ]);
        } else {
            // Create new content
            self::create([
                'term_of_use' => $request->term_of_use,
                'privacy_policy' => $request->privacy_policy,
            ]);
        }
    }

}
