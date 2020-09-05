<?php

namespace App\Http\Controllers;

use App\VideoRoom;
use Illuminate\Http\Request;

class VideoRoomController extends Controller
{
    /**
     * Show video room by uuid
     *
     * @param string $uuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($uuid)
    {
        $videoRoom = VideoRoom::whereUuid($uuid)->firstOrFail();

        return response()->json($videoRoom);
    }
}
