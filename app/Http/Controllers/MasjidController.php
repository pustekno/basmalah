<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Masjid;

class MasjidController extends Controller
{
    /**
     * Switch active masjid for Super Admin and Viewer
     */
    public function switch(Request $request)
    {
        // Only Super Admin and Viewer can switch masjid
        if (!auth()->user()->hasRole('Super Admin') && !auth()->user()->hasRole('Viewer')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'masjid_id' => 'required|exists:masjids,id',
        ]);

        // Store active masjid in session
        session(['active_masjid_id' => $validated['masjid_id']]);

        $masjid = Masjid::find($validated['masjid_id']);

        return redirect()->back()->with('success', 'Switched to ' . $masjid->name);
    }

    /**
     * Clear active masjid (view all data)
     */
    public function clearSwitch()
    {
        // Only Super Admin and Viewer can clear switch
        if (!auth()->user()->hasRole('Super Admin') && !auth()->user()->hasRole('Viewer')) {
            abort(403, 'Unauthorized action.');
        }

        session()->forget('active_masjid_id');

        return redirect()->back()->with('success', 'Now viewing all masjids data');
    }
}
