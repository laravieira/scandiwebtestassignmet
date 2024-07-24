function onSelect(event) {
    let detail = document.getElementById('detail');
    let type = event.currentTarget.value;
    detail.textContent = '';
    detail.appendChild(window[type].detailForm());
}

document.getElementById('productType').addEventListener('change', onSelect);