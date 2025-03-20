@extends('layouts.admin')
@section('content')
    <form method="POST" id="productForm" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row mt-4">
            <h3 class="mb-4 pb-4 border-bottom">Создание продукта</h3>
            <div class="col-md-9 base-form">
                <div class="p-3 mb-3 bg-light border">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name') }}" placeholder="Наименование продутка" required>
                                <label for="name">Наименование продукта</label>
                                @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" id="cost" class="form-control @error('cost') is-invalid @enderror"
                                       name="cost" value="{{ old('cost') }}" placeholder="Стоимость продукта" required>
                                <label for="cost">Стоимость продукта</label>
                                @error('cost')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 mb-3 bg-light border">
                    <div class="row">
                        <div class="col-md-12">
                            <h6>Описание товара</h6>
                            <textarea id="description" name="description" aria-label="Описание продукта"
                                      class="ckeditor form-control @error('description') is-invalid @enderror"
                                      placeholder="Полное описание" rows="7">{{ trim(old('description')) }}</textarea>
                            @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 adding-forms">
                @if(!$categories->isEmpty())
                    <div class="p-3 mb-3 bg-light border ''">
                        <h6 class="my-3 pb-3 border-bottom">Основная категория</h6>
                        @error('category_id')<div class="is-invalid"></div>@enderror
                        <select name="category_id" class="js-choices" data-placeholder="-=Выбрать категорию=-">
                            <option></option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                @endif
            </div>
        </div>
    </form>
    <div class="p-3 mb-3 bg-light border">
        <button form="productForm" type="submit" class="btn btn-success w-100">Сохранить</button>
    </div>
@endsection
