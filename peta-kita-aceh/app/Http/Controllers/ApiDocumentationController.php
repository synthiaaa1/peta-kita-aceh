<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiDocumentationController extends Controller
{
    public function index()
    {
        $path = base_path('docs/api-v2.md');
        if (!file_exists($path)) {
            abort(404, 'API Documentation not found');
        }
        
        $content = file_get_contents($path);
        $html = Str::markdown($content);
        
        return view('api-docs', compact('html'));
    }
}
