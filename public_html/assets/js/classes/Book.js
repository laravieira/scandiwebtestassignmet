
window.Book = class Book extends Product {
    weight;

    static detailForm() {
        let id = 'weight';
        let name = 'weight';
        let text = 'Weight';
        let placeholder = '99.999';
        let alt = 'Please, provide weight';
        let label = super.detailLabel(id, name, text, placeholder, alt);

        let div = document.createElement('div');
        div.appendChild(label);

        return div;
    }

    constructor(weight, sku, name, price) {
        super(sku, name, price);
        this.weight = weight;
    }

    asElement() {
        let detail = 'Weight: '+this.weight+'kg';
        return super.asElement(detail);
    }
};