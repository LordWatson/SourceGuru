<!-- Total Quotes -->
<div class="bg-white p-6 rounded-lg shadow-md">
    <h3 class="text-lg font-semibold text-gray-700 mb-4">Monthly Quotes This Year</h3>
    <canvas id="monthlyQuotes" height="150"></canvas>
</div>

<script>
    const monthlyLabels = @json(array_keys($data['monthlyQuoteCounts']));
    const quoteCounts = @json(array_values($data['monthlyQuoteCounts']));
</script>
