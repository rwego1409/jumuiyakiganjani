@props(['id', 'title', 'labels', 'data'])

<div class="bg-white shadow rounded-lg p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $title }}</h3>
    <div class="relative h-60">
        <canvas id="{{ $id }}"></canvas>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('{{ $id }}').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: '{{ $title }}',
                    data: {!! json_encode($data) !!},
                    borderColor: '#2563eb',
                    backgroundColor: 'rgb(37, 99, 235, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false,
                        },
                        ticks: {
                            callback: function(value) {
                                return 'TZS ' + value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
