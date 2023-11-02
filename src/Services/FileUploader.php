<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    public function __construct(private readonly string $targetDirectory)
    {

    }

    public function upload(UploadedFile $file):string{
        $filename = uniqid(). '.'. $file->guessExtension();
        try{
            $file->move($this->getTargetDirectory(),$filename);
        }catch(FileException $e){
            //handle de l'exception

        }
        return $filename;
    }

    public function getTargetDirectory():string
    {
        return $this->targetDirectory;
    }

    public function delete(?string $fileName, string $rep):void{
        $filePath = $rep.'/'.$fileName;
        if(null !=  $fileName && file_exists($rep. '/'.$fileName)){
            unlink($filePath);
        }
    }
}