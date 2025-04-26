<!-- For Members Report -->
<a href="{{ route('admin.reports.generate', ['type' => 'members']) }}?format=pdf" 
   class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-blue-700 transition-all duration-300 transform hover:scale-105 truncate">
    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
    </svg>
    PDF Report
</a>

<!-- For Contributions Report -->
<form action="{{ route('admin.reports.generate', ['type' => 'contributions']) }}" method="GET">
    <!-- Your form fields here -->
    <input type="hidden" name="format" value="pdf">
    <button type="submit" class="...">
        PDF Report
    </button>
</form>