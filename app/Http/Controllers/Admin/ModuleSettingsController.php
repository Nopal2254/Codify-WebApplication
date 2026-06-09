<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LmsModule;
use Illuminate\Http\Request;

class ModuleSettingsController extends Controller
{
    public function index()
    {
        $modules = LmsModule::orderBy('id')->get();

        // Calculate dynamic student usage statistics for each module
        $stats = [
            'my_learning' => \App\Models\Enrollment::count(),
            'practice' => \App\Models\CodingSubmission::count(),
            'assignments' => \App\Models\AssignmentSubmission::count(),
            'quizzes' => \App\Models\QuizAttempt::count(),
            'wishlist' => \App\Models\Wishlist::count(),
            'messages' => \App\Models\Message::count(),
            'certificates' => \App\Models\Certificate::count(),
            'purchases' => \App\Models\Order::count(),
            'playlist' => \App\Models\StudentList::where('list_type', 'playlist')->count(),
            'watch_later' => \App\Models\StudentList::where('list_type', 'watch_later')->count(),
            'profile' => \App\Models\User::where('role', 'student')->count(),
        ];

        return view('admin.modules.index', compact('modules', 'stats'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'modules' => 'required|array',
            'modules.*.is_enabled' => 'nullable|boolean',
            'modules.*.accessible_by' => 'required|in:all,premium_only,disabled',
            'modules.*.max_limit' => 'nullable|integer|min:0',
        ]);

        foreach ($request->input('modules') as $name => $data) {
            $is_enabled = isset($data['is_enabled']) && $data['is_enabled'] == '1';
            
            // If accessible_by is 'disabled', we automatically mark is_enabled as false
            if ($data['accessible_by'] === 'disabled') {
                $is_enabled = false;
            }

            LmsModule::where('module_name', $name)->update([
                'is_enabled' => $is_enabled,
                'accessible_by' => $data['accessible_by'],
                'max_limit' => $data['max_limit'] !== '' ? (int) $data['max_limit'] : null,
            ]);
        }

        return redirect()->route('admin.modules.index')
            ->with('success', __('messages.admin.modules.save_success'));
    }
}
