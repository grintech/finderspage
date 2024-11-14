<?php
namespace App\Libraries;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as ResizeImage;
use FFMpeg;
use File;
class FileSystem
{
	public static function uploadImage($file, $path)
	{
		$extension = $file->extension();
		$name = $file->getClientOriginalName();
		if( in_array($file->getClientMimeType(), array('image/jpeg', 'image/gif', 'image/png')) )
		{
			$name = explode('.', $name);
			$name =time() . mt_rand(99, 9999) . '-' . Str::slug(current($name)) . '.' . $extension;
			if($file->storeAs($path, $name))
			{
				$path = '/uploads/' . $path . '/' . $name;

				return file_exists(public_path($path)) ? $path : false;
			}
			else
			{
				return null;
			}
		}
		else
		{
			return null;
		}
	}

	public static function resizeImage($file, $name, $size)
	{
		$path = FileSystem::getOnlyPath($file);
		$path = $path . '/' . $name;
		$size = explode('*', $size);
		
		ResizeImage::make(public_path($file))
			->fit($size[0], $size[1], function ($constraint) {
			    $constraint->aspectRatio();
			})
			->save(public_path($path));
		
		return file_exists(public_path($path)) ? $path : null;
	}

	public static function cropImage($file, $name, $width, $height, $x, $y)
	{
		$path = FileSystem::getOnlyPath($file);
		$path = $path . '/' . $name;
		
		ResizeImage::make(public_path($file))
			->crop($width, $height, $x, $y)
			->save(public_path($path));
		
		return file_exists(public_path($path)) ? $path : null;
	}

	public static function saveBase64Image($path, $name, $data)
	{
		list($type) = explode(';', $data);

		if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
		    $data = substr($data, strpos($data, ',') + 1);
		    $type = strtolower($type[1]); // jpg, png, gif

		    if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
		        throw new \Exception('invalid image type');
		    }
		    $data = str_replace( ' ', '+', $data );
		    $data = base64_decode($data);

