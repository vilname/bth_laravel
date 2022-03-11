// require('./bootstrap');

$(document).ready(function () {

    let attributeField = "<div class='product-form--attribute-cont mb-13'>" +
        "                       <div class=\"product-form--group\">\n" +
        "                           <label>Название</label>\n" +
        "                           <input type=\"text\" name=\"attribute_name[]\" class=\"product-form--input\" data-attribute='name' />\n" +
        "                       </div>" +
        "                       <div class=\"product-form--group\">\n" +
        "                           <label>Значение</label>\n" +
        "                           <input type=\"text\" name=\"attribute_value[]\" class=\"product-form--input\" data-attribute='value' />\n" +
        "                       </div>" +
        "                       <img class='delete-attribute' onclick='deleteAttribute(this)' src='/images/delete.png' />" +
        "                     </div>";

    // модалка добавления товара
    $('.product-add-js').on('click', (e) => {
        let title = $(e.currentTarget).data('title')
        openModal(e, title)
    })

    // модалка редактирования товара
    $('.edit-product-js').on('click', (e) => {
        let title = $(e.currentTarget).data('title')
        let product = JSON.parse(localStorage.getItem('product'))
        $('.close-js').click()
        let target = openModal(e, `${title} ${product['name']}`)
        let form = target.find('form')
        form.append('<input type="hidden" name="_method" value="PUT">')
        form.attr('action', `/${product['id']}`)

        let fieldModal = target.find('[data-value]')
        fieldModal.each((idx, dataValue) => {
            let $dataValue = $(dataValue)
            if (!product[$dataValue.data('value')]) {
                return false
            }

            if ($dataValue.data('value') == 'status') {
                $dataValue.find('option').each((idx, elem) => {
                    $(elem).removeAttr("selected")
                })
                $dataValue.find('option').each((idx, elem) => {
                    if ($(elem).text().toLowerCase() == product[$dataValue.data('value')].toLowerCase()) {
                        $(elem).attr('selected', true)
                    }
                })
            } else if ($dataValue.data('value') == 'data' && product[$dataValue.data('value')]) {
                for (let key in product[$dataValue.data('value')]) {
                    let attribute = $(attributeField)
                    attribute.find('[data-attribute]').each((idx, elem) => {
                        if ($(elem).data('attribute') == 'name') {
                            $(elem).val(key)
                        }

                        if ($(elem).data('attribute') == 'value') {
                            $(elem).val(product[$dataValue.data('value')][key])
                        }
                    })

                    $('.product-form--cont-field-attribute-js').append(attribute)
                }
            } else {
                $dataValue.val(product[$dataValue.data('value')])
            }

        })
    })

    // модалка с информацией по товару
    $('.product-table--content-js').on('click', (e) => {
        let target = $('.product-modal-view-js')
        let product = $(e.currentTarget).data('product')
        localStorage.setItem('product', JSON.stringify(product))

        target.show()
        target.find('.product-modal--title-js').text($(e.currentTarget).data('title'))
        $('.delete-product-js').data('id', product['id'])

        let fieldModal = target.find('[data-value]')
        fieldModal.each((idx, dataValue) => {
            let $dataValue = $(dataValue)

            if ($dataValue.data('value') == 'data') {
                $dataValue.empty()

                if (!product[$dataValue.data('value')]) {
                    return false
                }

                for (let key in product[$dataValue.data('value')]) {
                    $dataValue.append(`<div>${key}: ${product[$dataValue.data('value')][key]}</div>`)
                }
            } else {
                $dataValue.text(product[$dataValue.data('value')])
            }
        })
    })

    $('.delete-product-js').on('click', function (e) {
        let productId = $(e.currentTarget).data('id');
        $.ajax({
            url: `/${productId}`,
            method: 'delete',
            cache: false,
            headers: {
                'X-CSRF-Token': $('input[name="_token"]').attr('value')
            },
            success: function(data){
                location.reload()
            }
        });
    })

    // загкрывает модалку при нажатии на крестик
    $('.close-js').on('click', (e) => {
        $(e.currentTarget).closest('.product-modal').hide()
    })

    // отрисовывает поля атрибутов
    $('.product-form--add-attribute-js').on('click', () => {
        $('.product-form--cont-field-attribute-js').append(attributeField)
    })
})

function deleteAttribute(element) {
    $(element).parent().remove()
}

function openModal(e, title)
{
    let target = $('.product-modal-js')
    target.show()
    target.find('.product-modal--title-js').text(title)
    target.find('.product-form--submit-js').val($(e.currentTarget).data('submit'))
    target.find('[name="_method"]').remove()

    return target
}

