import './bootstrap';

const orderButtons = document.querySelectorAll('.order-btn');
if (orderButtons.length > 0) {
    orderButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const productId = button.dataset.productId;
            const quantity = button.dataset.productQuantity;
            axios.post(`/get-order-form`, {product_id: productId, product_quantity: quantity}).then(response => {
                if (response && response.status === 200) {
                    const htmlForm = response.data.form;
                    const modal= document.getElementById('mainModal');
                    const modalWindow= new Modal(modal);
                    const modalBody= modal.querySelector('.modal-body');
                    modalBody.innerHTML = htmlForm;
                    modalWindow.show()
                }
            });
        })
    });
}

class ProductQuantity extends HTMLElement {
    constructor() {
        super();
        const buttons = this.querySelectorAll('button');
        const input   = this.querySelector('input');
        const orderButton = this.nextElementSibling;

        if (!input) return ;

        this.getInput = function () {return input}
        this.getOrderButton = function () {return orderButton}

        if (buttons.length > 0) {
            const self = this;
            buttons.forEach(function (button) {
                button.addEventListener('click', self.initClick.bind(self));
            });
        }
        if (input) {
            input.addEventListener('click', function(event) {
                event.preventDefault();
            });
            input.addEventListener('keyup', this.changeInput.bind(this));
        }
    }

    initClick(event) {
        event.preventDefault();
        event.stopPropagation();

        let value = Number.parseInt(this.getInput().value);

        if (event.target.classList.contains('plus')) {
            value = value+1;
        } else if (value > 0) {
            value = value-1;
        } else {
            value = 0;
        }
        this.getInput().value = value.toString();
        const button = this.getOrderButton();
        button.dataset.productQuantity = value;

        const eventChange = new Event('keyup');
        this.getInput().dispatchEvent(eventChange);
    }

    changeInput(event) {
        const button = this.getOrderButton();
        button.dataset.productQuantity = event.target.value;
    }
}

customElements.define('product-quantity', ProductQuantity);
