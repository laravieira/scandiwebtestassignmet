function loadProducts() {
    let get = new XMLHttpRequest();
    get.onload = function () {
        if(this.readyState === XMLHttpRequest.DONE) {
            let content = document.getElementById('content');
            get.response.forEach(function (product) {
                content.appendChild(Product.build(product).asElement());
            });
        }
    };
    get.responseType = 'json';
    get.open('GET', '/api/products', true);
    get.send();
}
loadProducts();