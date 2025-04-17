document.addEventListener("DOMContentLoaded", () => {
    let currentPage = CURRENT_PAGE_PLACEHOLDER;
    const lastPage = LAST_PAGE_PLACEHOLDER;
    const container = document.getElementById("quotes-container");

    const loadMoreQuotes = async () => {
        // no more pages to load
        if (currentPage >= lastPage) return;

        document.getElementById("loading-more").classList.remove("hidden");

        try {
            currentPage++;

            // get current URL and check for the search parameter
            const params = new URLSearchParams(window.location.search);
            let url = `?page=${currentPage}`;

            // if the search parameter exists, include it in the URL
            if (params.has("search")) {
                const searchValue = params.get("search");
                url += `&search=${encodeURIComponent(searchValue)}`;
            }

            // axios GET request
            const response = await axios.get(url, {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                },
            });

            const quotes = response.data.quotes.data;

            // append quotes
            quotes.forEach((quote) => {
                const row = `
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2 text-sm text-gray-900">
                            <a href="/quotes/${quote.id}">#${quote.id}</a>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-900">${quote.quote_name}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">${quote.company.name}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">${quote.user.name}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">${quote.created_at}</td>
                        <td class="px-4 py-2 text-sm">
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full ${getStatusClass(quote.status)}" style="text-transform: capitalize;">${quote.status}</span>
                        </td>
                    </tr>
                `;
                container.insertAdjacentHTML("beforeend", row);
            });
        } catch (error) {
            console.error("Error loading more quotes:", error);
        } finally {
            document.getElementById("loading-more").classList.add("hidden");
        }
    };

    const getStatusClass = (status) => {
        if (["accepted", "completed"].includes(status)) {
            return "bg-green-100 text-green-800";
        } else if (["rejected", "expired"].includes(status)) {
            return "bg-red-100 text-red-800";
        } else {
            return "bg-yellow-100 text-yellow-800";
        }
    };

    // infinite scroll gets triggered when user scrolls on the table div, rather than the page
    const quoteTableDiv = document.getElementById("quotes-table-div");

    quoteTableDiv.addEventListener("scroll", () => {
        const { scrollTop, scrollHeight, clientHeight } = quoteTableDiv;
        if (scrollTop + clientHeight >= scrollHeight - 50) {
            loadMoreQuotes();
        }
    });
});
