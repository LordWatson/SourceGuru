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
                label: 'Count of Quotes',
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
});
