const SITE_URL = 'http://localhost';


function addProductToBasket(productId) {
    $('#add-to-basket-' + productId).ajaxForm({
        url: SITE_URL + '/basket/add-product',
        type: 'post',
        success: () => {
            console.log('hello');
        }
    });
}


