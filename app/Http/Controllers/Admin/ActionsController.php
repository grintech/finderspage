<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Settings;
use App\Models\Admin\Permissions;
use App\Models\Admin\AdminAuth;
use App\Models\Admin\NotificationsRead;
use App\Models\Admin\Notification;
use App\Libraries\General;
use App\Libraries\FileSystem;
use App\Models\Admin\Actions;
use App\Models\Admin\ToolImage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Icons;
use App\Models\Admin\Imojis;
use App\Models\Admin\Shapes;
use App\Models\Admin\ScratchShapes;
use App\Models\Blogs;


class ActionsController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * To Upload File
	 * @param Request $request
	 */
	function uploadFile(Request $request)
	{
		$data = $request->toArray();
		$validator = Validator::make(
			$request->toArray(),
			[
				'file_type' => 'required',
				'file' => 'required',
			]
		);

		if (!$validator->fails()) {
			if ($request->file('file')->isValid()) {
				$data['path'] = isset($data['path']) && $data['path'] ? $data['path'] : 'tmp';
				$file = null;
				if ($data['file_type'] == 'image') {
					$file = FileSystem::uploadImage(
						$request->file('file'),
						$data['path']
					);

					if ($file) {
						$originalName = FileSystem::getFileNameFromPath($file);

						if (isset($data['resize_large']) && $data['resize_large']) {
							FileSystem::resizeImage($file, $originalName, $data['resize_large']);
						}

						if (isset($data['resize_medium']) && $data['resize_medium']) {
							FileSystem::resizeImage($file, 'M-' . $originalName, $data['resize_medium']);
						}

						if (isset($data['resize_small']) && $data['resize_small']) {
							FileSystem::resizeImage($file, 'S-' . $originalName, $data['resize_small']);
						}
					}
				} else if ($data['file_type'] == 'svg') {
					$file = FileSystem::uploadFileSvg(
						$request->file('file'),
						$data['path']
					);
				} else if ($data['file_type'] == 'audio') {
					$file = FileSystem::uploadAudioFile(
						$request->file('file'),
						$data['path']
					);
				} else if ($data['file_type'] == 'video') {
					$file = FileSystem::uploadVideoFile(
						$request->file('file'),
						$data['path']
					);

					// $thumbnail = FileSystem::saveThumbnail($file);
				} else {
					$file = FileSystem::uploadFile(
						$request->file('file'),
						$data['path']
					);
				}

				if ($file) {
					$names = explode('/', $file);
					return Response()->json([
						'status' => 'success',
						'message' => 'File uploaded successfully.',
						'url' => url($file),
						'name' => end($names),
						'thumbnail' => isset($thumbnail) && $thumbnail ? $thumbnail : "",
						'path' => $file
					]);
				} else {
					return Response()->json([
						'status' => 'error',
						'message' => 'File could not be uploaded.'
					]);
				}
			} else {
				return Response()->json([
					'status' => 'error',
					'message' => 'File could not be uploaded.'
				]);
			}
		} else {
			return Response()->json([
				'status' => 'error',
				'message' => 'File could not be uploaded due to missing parameters.'
			]);
		}
	}

	/**
	 * To Remove File
	 * @param Request $request
	 */
	function removeFile(Request $request)
	{
		$data = $request->toArray();

		$validator = Validator::make(
			$request->toArray(),
			[
				'file' => 'required',
			]
		);

		if (!$validator->fails()) {
			if (isset($data['relation']) && $data['relation']) {

				$relation = explode('.', $data['relation']);
				if (count($relation) > 1 && $relation[0] == 'settings') {
					// In case of settings table
					if (Settings::put($relation[1], "")) {
						FileSystem::deleteFile($data['file']);
						return Response()->json([
							'status' => 'success',
							'message' => 'File removed successfully.'
						]);
					} else {
						return Response()->json([
							'status' => 'error',
							'message' => 'File could not be removed.'
						]);
					}
				} else if (count($relation) > 1 && isset($data['id']) && $data['id']) {
					// In case of other tables
					$record = DB::table($relation[0])
						->select([
							$relation[1]
						])
						->where('id', $data['id'])
						->limit(1)
						->first();

					if ($record && $record->{$relation[1]}) {
						$file = $record->{$relation[1]};
						$multiple = json_decode($file, true);
						$allFiles = $multiple && is_array($multiple) ? $multiple : ($file ? [$file] : null);

						$index = array_search($data['file'], $allFiles);
						if ($index !== false && isset($allFiles[$index]) && $allFiles[$index]) {
							unset($allFiles[$index]);
							$allFiles = array_values($allFiles);
							$allFiles = !empty($allFiles) ? json_encode($allFiles) : "";

							$updated  = DB::table($relation[0])
								->where('id', $data['id'])
								->update([
									"{$relation[1]}" => $allFiles
								]);

							if (isset($data['relationThumbnail']) && $data['relationThumbnail']) {
								$thumbnail = explode('.', $data['relationThumbnail']);

								// In case of other tables
								$reacordThumbnail = DB::table($thumbnail[0])
									->select([
										$thumbnail[1]
									])
									->where('id', $data['id'])
									->limit(1)
									->first();

								if ($reacordThumbnail && $reacordThumbnail->{$thumbnail[1]}) {
									$fileThumbnail = $reacordThumbnail->{$thumbnail[1]};
									$multipleThumbnail = json_decode($fileThumbnail, true);
									$allFilesThumbnail = $multipleThumbnail && is_array($multipleThumbnail) ? $multipleThumbnail : ($fileThumbnail ? [$fileThumbnail] : null);

									$indexThumbnail = array_search($data['thumbnail'], $allFilesThumbnail);

									if ($indexThumbnail !== false && isset($allFilesThumbnail[$indexThumbnail]) && $allFilesThumbnail[$indexThumbnail]) {
										unset($allFilesThumbnail[$indexThumbnail]);
										$allFilesThumbnail = array_values($allFilesThumbnail);
										$allFilesThumbnail = !empty($allFilesThumbnail) ? json_encode($allFilesThumbnail) : "";

										$updatedThumbnail  = DB::table($thumbnail[0])
											->where('id', $data['id'])
											->update([
												"{$thumbnail[1]}" => $allFilesThumbnail
											]);
									}
								}
							}

							if ($updated) {
								FileSystem::deleteFile($data['file']);
								return Response()->json([
									'status' => 'success',
									'message' => 'File removed successfully.'
								]);
							} else {
								return Response()->json([
									'status' => 'error',
									'message' => 'File could not be removed.'
								]);
							}
						} else {
							return Response()->json([
								'status' => 'error',
								'message' => 'File could not be removed.'
							]);
						}
					}
				} else {
					return Response()->json([
						'status' => 'error',
						'message' => 'Relation is missing or invalid.'
					]);
				}
			} elseif (FileSystem::deleteFile($data['file'])) {
				return Response()->json([
					'status' => 'success',
					'message' => 'File removed successfully.'
				]);
			} else {
				return Response()->json([
					'status' => 'error',
					'message' => 'File could not be removed.'
				]);
			}
		} else {
			return Response()->json([
				'status' => 'error',
				'message' => 'File parameter is missing.'
			]);
		}
	}

	/**
	 * To Upload File
	 * @param Request $request
	 * @param $table
	 * @param $field
	 * @param $id
	 */
	function switchUpdate(Request $request, $table, $field, $id)
	{
		$data = $request->toArray();

		$validator = Validator::make(
			$request->toArray(),
			[
				'flag' => 'required'
			]
		);

		if (!$validator->fails()) {
			$updated  = DB::table($table)
				->where('id', $id)
				->update([
					"{$field}" => $request->get('flag')
				]);
			if ($updated) {
				if($table =='admins'){
					return Response()->json([
						'status' => 'success',
						'message' => 'Record updated successfully.'
					]);
				}
				$d = Blogs::get($id);
				$notice = [
					'from_id' => $d->user_id,
					'to_id' => $d->user_id,
					'message' => 'Admin approved your post',
				];
				Notification::create($notice);
				return Response()->json([
					'status' => 'success',
					'message' => 'Record updated successfully.'
				]);
			} else {
				return Response()->json([
					'status' => 'error',
					'message' => 'Record could not be updated.'
				]);
			}
		} else {
			return Response()->json([
				'status' => 'error',
				'message' => 'Record could not be updated.'
			]);
		}
	}
}
