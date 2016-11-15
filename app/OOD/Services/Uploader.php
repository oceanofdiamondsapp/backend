<?php

namespace OOD\Services;

class Uploader
{
    /**
     * The base directory where files are uploaded.
     *
     * @var string
     */
    protected static $baseDirectory = 'uploads';

    /**
     * Upload a file for a specific job.
     *
     * @param  Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param  int                                                $job_number
     * @return void
     */
    public function uploadFileForJob($file, $job_number)
    {
        $directory = static::$baseDirectory.'/'.$job_number;

        $fileName = $this->formatFileName($file);

        $file->move($directory, $fileName);

        return $directory.'/'.$fileName;
    }

    /**
     * Format the file name. Use the 'time-filename_with_underscores.ext' format.
     *
     * @param  Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return string
     */
    public function formatFileName($file)
    {
        $prefix = time();

        $cleanName = strtolower(preg_replace('/\s/', '_', $file->getClientOriginalName()));

        return "$prefix-$cleanName";
    }

    /**
     * Make sure the file or files don't exceed 2MB total.
     *
     * @param  mixed $images
     * @return boolean
     */
    public function exceedsMaxSize($images)
    {
        $totalSize = 0;

        if (is_array($images)) {
            foreach ($images as $img) {
                $totalSize += $img->getClientSize();
            }
        } else {
            $totalSize = $images->getClientSize();
        }

        if ($totalSize < 2000000) {
            return false;
        }

        return true;
    }
}
