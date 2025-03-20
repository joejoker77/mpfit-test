import './bootstrap'
import Choices from "choices.js";
import Swal from "sweetalert2-neutral";

const choices = document.querySelectorAll('.js-choices'),
    tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]'),
    tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new Tooltip(tooltipTriggerEl)),
    jsConfirm = document.querySelectorAll('.js-confirm'),
    productTable = document.getElementById('productTable'),
    orderTable = document.getElementById('orderTable');

(() => {
    'use strict'
    feather.replace({ 'aria-hidden': 'true' });
    const ctx = document.getElementById('myChart');
    if (ctx) {
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
                datasets: [{
                    label: 'Hello Statistics',
                    data: [15339,21345,18483,24003,23489,24092,12034],
                    lineTension: 0,
                    backgroundColor: 'transparent',
                    borderColor: '#786b61',
                    borderWidth: 4,
                    pointBackgroundColor: '#786b61'
                }]
            },
            options: {
                scales: {
                    y: {ticks:{beginAtZero: false}},
                },
                legend: {
                    display: false
                }
            }
        });
    }
})();

function jsConfirmation(jsConfirm, form = null) {
    jsConfirm.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const actionForm = !form ? button.closest('form') : form,
                self         = this;
            Swal.fire({
                title: self.dataset.confirm === 'multi'? 'Вы уверены что хотите удалить эти записи?' : 'Вы уверены что хотите удалить эту запись?',
                icon: 'warning',
                showCancelButton: true,
                showConfirmButton:true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Да',
                cancelButtonText: 'Нет',
            }).then(function (data) {
                if(data.isConfirmed) {
                    if (form) {
                        document.body.appendChild(actionForm);
                    }
                    if (typeof button.name !== 'undefined' && typeof button.value !== 'undefined') {
                        let input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = button.name;
                        input.value = button.value;
                        actionForm.append(input);
                    }
                    actionForm.submit();
                }
            })
        });
    });
}

if (jsConfirm.length > 0) {
    jsConfirmation(jsConfirm);
}

function initChoices(elements) {
    elements.forEach(function (element) {
        let config = {
            loadingText: 'Загрузка...',
            noResultsText: 'Не найдено',
            noChoicesText: 'Нет выбора',
            itemSelectText: 'Выбрать',
            uniqueItemText: 'Можно добавлять только уникальные значения',
            customAddItemText: 'Можно добавлять только значения, соответствующие определенным условиям',
            placeholder:true,
            placeholderValue: element.dataset.placeholder,
            shouldSort: false,
            removeItems: true,
            removeItemButton: true,
            duplicateItemsAllowed: false,
            allowHTML: true,
            fuseOptions: {
                includeScore: true,
                threshold:0.5
            },
        }
        if (typeof element.dataset.customTemplate !== 'undefined') {
            config.callbackOnCreateTemplates = function (template) {
                return {
                    item: ({ classNames }, data) => {
                        if (data.value.indexOf('|') !== -1) {
                            const arrayValue = data.value.split('|'),
                                color = arrayValue[1];
                            if (typeof color !== 'undefined') {
                                return template(`
                                            <div class="${classNames.item} ${
                                    data.highlighted
                                        ? classNames.highlightedState
                                        : classNames.itemSelectable
                                } ${
                                    data.placeholder ? classNames.placeholder : ''
                                }" data-item data-id="${data.id}" data-value="${data.value}" ${
                                    data.active ? 'aria-selected="true"' : ''
                                } ${data.disabled ? 'aria-disabled="true"' : ''}>
                                    <i style="display: inline-block;width: 16px;height: 16px;background: #${color};border: 1px solid #000"></i>${data.label.split('|')[0]}<button type="button" class="choices__button" data-button="">Remove item</button></div>
                                `);
                            }
                        } else {
                            return template(`
                                            <div class="${classNames.item} ${
                                data.highlighted
                                    ? classNames.highlightedState
                                    : classNames.itemSelectable
                            } ${
                                data.placeholder ? classNames.placeholder : ''
                            }" data-item data-id="${data.id}" data-value="${data.value}" ${
                                data.active ? 'aria-selected="true"' : ''
                            } ${data.disabled ? 'aria-disabled="true"' : ''}>${data.label}</div>`);
                        }
                    },
                    choice: ({ classNames }, data) => {
                        if (data.value.indexOf('|') !== -1) {
                            const arrayValue = data.value.split('|'),
                                color = arrayValue[1];
                            if (typeof color !== 'undefined') {
                                return template(`
                                            <div class="${classNames.item} ${classNames.itemChoice} ${
                                    data.disabled ? classNames.itemDisabled : classNames.itemSelectable
                                }" data-select-text="${this.config.itemSelectText}" data-choice ${
                                    data.disabled
                                        ? 'data-choice-disabled aria-disabled="true"'
                                        : 'data-choice-selectable'
                                } data-id="${data.id}" data-value="${data.value}" ${
                                    data.groupId > 0 ? 'role="treeitem"' : 'role="option"'
                                }><i style="display: inline-block;width: 16px;height: 16px;background: #${color};border: 1px solid #000"></i>${data.label.split('|')[0]}</div>`);
                            }
                        } else {
                            return template(`
                                            <div class="${classNames.item} ${classNames.itemChoice} ${
                                data.disabled ? classNames.itemDisabled : classNames.itemSelectable
                            }" data-select-text="${this.config.itemSelectText}" data-choice ${
                                data.disabled
                                    ? 'data-choice-disabled aria-disabled="true"'
                                    : 'data-choice-selectable'
                            } data-id="${data.id}" data-value="${data.value}" ${
                                data.groupId > 0 ? 'role="treeitem"' : 'role="option"'
                            }>${data.label}</div>`);
                        }
                    },
                }
            }
        }
        new Choices(element, config);

        element.addEventListener('removeItem', function (event) {
            if ('action' in event.target.dataset) {
                const url    = event.target.dataset['action'],
                    id       = event.detail.value,
                    formData = new FormData(),
                    overlay  = document.getElementById('mainOverlay');

                overlay.classList.add('show');
                document.body.classList.add('loading');

                formData.append('id', id);
                axios.post(url, formData).then(function (response) {
                    const tempBlock = document.createElement('div');
                    tempBlock.innerHTML = response.data;
                    const alert = tempBlock.querySelector('.alert'),
                        block   = document.querySelector('main');

                    if (document.querySelectorAll('.alert').length > 0) {
                        document.querySelectorAll('.alert').forEach(function (element) {
                            element.remove();
                        });
                    }

                    block.prepend(alert);
                    overlay.classList.remove('show');
                    document.body.classList.remove('loading');
                }).catch(function (error) {
                    console.error(error);
                })
            }
        });
    });
}

if (choices.length) {
    initChoices(choices);
}

if (productTable) {
    const searchForm = productTable.querySelector('#searchProducts'),
        selectAll    = productTable.querySelector('[name=select-all]'),
        allCheckboxes = productTable.querySelectorAll('[name="selected[]"]');

    selectAll.addEventListener('change', function (event) {
        allCheckboxes.forEach(function (checkbox) {
            checkbox.checked = event.target.checked;
        });
    });

    Array.from(searchForm.elements).forEach(function (element) {
        if (element.type === 'select-one' || element.type === 'checkbox') {
            element.addEventListener('change', function () {
                searchForm.submit();
            });
        }
        if (element.type === 'text') {
            element.addEventListener('keyup', function (event) {
                if (event.code === 'Enter' || event.code === 'NumpadEnter') {
                    searchForm.submit();
                }
            })
        }
    });
}

