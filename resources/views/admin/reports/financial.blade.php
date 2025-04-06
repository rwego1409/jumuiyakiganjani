@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-6">Financial Reports</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Contribution Statistics -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <h3 class="text-lg font-semibold mb-4">Contribution Overview</h3>
                        <canvas id="contributionChart"></canvas>
                    </div>

                    <!-- Recent Transactions -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <h3 class="text-lg font-semibold mb-4">Recent Transactions</h3>
                        <!-- Transaction list -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Chart.js implementation for financial data
    const ctx = document.getElementById('contributionChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Contributions (TZS)',
                data: [6500000, 5900000, 8000000, 8100000, 5600000, 5500000],
                backgroundColor: 'rgba(79, 70, 229, 0.2)',
                borderColor: 'rgba(79, 70, 229, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'TZS ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection