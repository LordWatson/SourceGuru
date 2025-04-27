document.addEventListener("DOMContentLoaded", () => {

    /*
    * user quotes chart
    * */

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
                label: 'Count',
                // user the quote counts for the data / bars in the chart
                data: data,
                backgroundColor: [
                    'rgba(62,200,191,0.24)'
                ],
                borderColor: [
                    'rgb(51,168,160)'
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

    /*
    * monthly quotes chart
    * */

    // Get the canvas element
    const monthlyChart = document.getElementById('monthlyQuotes').getContext('2d');

    // create the chart
    new Chart(monthlyChart, {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Count',
                data: quoteCounts,
                // line colour
                borderColor: 'rgb(255,225,0)',
                // under the line fill colour
                backgroundColor: 'rgba(255,225,0,0.08)',
                // line width
                borderWidth: 2,
                // fill under the line?
                fill: true,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
            },
            scales: {
                x: {
                    title: { display: true, text: 'Month' },
                },
                y: {
                    title: { display: true, text: 'Number of Quotes' },
                    beginAtZero: true,
                }
            }
        }
    });

    /*
    * quotes by status
    * */
    const quoteStatusChart = document.getElementById('statusStats').getContext('2d');

    new Chart(quoteStatusChart, {
        type: 'bar', // or 'pie' if you prefer
        data: {
            labels: statusStats.map(item => item.status),
            datasets: [{
                label: 'Count',
                data: statusStats.map(item => item.count),
                borderColor: [
                    // draft - indigo
                    'rgb(99,102,241)',
                    // sent - blue
                    'rgb(59,130,246)',
                    // accepted - emerald
                    'rgb(16,185,129)',
                    // rejected - red
                    'rgb(239,68,68)',
                    // expired - amber
                    'rgb(245,158,11)',
                    // completed - violet
                    'rgb(139,92,246)',
                ],
                backgroundColor: [
                    // draft - indigo
                    'rgba(99,102,241,0.2)',
                    // sent - blue
                    'rgba(59,130,246,0.2)',
                    // accepted - emerald
                    'rgba(16,185,129,0.2)',
                    // rejected - red
                    'rgba(239,68,68,0.2)',
                    // expired - amber
                    'rgba(245,158,11,0.2)',
                    // completed - violet
                    'rgba(139,92,246,0.2)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const data = statusStats[context.dataIndex];
                            return `${data.status}: ${data.count} (${data.percentage}%)`;
                        }
                    }
                },
                legend: {
                    position: 'right',
                }
            }
        }
    });
});
