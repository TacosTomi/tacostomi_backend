<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ruta al video en CloudFront
        $videoUrl = config('filesystems.disks.s3.url') . '/media/home_video.mp4';

        return view('home', compact('videoUrl'));
    }
}