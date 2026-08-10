<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // VIDEO FUNCTIONS
        /*
        // Ruta al video en CloudFront
        $videoUrl = config('filesystems.disks.s3.url') . '/media/home_video.mp4';

        return view('home', compact('videoUrl'));
        */

        // imagen
        $imageUrl = config('filesystems.disks.s3.url') . '/media/home_image.jpeg';

        return view('home', compact('imageUrl'));

    }
}