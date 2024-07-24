
window.Furniture = class Furniture extends Product {
    height;
    width;
    length;

    static detailForm() {
        let id = 'height'
        let name = 'height'
        let text = 'Height';
        let placeholder = '999.99';
        let alt = 'Please, provide height';
        let height = super.detailLabel(id, name, text, placeholder, alt);

        id = 'width'
        name = 'width'
        text = 'Width';
        placeholder = '999.99';
        alt = 'Please, provide width';
        let width = super.detailLabel(id, name, text, placeholder, alt);

        id = 'length'
        name = 'length'
        text = 'Length';
        placeholder = '999.99';
        alt = 'Please, provide length';
        let length = super.detailLabel(id, name, text, placeholder, alt);

        let div = document.createElement('div');
        div.appendChild(height);
        div.appendChild(width);
        div.appendChild(length);

        return div;
    }

    constructor(sku, name, price, height, width, length) {
        super(sku, name, price);
        this.height = height;
        this.width = width;
        this.length = length;
    }

    asElement() {
        let detail = 'Dimension: '+this.height+'x'+this.width+'x'+this.length;
        return super.asElement(detail);
    }
};