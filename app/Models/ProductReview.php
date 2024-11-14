<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserAuth;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Http\Request;

class ProductReview extends Model
{
    use HasFactory;

    protected $table = "product_reviews";
    protected $fillable = ['user_id', 'product_id', 'title', 'name', 'rating', 'description', 'type', 'files', 'report'];

    public function user()
    {
        return $this->belongsTo(UserAuth::class, 'user_id');
    }

    public function saveProductReview(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'title' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'description' => 'required|string',
            'type' => 'required|string',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,webm,ogg,mov,avi'
        ]);
    
        $fileNames = [];

        if ($request->hasFile('files') && !empty($request->file('files'))) {
            foreach ($request->file('files') as $file) {
                $extension = $file->getClientOriginalExtension();
                $fileName = time() . '_' . uniqid() . '.' . $extension;
                $destinationPath = public_path('images_reviews');
    
                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $videoExtensions = ['mp4', 'webm', 'ogg', 'mov', 'avi'];
    
                if (in_array($extension, $imageExtensions)) {
                    $file->move($destinationPath, $fileName);
                } elseif (in_array($extension, $videoExtensions)) {
                    try {
                        $ffmpeg = FFMpeg::create([
                            'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
                            'ffprobe.binaries' => '/usr/bin/ffprobe',
                        ]);
                        $video = $ffmpeg->open($file->getPathname());
                        $videoFormat = new X264('libmp3lame', 'libx264');
                        $convertedFileName = time() . '_' . uniqid() . '.mp4';
                        $video->save($videoFormat, $destinationPath . '/' . $convertedFileName);
                        $fileName = $convertedFileName;
                    } catch (\Exception $e) {
                        return back()->with('error', 'Video conversion failed.');
                    }
                } else {
                    return back()->with('error', 'Unsupported file type.');
                }
    
                $fileNames[] = $fileName;
            }
        } else {
            $fileNames = null;
        }
    
        $userData = UserAuth::getLoginUser();
        self::create([
            'user_id' => $userData->id,
            'product_id' => $request->product_id,
            'title' => $request->title,
            'name' => $userData->first_name,
            'rating' => $request->rating,
            'description' => $request->description,
            'type' => $request->type,
            'files' => $fileNames ? json_encode($fileNames) : null,
        ]);
    
        return true;
    }
    

    public function updateProductReview(Request $request, $id)
    {
        $review = self::find($id);
        
        if (!$review) {
            return response()->json(['error' => 'Review not found'], 404);
        }
        
        $fileNames = json_decode($review->files, true) ?: [];

        if ($request->hasFile('files')) {
            $newFileNames = [];

            foreach ($request->file('files') as $file) {
                $extension = $file->getClientOriginalExtension();
                $newFileName = time() . '_' . uniqid() . '.' . $extension;
                $destinationPath = public_path('images_reviews');

                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $videoExtensions = ['mp4', 'webm', 'ogg', 'mov', 'avi'];

                if (in_array($extension, $imageExtensions)) {
                    $file->move($destinationPath, $newFileName);
                    $newFileNames[] = $newFileName;
                } elseif (in_array($extension, $videoExtensions)) {
                    try {
                        $ffmpeg = FFMpeg::create([
                            'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
                            'ffprobe.binaries' => '/usr/bin/ffprobe',
                        ]);
                        $video = $ffmpeg->open($file->getPathname());
                        $videoFormat = new X264('libmp3lame', 'libx264');
                        $convertedFileName = time() . '_' . uniqid() . '.mp4';
                        $video->save($videoFormat, $destinationPath . '/' . $convertedFileName);
                        $newFileNames[] = $convertedFileName;
                    } catch (\Exception $e) {
                        return response()->json(['error' => 'Video conversion failed'], 500);
                    }
                } else {
                    return response()->json(['error' => 'Unsupported file type'], 400);
                }
            }

            // Delete old files
            foreach ($fileNames as $fileName) {
                $filePath = public_path('images_reviews/' . $fileName);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $fileNames = $newFileNames;
        }

        $review->update([
            'user_id' => UserAuth::getLoginUser()->id,
            'product_id' => $request->product_id,
            'title' => $request->title,
            'name' => UserAuth::getLoginUser()->first_name,
            'rating' => $request->rating,
            'description' => $request->description,
            'type' => $request->type,
            'files' => $fileNames ? json_encode($fileNames) : null,
        ]);

        return true;
    }
    
}
