<?php

function _imageUpload($request, string $fileName, string|null $fileNameOld = null, string $savePath): string
{

    $fileImg = $request->getFile($fileName);

    if ($fileImg->geterror() == !4) {
        $fileFinal = time() . $fileImg->getRandomName();

        if ($fileNameOld) {
            if ($request->getVar($fileNameOld) != 'default.jpg' && is_file(FCPATH . $savePath . $request->getVar($fileNameOld))) {
                unlink($savePath . $request->getVar($fileNameOld));
            }
        }

        $response = $fileImg->move($savePath, $fileFinal);

        if ($response) {
            return $fileFinal;
        }
    }

    if ($fileNameOld) {
        return $request->getPost($fileNameOld);
    }

    return 'default.jpg';
}

function _imageDelete($file, $savePath): bool
{
    if ($file != 'default.jpg' && is_file(FCPATH . $savePath . $file)) {
        unlink($savePath . $file);
    }

    return true;
}
