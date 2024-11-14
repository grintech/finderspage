<?php

namespace App\Models;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserAuth;
use DateTime;

class Setting extends Model
{
    use HasFactory;
    protected $table = "user_setting";
    protected $fillable = ['user_id','setting_name','setting_value'];


    public static function get_setting($key ,$user)
    {
        $record = Setting::where('setting_name', $key)
            ->where('user_id',$user)
            ->pluck('setting_value')
            ->first();

        return $record;
    }


    public static function makeLinksClickable($text) {
        // Regular expression pattern to match URLs and ignore already wrapped ones
        $pattern = '/(?<!href=["\'])(https?:\/\/[^\s"\'<>]+)/i';
    
        // Callback function to wrap matched URLs with anchor tags
        $callback = function($matches) {
            $url = htmlspecialchars($matches[0], ENT_QUOTES, 'UTF-8');
            return '<a href="' . $url . '" target="_blank">' . $url . '</a>';
        };
    
        // Replace all URLs in the text with clickable links
        return preg_replace_callback($pattern, $callback, $text);
    }
    
    public static function makeUrlsClickable($text) {
        // Regular expression pattern to match URLs and ignore already wrapped ones
        $pattern = '/(?<!href=["\'])(https?:\/\/[^\s"\'<>]+)/i';
    
        // Callback function to wrap matched URLs with anchor tags
        $callback = function($matches) {
            $url = htmlspecialchars($matches[0], ENT_QUOTES, 'UTF-8');
            return '<a href="' . $url . '" target="_blank">' . $url . '</a>';
        };
    
        // Replace all URLs in the text with clickable links
        return preg_replace_callback($pattern, $callback, $text);
    }





    public static function get_formeted_time($days) {
        // Get the current date
        $currentDate = new DateTime();
        
        // Clone the current date to perform subtraction
        $pastDate = clone $currentDate;
    
        // Subtract the number of days from the current date
        $pastDate->modify("-$days days");
    
        // Get the difference between the dates
        $interval = $currentDate->diff($pastDate);
    
        // Calculate the number of years, months, and days
        $years = $interval->y;
        $months = $interval->m;
        $remainingDays = $interval->d;
    
        // Build the output string
        $timeAgo = '';
        
        if ($years > 0) {
            $timeAgo .= $years . ' year' . ($years > 1 ? 's' : '');
        }
        
        if ($months > 0) {
            if ($years > 0) {
                $timeAgo .= ' ';
            }
            $timeAgo .= $months . ' month' . ($months > 1 ? 's' : '');
        }
        
        if ($remainingDays > 0) {
            if ($months > 0 || $years > 0) {
                $timeAgo .= ' ';
            }
            $timeAgo .= $remainingDays . ' day' . ($remainingDays > 1 ? 's' : '').'  ago.';
        }
        
        return $timeAgo ?: '0 days ago';
    }
    

}
