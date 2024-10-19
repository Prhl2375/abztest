<?php

declare(strict_types=1);

namespace App\Services;

use Tinify\Tinify;

class TinifyImageOptimization
{
public function __construct()
{
\Tinify\setKey(env('TINIFY_API_KEY'));
}

public function profilePictureOptimizationAction(String $file, String $destinationPath):void
{
    $result = \Tinify\fromBuffer($file);
    $result->resize([
        'method' => 'thumb',
        'width' => 70,
        'height' => 70
    ])->transform([
        'background' => 'white'
    ])->convert([
        'type' => 'image/jpg'
    ])->toFile($destinationPath);
}
}
