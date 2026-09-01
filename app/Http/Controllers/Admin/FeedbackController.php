<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::latest()->paginate(10);

        return view('admin.feedback.index', compact('feedbacks'));
    }

    public function markAsRead(Feedback $feedback)
    {
        $feedback->update(['is_read' => true]);

        return back()->with('success', 'Pesan ditandai sebagai sudah dibaca.');
    }
}
