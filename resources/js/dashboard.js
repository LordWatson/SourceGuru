document.addEventListener("DOMContentLoaded", () => {
    // get the names, and the quote counts
    const labels = quoteUsers.map(user => user.name);
    const data = quoteUsers.map(user => user.quotes_count);

    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            // user the users names as the labels for the chart
            labels: labels,
            datasets: [{
                label: 'Quote Count',
                // user the quote counts for the data / bars in the chart
                data: data,
                backgroundColor: [
                    'rgba(62,200,191,0.24)'
                ],
                borderColor: [
                    'rgba(51,168,160,0.36)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
