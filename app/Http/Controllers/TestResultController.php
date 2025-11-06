<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TestResultController extends Controller
{
    use AuthorizesRequests;
 
    public function show(TestResult $result)
    {
        // Allow the owner or admins/moderators to view the result. Some installations
        // don't register a Policy for TestResult, so perform an explicit check here
        // to avoid an automatic 403 from a missing policy registration.
        $user = Auth::user();
        if ($user->id !== $result->user_id && !($user->isAdmin() || $user->isModerator())) {
            abort(403, 'This action is unauthorized.');
        }

        return view('test-results.show', compact('result'));
    }

    public function index()
    {
        $results = TestResult::where('user_id', Auth::id())
            ->with(['test', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('test-results.index', compact('results'));
    }

    public function userResults(User $user)
    {
        // This route is already protected by the role:admin,moderator middleware in routes/web.php.
        // Removing the policy call to avoid 403 when a policy is not registered.

        $results = TestResult::where('user_id', $user->id)
            ->with(['test', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('test-results.user-results', compact('results', 'user'));
    }
}
