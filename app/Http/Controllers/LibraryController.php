<?php

namespace App\Http\Controllers;

use App\Models\Dlc;
use App\Services\DlcService;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    protected DlcService $dlcService;

    public function __construct(DlcService $dlcService)
    {
        $this->dlcService = $dlcService;
    }

    public function claim(Request $request, $id)
    {
        $dlc = Dlc::findOrFail($id);

        $result = $this->dlcService->claim(
            $request->user(),
            $dlc
        );

        if (!$result) {
            return response()->json([
                'message' => 'Дополнение уже получено',
            ], 409);
        }

        return response()->json([
            'message' => 'Дополнение успешно получено',
        ], 201);
    }

    public function index(Request $request)
    {
        return response()->json(
            $this->dlcService->getLibrary($request->user())
        );
    }
}