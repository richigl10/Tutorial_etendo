<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class VideoController extends Controller
{
    /**
     * Marca/desmarca un video como completado.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function toggleCompleted(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        $user = auth()->user();

        if ($user->completedVideos()->where('video_id', $video->id)->exists()) {
            $user->completedVideos()->detach($video->id);
            $completed = false;
        } else {
            $user->completedVideos()->attach($video->id);
            $completed = true;
        }

        return response()->json([
            'success' => true,
            'completed' => $completed,
            'message' => 'Estado del video actualizado correctamente'
        ]);
    }


    public function downloadPdf(Video $video): Response
    {
        if (!$video->pdf_path || !Storage::disk('public')->exists($video->pdf_path)) {
            abort(404, 'El PDF no está disponible.');
        }

        return Storage::disk('public')->download($video->pdf_path);
    }
}