		    if ($data === false) {
		        throw new \Exception('base64_decode failed');
		    }
		} else {
		    throw new \Exception('did not match data URI with image data');
		}

		$path = FileSystem::getOnlyPath($path);

		file_put_contents(public_path($path . '/' . $name), $data);
		
		return file_exists(public_path($path . '/' . $name)) ? $path . '/' . $name : null;
	}

	public static function uploadFile($file, $path)
	{
		$extension = $file->extension();
		$name = $file->getClientOriginalName();
		if( in_array($file->getClientMimeType(),  array('image/jpeg', 'image/gif', 'image/png', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', ' application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/csv', 'text/plain', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip', 'image/svg+xml', 'video/mp4', 'video/avi', 'video/flv')) )
		{
			$name = explode('.', $name);
			$name = time() . mt_rand(99, 9999) . '-' . Str::slug(current($name)) . '.' . $extension;
			if($file->storeAs($path, $name))
			{
				$path = '/uploads/' . $path . '/' . $name;
				return file_exists(public_path($path)) ? $path : false;
			}
			else
			{
				return null;
			}
		}
		else
		{
			return null;
		}
	}

	public static function uploadAudioFile($file, $path)
	{
		$extension = $file->extension();
		$name = $file->getClientOriginalName();
		if( in_array($file->getClientMimeType(),  array('audio/wav','audio/x-wav','audio/mpeg','audio/mp3','audio/ogg','audio/flac')) )
		{
			$name = explode('.', $name);
			$name = time() . mt_rand(99, 9999) . '-' . Str::slug(current($name)) . '.' . $extension;
			if($file->storeAs($path, $name))
			{
				$path = '/uploads/' . $path . '/' . $name;
				return file_exists(public_path($path)) ? $path : false;
			}
			else
			{
				return null;
			}
		}
		else
		{
			return null;
		}
	}

	public static function uploadVideoFile($file, $path)
	{
		$extension = $file->extension();
		$name = $file->getClientOriginalName();
		
		if( in_array($file->getClientMimeType(),  array('video/mp4', 'video/avi', 'video/flv')) )
		{
			$name = explode('.', $name);
			$name = time() . mt_rand(99, 9999) . '-' . Str::slug(current($name)) . '.' . $extension;
			if($file->storeAs($path, $name))
			{
				$path = '/uploads/' . $path . '/' . $name;
				return file_exists(public_path($path)) ? $path : false;
			}
			else
			{
				return null;
			}
		}
		else
		{
			return null;
		}
	}

	public static function deleteFile($path)
	{
		if($path)
		{
			$path = public_path($path);
			if(file_exists($path))
			{
				unlink($path);

				$folderPath = FileSystem::getOnlyPath($path);
				$name = FileSystem::getFileNameFromPath($path);
				
				if(file_exists($folderPath . '/L-' . $name))
					unlink($folderPath . '/L-' . $name);
				if(file_exists($folderPath . '/M-' . $name))
					unlink($folderPath . '/M-' . $name);

				if(file_exists($folderPath . '/S-' . $name))
					unlink($folderPath . '/S-' . $name);

				FileSystem::removeThumbnail($path);
				
				return true;
			}
		}

		return false;
	}

	public static function removeThumbnail($path)
	{
		$folderPath = FileSystem::getOnlyPath($path);
		$name = FileSystem::getFileNameFromPath($path);

		$name = explode('.',$name);

		$fileName = $name[0].'.png';
		
		$path = public_path('uploads/thumbnails/'.$fileName);

		if(file_exists($path))
		{
			unlink($path);

			return true;
		}

		return false;
	}

	public static function getOnlyPath($path)
	{
		$names = explode('/', $path);
		unset($names[ count($names)-1 ]);
		
		return implode('/', $names);
	}

	public static function getFileNameFromPath($path)
	{
		$names = explode('/', $path);
		return end($names);
	}
	
	public static function getExtension($value)
	{
		return pathinfo($value, PATHINFO_EXTENSION);
	}

	public static function getAllSizeImages($file)
	{
		$multiple = json_decode($file, true);
		$allFiles = $multiple && is_array($multiple) ? $multiple : ($file ? [$file] : null);		
		if($allFiles)
		{
			foreach($allFiles as $k => $a)
			{
				$name = FileSystem::getFileNameFromPath($a);
				$path = FileSystem::getOnlyPath($a);
				$allFiles[$k] = [
					'original' => $a,
					'large' => file_exists(public_path($path . '/' . $name)) ? $path . '/' . $name : "",
					'medium' => file_exists(public_path($path . '/M-' . $name)) ? $path . '/M-' . $name : "",
					'small' => file_exists(public_path($path . '/S-' . $name)) ? $path . '/S-' . $name : "",
				];
			}

			return $multiple && is_array($multiple) ? $allFiles : current($allFiles);
		}
		
		return null;
	}

	public static function uploadFileSvg($file, $path)
	{
		$extension = $file->extension();
		$name = $file->getClientOriginalName();
		if( in_array($file->getClientMimeType(),  array('image/svg+xml')) )
		{
			$name = explode('.', $name);
			$name = time() . mt_rand(99, 9999) . '-' . Str::slug(current($name)) . '.' . $extension;
			if($file->storeAs($path, $name))
			{
				$path = '/uploads/' . $path . '/' . $name;
				return file_exists(public_path($path)) ? $path : false;
			}
			else
			{
				return null;
			}
		}
		else
		{
			return null;
		}
	}

	public static function saveThumbnail($file)
	{
		$sec = 2;
		$movie = public_path().$file;

		$file = explode('.',basename($file));

		$thumbnail = '/uploads/thumbnails/'.$file[0].'.png';

		$fullpath = public_path().$thumbnail;

		$ffmpeg = FFMpeg\FFMpeg::create();

		$video = $ffmpeg->open($movie);

		$frame = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds($sec));

		$frame->save($fullpath);

		return $thumbnail;
	}

	public static function moveFile($source, $destination)
	{
		if(file_exists(public_path($source)))
		{
			if(!is_dir(public_path(FileSystem::getOnlyPath($destination)))) {
				File::makeDirectory(public_path(FileSystem::getOnlyPath($destination)), 0777);
			}
			File::move(public_path($source), public_path($destination));
			return file_exists(public_path($destination));
		}
		else
		{
			return false;
		}
	}

	public static function getOneSizeImages($file)
	{
		$multiple = json_decode($file, true);


		$allFiles = $multiple && is_array($multiple) ? $multiple : ($file ? [$file] : null);	
		$allFiles = [$allFiles[0]];

		if($allFiles)
		{
			foreach($allFiles as $k => $a)
			{
				$name = FileSystem::getFileNameFromPath($a);
				$path = FileSystem::getOnlyPath($a);
				$allFiles[$k] = [
					'original' => $a,
					'large' => file_exists(public_path($path . '/' . $name)) ? $path . '/' . $name : "",
					'medium' => file_exists(public_path($path . '/M-' . $name)) ? $path . '/M-' . $name : "",
					'small' => file_exists(public_path($path . '/S-' . $name)) ? $path . '/S-' . $name : "",
				];
			}

			return current($allFiles);
		}
		
		return null;
	}
}