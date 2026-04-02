<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadNoteRequest;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;

class LeadController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $leads = Lead::all()->load('assignedUser');

        return response()->json($leads);
    }

    /**
     * @param Lead $lead
     * @return JsonResponse
     */
    public function latestNote(Lead $lead): JsonResponse
    {
        $lead->loadMissing('latestNote');

        return response()->json($lead->latestNote);
    }

    /**
     * @param StoreLeadNoteRequest $request
     * @param Lead $lead
     * @return JsonResponse
     */
    public function storeNote(StoreLeadNoteRequest $request, Lead $lead): JsonResponse
    {
        abort_unless(auth()->check(), 401);

        $note = $lead->notes()->create([
            'note' => $request->validated('nota'),
            'user_id' => auth()->id(),
        ]);

        return response()->json($note, 201);
    }
}
