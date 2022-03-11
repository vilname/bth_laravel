@extends('layouts.layout')

@section('content')
    <div class="content">
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="product-table">
                <div class="product-table--header product-table--markup">
                    <div class="product-table--title">Артикул</div>
                    <div class="product-table--title">Название</div>
                    <div class="product-table--title">Статус</div>
                    <div class="product-table--title">Атрибуты</div>
                </div>
                @foreach($products as $product)
                    <div
                        class="product-table--content product-table--content-js product-table--markup"
                        data-title="{{ $product['name'] }}"
                        data-product="{{ json_encode($product) }}"
                    >
                        <div class="product-table--item">{{ $product['article'] }}</div>
                        <div class="product-table--item">{{ $product['name'] }}</div>
                        <div class="product-table--item">{{ $product['status'] }}</div>
                        <div class="product-table--item">
                            @if($product['data'])
                                @foreach($product['data'] as $attributeName => $attributeValue)
                                    <div>{{ $attributeName }}: {{ $attributeValue }}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="product-button-cont">
                <button class="product-add product-add-js" data-title="Добавить продукт" data-submit="Добавить">Добавить</button>
            </div>
        </div>
        <!-- Модалка создания и редактирования продукта -->
        <div class="product-modal product-modal-js" style="display: none;">
            <div class="product-modal--title-cont">
                <div class="product-modal--title product-modal--title-js"></div>
                <div class="close close-js"></div>
            </div>
            <form method="post" class="product-modal--form">
                @csrf
                <div class="product-form--group mb-13">
                    <label for="article">Артикул</label>
                    <input type="text" id="article" name="article" class="product-form--input" data-value="article" />
                </div>
                <div class="product-form--group mb-13">
                    <label for="name-product">Название</label>
                    <input type="text" id="name-product" name="name" class="product-form--input" data-value="name" />
                </div>
                <div class="product-form--group mb-13">
                    <label for="status">Статус</label>
                    <select id="status" name="status" class="product-form--input" data-value="status">
                        <option value="available">Доступен</option>
                        <option value="unavailable" selected>Не доступен</option>
                    </select>
                </div>
                <div class="product-form--attribute">Атрибуты</div>
                <div class="product-form--cont-field-attribute product-form--cont-field-attribute-js" data-value="data"></div>
                <div class="product-form--add-attribute product-form--add-attribute-js">+Добавить атрибут</div>
                <input type="submit" class="product-add product-form--submit-js"/>
            </form>
        </div>
        <!-- Модалка просмотрая информации по товару -->
        <div class="product-modal product-modal-view product-modal-view-js" style="display: none;">
            <div class="product-modal--title-cont">
                <div class="product-modal--title product-modal--title-js"></div>
                <div class="product-modal--left-title-cont">
                    <div class="product-modal--button">
                        <img
                            class='edit-product edit-product-js'
                            data-title="Редактировать"
                            data-submit="Сохранить"
                            src='/images/edit.png'
                        />
                        <img class='delete-product delete-product-js' src='/images/delete.png' />
                    </div>
                    <div class="close close-js"></div>
                </div>
            </div>
            <div class="product-modal-view--cont">
                <div class="product-modal-view--group">
                    <div class="product-modal-view--name">Артикул</div>
                    <div class="product-modal-view--value" data-value="article"></div>
                </div>
                <div class="product-modal-view--group">
                    <div class="product-modal-view--name">Название</div>
                    <div class="product-modal-view--value" data-value="name"></div>
                </div>
                <div class="product-modal-view--group">
                    <div class="product-modal-view--name">Статус</div>
                    <div class="product-modal-view--value" data-value="status"></div>
                </div>
                <div class="product-modal-view--group">
                    <div class="product-modal-view--name">Атрибуты</div>
                    <div class="product-modal-view--value" data-value="data"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
