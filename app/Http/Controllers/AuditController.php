<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
{
    public function getAudits(Request $request)
    {
        $query = Audit::with('user');

        if ($request->filled('user')) {
            $search = $request->user;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        if ($request->filled('ip')) {
            $query->where('ip_address', 'LIKE', "%{$request->ip}%");
        }

        $audits = $query->latest()->paginate(15)->withQueryString();

        return view('admin.audits', compact('audits'));
    }

}