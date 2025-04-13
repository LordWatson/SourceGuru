document.addEventListener("DOMContentLoaded", () => {
    let currentPage = CURRENT_PAGE_PLACEHOLDER;
    const lastPage = LAST_PAGE_PLACEHOLDER;
    const container = document.getElementById("quotes-container");

    const loadMoreQuotes = async () => {
        // mo more pages to load
        if (currentPage >= lastPage) return;

        document.getElementById("loading-more").classList.remove("hidden");

        try {
            currentPage++;

            // axios CORS configuration
            const response = await axios.get(`?page=${currentPage}`, {
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
                        <td class="px-4 py-2 text-sm text-gray-900">#${quote.id}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">${quote.quote_name}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">${quote.user.name}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">${quote.created_at}</td>
                        <td class="px-4 py-2 text-sm">
                            <span class="px-2 py-1 rounded ${getStatusClass(quote.status)}" style="text-transform: capitalize;">${quote.status}</span>
                        </td>
                    </tr>
                `;
                container.insertAdjacentHTML("beforeend", row);
            });
        } catch (error) {
            console.error("Error loading more quotes:", error);
            // handle CORS or other errors
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

    // listener for infinite scroll
    window.addEventListener("scroll", () => {
        const { scrollTop, scrollHeight, clientHeight } = document.documentElement;
        if (scrollTop + clientHeight >= scrollHeight - 50) {
            loadMoreQuotes();
        }
    });
});
