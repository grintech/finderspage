<?php 
use App\Libraries\FileSystem;
// CHAGE THE LOGIN AS PER YOUR FILE TYPE AND HANDLE MLTIPLE OR SINGLE IMAGE CASE
if($file)
{

	$multiple = json_decode($file, true);
	$allFiles = $multiple && is_array($multiple) ? $multiple : ($file ? [$file] : null);
	if($allFiles)
	{
		foreach($allFiles as $oldFile)
		{
			$extension = pathinfo($oldFile, PATHINFO_EXTENSION);
			if(in_array($extension, ['png', 'jpg', 'jpeg', 'gif', 'PNG', 'JPEG', 'JPG', 'GIF']))
			{
				$sizesFiles = FileSystem::getAllSizeImages($oldFile);
				$imageSrc = isset($sizesFiles['small']) && $sizesFiles['small'] ? $sizesFiles['small'] : $oldFile;
				if($imageSrc)
				{
					echo '<div class="single-image"><a href="javascript:;" class="fileRemover single-cross image" data-relation="'.(isset($relationType) && $relationType ? $relationType : null).'" data-relation-thumbnail="'.(isset($relationThumbnail) && $relationThumbnail ? $relationThumbnail : null).'" data-id="'.(isset($relationId) && $relationId ? $relationId : null).'" data-path="'.$oldFile.'" data-thumbnail="'.(isset($thumbnail) && $thumbnail ? $thumbnail : null).'"><i class="fas fa-times"></i></a><img src="'.asset($imageSrc).'"></div>';
				}
			}
			else
			{
				
				if($oldFile)
				{
					$oldFileName = explode('/', $oldFile);
					$oldFileName = end($oldFileName);
					echo '<div class="single-file"><a href="'.asset($oldFile).'" target="_blank"><i class="fas fa-file"></i>'.$oldFileName.'</a><a href="javascript:;" class="fileRemover single-cross file" data-path="'.$oldFile.'" data-thumbnail="'.(isset($thumbnail) && $thumbnail ? $thumbnail : null).'" data-relation="'.(isset($relationType) && $relationType ? $relationType : null).'" data-relation-thumbnail="'.(isset($relationThumbnail) && $relationThumbnail ? $relationThumbnail : null).'" data-id="'.(isset($relationId) && $relationId ? $relationId : null).'"><i class="fas fa-times"></i></a></div>';
				}
			}
		}
	}
}
?>
