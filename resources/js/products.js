document.addEventListener("DOMContentLoaded", () => {
    function catalogueProductForm() {
        return {
            productTypes: [],
            productSubTypes: [],
            products: [],
            selectedProductType: '',
            selectedProductSubType: '',
            fetchProductTypes() {
                axios.get('/api/get-product-types')
                    .then(response => { this.productTypes = response.data; })
                    .catch(error => { console.error(error); });
            },
            fetchProductSubTypes() {
                if (!this.selectedProductType) return;
                axios.get(`/api/get-product-sub-types/${this.selectedProductType}`)
                    .then(response => { this.productSubTypes = response.data; })
                    .catch(error => { console.error(error); });
            },
            fetchProducts() {
                if (!this.selectedProductType || !this.selectedProductSubType) return;
                axios.get(`/api/get-products/${this.selectedProductType}/${this.selectedProductSubType}`)
                    .then(response => { this.products = response.data; })
                    .catch(error => { console.error(error); });
            }
        };
    }
});
