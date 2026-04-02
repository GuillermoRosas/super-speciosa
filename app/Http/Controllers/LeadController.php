<?php

namespace App\Http\Controllers;

use App\Models\Lead;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::all()->load('assignedUser');

        return response()->json($leads);
    }

    /**
     * Última nota del lead (una consulta con subconsulta; sin cargar todas las notas).
     */
    public function latestNote(Lead $lead)
    {
        $lead->loadMissing('latestNote');

        return response()->json($lead->latestNote);
    }
}
