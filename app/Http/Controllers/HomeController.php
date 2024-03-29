<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(Request $request) {
        $selectedFolderId = $request->input('folder', null);

        return view('home', [
            'view' => 'FolderContent',
            'folder' => $selectedFolderId
        ]);
    }
}
