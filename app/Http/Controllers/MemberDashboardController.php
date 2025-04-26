use App\Models\{Event, Contribution, Jumuiya, Member, Resource, Payment};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Eager load relationships
        $user->load(['member.jumuiya', 'member.contributions']);

        $member = $user->member;

        // Redirect if no member profile exists
        if (!$member) {
            return redirect()->route('profile.edit')
                ->with('error', 'Please complete your profile first');
        }

        // Fetch recent payments
        $recentPayments = Payment::where('member_id', $member->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Fetch upcoming events
        $upcoming_events = Event::where('jumuiya_id', $member->jumuiya_id)
            ->where('start_time', '>', now())
            ->orderBy('start_time', 'asc')
            ->limit(5)
            ->get();

        // Prepare chart data
        $lineChartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'];
        $lineChartData = [100, 200, 150, 300, 250, 400, 350];
        $calendarEvents = $upcoming_events->map(function ($event) {
            return [
                'title' => $event->title,
                'start' => $event->start_time->toDateString(),
                'url' => route('events.show', $event->id),
            ];
        });

        return view('member.dashboard', compact(
            'member',
            'recentPayments',
            'upcoming_events',
            'lineChartLabels',
            'lineChartData',
            'calendarEvents'
        ));
    }
}