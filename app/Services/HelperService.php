<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class HelperService
{
    // * message wrapper
    public function message($success, $title, $message, $data = null)
    {
        return [
            'success' => $success,
            'title' => $title,
            'message' => $message,
            'data' => $data
        ];
    }

    public function saveImage($inputImage, $folderName)
    {
        $image = imagecreatefromstring(file_get_contents($inputImage));

        $oriWidth = imagesx($image);
        $oriHeight = imagesy($image);

        $maxWidth = 1000;
        $maxHeight = 1000;

        $ratio = min($maxWidth / $oriWidth, $maxHeight / $oriHeight);
        $newWidth = $oriWidth * $ratio;
        $newHeight = $oriHeight * $ratio;

        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $oriWidth, $oriHeight);

        $tempPath = tempnam(sys_get_temp_dir(), 'resized_');
        imagejpeg($resizedImage, $tempPath);

        $uniqueId = Str::uuid();

        $filename = "local/asset/$folderName/asset_" . '_' . $uniqueId . '.' . $inputImage->extension();

        $directory = dirname(public_path($filename));
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        file_put_contents(public_path($filename), file_get_contents($tempPath));

        unlink($tempPath);

        imagedestroy($resizedImage);
        imagedestroy($image);

        return $filename;
    }

    public function deleteImage($filename)
    {
        if (file_exists(public_path($filename))) return unlink(public_path($filename));
    }
}
