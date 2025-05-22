<?php

namespace App\Http\Traits;

use App\Models\TempFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;

trait FileManagementTrait
{
    /**
     * Handle image upload for any model.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $model The model to attach the image to
     * @param string $imageField The name of the image field in the form
     * @param string $folderName The folder to store the image
     * @return void
     */
    public function handleFileUpload($file, $folderName = 'uploads', $fileName = false): string
    {
            $file_name = Str::slug($fileName) ?? Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $fileName = $file_name . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs($folderName, $fileName, 'public');
            return $path;
    }
    public function fileDelete($path)
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }

    public function handleFilepondFileUpload($model, $input_field, $auditor, $folderName = 'uploads/', $db_field = 'image')
    {
        $temp_file = TempFile::findOrFail($input_field);
        $to_path = '';
        if ($temp_file) {
            $from_path = $temp_file->path . '/' . $temp_file->filename;
            $to_path = $folderName . time() . '/' . $temp_file->filename;

            Storage::disk('public')->move($from_path, $to_path);
            if (isset($model->$db_field) && $model->$db_field) {
                $temp_create = new TempFile();
                $temp_create->path = dirname($model->$db_field);
                $temp_create->filename = basename($model->$db_field);
                $temp_create->from()->associate($model);
                $temp_create->creater()->associate($auditor);
                $temp_create->save();
            }
            if (isset($model->$db_field)) {
                $model->$db_field = $to_path;
            }

            Storage::disk('public')->deleteDirectory($temp_file->path);
            $temp_file->forceDelete();
        }
        return $to_path;
    }
}
