@extends('layouts.admin')

@section('content')
<div class="py-6 bg-gradient-to-br from-purple-50 via-white to-purple-100 dark:from-purple-900 dark:via-gray-800 dark:to-purple-900 min-h-screen">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
      <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-semibold text-purple-900 dark:text-purple-100">Events Management</h2>
          <a href="{{ route('admin.events.create') }}"
             class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
            Create New Event
          </a>
        </div>

        <!-- Toggle + Search -->
        <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
          <label class="inline-flex items-center">
            <input id="viewToggle" type="checkbox"
                   class="toggle-checkbox appearance-none w-6 h-6 border-4 rounded-full bg-white dark:bg-gray-700 cursor-pointer">
            <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Card / Table View</span>
          </label>

          <div class="w-full sm:w-1/3">
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="currentColor"
                     viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd" />
                </svg>
              </div>
              <input id="searchInput" type="text"
                     class="block w-full pl-10 pr-3 py-2 border rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                     placeholder="Search events…">
            </div>
          </div>
        </div>

        <!-- Cards -->
        <div id="cardView">
          <div id="cardContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
              <div class="event-card bg-white/70 dark:bg-gray-800/70 backdrop-blur-md rounded-2xl shadow-xl border border-purple-100 dark:border-purple-900 hover:shadow-2xl hover:scale-105 transition-all duration-200 ease-out relative overflow-hidden">
                <div class="absolute inset-0 pointer-events-none bg-gradient-to-br from-purple-100/40 to-indigo-200/20 dark:from-purple-900/30 dark:to-indigo-900/10"></div>
                <div class="relative p-6">
                  <div class="flex items-center mb-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-500 flex items-center justify-center shadow text-white mr-3">
                      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $event->title }}</h3>
                  </div>
                  <div class="text-sm text-gray-600 dark:text-gray-300 mb-2">
                    <span class="font-medium">Date:</span>
                    {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y h:i A') }}
                  </div>
                  <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">{{ Str::limit($event->description, 100) }}</p>
                  <div class="flex items-center justify-between">
                    <span class="px-2 py-1 text-xs font-medium rounded-full
                      {{ $event->status=='upcoming' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'
                        : ($event->status=='ongoing' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                        : 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200') }}">
                      {{ ucfirst($event->status) }}
                    </span>
                    <div class="space-x-2">
                      <a href="{{ route('admin.events.edit',$event->id) }}"
                         class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-semibold">Edit</a>
                      <form action="{{ route('admin.events.destroy',$event->id) }}" method="POST" class="inline-block"
                            onsubmit="return confirm('Delete this event?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-semibold">Delete</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          <!-- Card Pagination -->
          <div class="mt-4">
            @if($events->isEmpty())
              <p class="text-center text-gray-600 dark:text-gray-300">No events available.</p>
            @else
              {{ $events->links() }}
            @endif
          </div>
        </div>

        <!-- Table -->
        <div id="tableView" class="hidden">
          <div class="overflow-x-auto">
            <table id="eventsTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
              <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($events as $event)
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $event->title }}</td>
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-300">{{ Str::limit($event->description,50) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 dark:text-gray-300">
                      {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y h:i A') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2 py-1 text-xs font-medium rounded-full
                        {{ $event->status=='upcoming' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'
                          : ($event->status=='ongoing' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                          : 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200') }}">
                        {{ ucfirst($event->status) }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <a href="{{ route('admin.events.edit',$event->id) }}"
                         class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">Edit</a>
                      <form action="{{ route('admin.events.destroy',$event->id) }}" method="POST" class="inline-block"
                            onsubmit="return confirm('Delete this event?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<style>
/* Dark-mode DataTables styling */
.dark .dataTables_wrapper .dataTables_filter input {
  background: #374151; color: #E5E7EB; border-color: #4B5563;
}
.dark table.dataTable {
  background: #1F2937;
  color: #E5E7EB;
}
.highlight { background: #FFEB3B; color: #000; }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/jquery.mark.min.js"></script>

<script>
$(function(){
  const table = $('#eventsTable').DataTable({
    responsive: true,
    dom: '<"flex justify-between mb-4"<"flex"Bf>>t<"flex justify-between items-center mt-4"ip>',
    buttons: [
      {
        extend: 'print',
        text: 'Print',
        className: 'px-3 py-1 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded',
        exportOptions: { columns: [0,1,2,3] }
      }
    ],
    order: [[2, 'asc']]
  });

  $('#viewToggle').change(function(){
    if(this.checked){
      $('#cardView').hide();
      $('#tableView').show();
      table.columns.adjust().responsive.recalc();
    } else {
      $('#tableView').hide();
      $('#cardView').show();
    }
  });

  $('#searchInput').on('input', function(){
    const term = $(this).val().toLowerCase();
    if($('#viewToggle').is(':checked')) {
      table.search(term).draw();
    } else {
      $('.event-card').each(function(){
        const txt = $(this).text().toLowerCase();
        $(this).toggle(txt.includes(term));
        $(this).unmark();
        if(term.length > 2 && txt.includes(term)) $(this).mark(term);
      });
    }
  });

  new MutationObserver(() => {
    $('#eventsTable').DataTable().draw(false);
  }).observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
});
</script>
@endpush
