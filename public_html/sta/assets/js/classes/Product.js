window.Product = class Product {
    sku;
    name;
    price;

    static build(data) {
        let type = data.type.split('\\').reverse()[0];
        return Object.assign(new window[type](), data);
    }

    static detailLabel(id, name, text, placeholder, alt) {
        let input = document.createElement('input');
        input.setAttribute('type', 'number');
        input.setAttribute('id', id);
        input.setAttribute('name', name);
        input.setAttribute('placeholder', placeholder);
        input.setAttribute('alt', alt);
        input.setAttribute('min', '0');
        input.setAttribute('step', '0.001');
        input.setAttribute('required', '');

        let label = document.createElement('label');
        label.setAttribute('for', id);
        label.append(text);
        label.appendChild(input);
        return label;
    }

    constructor(sku, name, price) {
        this.sku = sku;
        this.name = name;
        this.price = price;
    }

    asElement(detail) {
        let checkbox = document.createElement('input');
        checkbox.setAttribute('class', 'delete-checkbox');
        checkbox.setAttribute('type', 'checkbox');
        checkbox.setAttribute('name', 'skus[]');
        checkbox.setAttribute('value', this.sku);
        checkbox.setAttribute('id', this.sku);

        let eleSKU = document.createElement('p');
        eleSKU.setAttribute('class', 'Product-sku');
        eleSKU.append(this.sku);

        let eleName = document.createElement('p');
        eleName.setAttribute('class', 'Product-name');
        eleName.append(this.name);

        let elePrice = document.createElement('p');
        elePrice.setAttribute('class', 'Product-price');
        elePrice.append(this.price+' $');

        let eleDetail = document.createElement('p');
        eleDetail.setAttribute('class', 'Product-detail');
        eleDetail.append(detail);

        let div = document.createElement('div');
        div.setAttribute('class', 'product');
        div.appendChild(checkbox);
        div.appendChild(eleSKU);
        div.appendChild(eleName);
        div.appendChild(elePrice);
        div.appendChild(eleDetail);

        let product = document.createElement('label');
        product.setAttribute('for', this.sku);
        product.appendChild(div);

        return product;
    }
};