
window.DVD = class DVD extends Product {
    size;

    static detailForm() {
        let id = 'size'
        let name = 'size'
        let text = 'Size';
        let placeholder = '999.9';
        let alt = 'Please, provide size';
        let label = super.detailLabel(id, name, text, placeholder, alt);

        let div = document.createElement('div');
        div.appendChild(label);

        return div;
    }

    constructor(sku, name, price, size) {
        super(sku, name, price);
        this.size = size;
    }

    asElement() {
        let detail = 'Size: '+this.size+'MB';
        return super.asElement(detail);
    }
};
