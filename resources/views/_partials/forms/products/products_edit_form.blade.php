<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('name', "Product Name:", []) !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter a product name']) !!}
        @if($errors->has('name'))
            <span class="wow flash error-msg">{{ $errors->first('name') }}</span>
        @endif
    </div>
    <div class="form-group">
        {!! Form::label('category_id', "Category:", []) !!}
        {!! Form::select('category_id', str_replace('_', ' ', App\Models\Category::lists('name', 'id')->all()), $product->category->id,  [ 'class'=>'form-control product-categories']) !!}
        @if($errors->has('category_id'))
            <span class="wow flash error-msg">{{ $errors->first('category_id') }}</span>
        @endif
    </div>
    <div class="form-group">
        {!! Form::label('subcategory_id', "Sub category:", []) !!}
        {!! Form::select('subcategory_id', str_replace('_', ' ', App\Models\SubCategory::lists('name', 'id')->all()), $product->subcategory->id, [ 'class' => 'form-control product-subcategories']) !!}
        @if($errors->has('subcategory_id'))
            <span class="wow flash error-msg">{{ $errors->first('subcategory_id') }}</span>
        @endif
    </div>
    <div class="form-group">
        {!! Form::label('brand_id', "Product manufacturer:", []) !!}
        {!! Form::select('brand_id', App\Models\Brand::lists('name', 'id')->all(), $product->brand->id, [ 'class'=>'form-control product-brands']) !!}
        @if($errors->has('brand_id'))
            <span class="wow flash error-msg">{{ $errors->first('brand_id') }}</span>
        @endif
    </div>
    <div class="form-group">
        {!! Form::label('quantity', "Product quantity: (between 1 and 1000)", []) !!}
        {!! Form::text('quantity', null, ['class' => 'form-control', 'placeholder' => 'Enter the quantity']) !!}
        @if($errors->has('quantity'))
            <span class="wow flash error-msg">{{ $errors->first('quantity') }}</span>
        @endif
    </div>

    <div class="form-group">
        {!! Form::label('price', "Product price: ", []) !!}
        {!! Form::text('price', isset($product) ? $product->price->getAmount() : null, ['class' => 'form-control', 'placeholder' => 'This is required']) !!}
        @if($errors->has('price'))
            <span class="wow flash error-msg">{{ $errors->first('price') }}</span>
        @endif
    </div>
    <div class="form-group">
        {!! Form::label('discount', "Product Discount (percentage, eg 25.50). 0 is assumed if left blank: ", []) !!}
        {!! Form::text('discount', isset($product) ? $product->getDiscountRate() : null, ['class' => 'form-control', 'placeholder' => 'Enter a discount, if any']) !!}
        @if($errors->has('discount'))
            <span class="wow flash error-msg">{{ $errors->first('discount') }}</span>
        @endif
    </div>
    <div class="form-group">
        {!! Form::label('warranty_period', "Warranty (months):", []) !!}
        {!! Form::text('warranty_period', null, ['class' => 'form-control', 'placeholder' => 'e.g 24']) !!}
        @if($errors->has('warranty_period'))
            <span class="error_msg">{{ $errors->first('warranty_period') }}</span>
        @endif
    </div>
    <div class="row">
        <div class="col-md-6">
            <h2>Current product Image</h2>
            @if(file_exists_on_server($product->image))
                <div class="current-image">
                    <img src="{{ display_img($product) }}" class="img-responsive img-thumbnail">
                </div>
            @else
                <div>
                    <p class="text text-center">
                        NONE
                    </p>
                </div>
            @endif
            <p class="m-t-10">You can upload a new image here</p>
            @if($errors->has('image'))
                <p class="error_msg">{{ $errors->first('image') }}</p>
            @endif
            <div class="input-group image-preview m-t-10">
                <input type="text" class="form-control image-preview-filename" name="image" id="image"
                       disabled="disabled">
                <!-- don't give a name === doesn't send on POST/GET -->
                <span class="input-group-btn">
                    <!-- image-preview-clear button -->
                    <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                        <span class="glyphicon glyphicon-remove"></span> Clear
                    </button>
                    <!-- image-preview-input -->
                    <div class="btn btn-default image-preview-input">
                        <span class="glyphicon glyphicon-folder-open"></span>
                        <span class="image-preview-input-title">Browse</span>
                        <input type="file" accept="image/png, image/jpeg" name="image"/> <!-- rename it -->
                    </div>
                    <br/>
                </span>
            </div>
        </div>

    </div>
</div>
<div class="clearfix"></div>
<div class="row m-t-20 m-b-20">
    <div class="col-md-5">
        <h2>Product Descriptions</h2>

        <div class="form-group">
            <label for="editor_small">Short product description</label>
        <textarea name="description_short" id="editor_small" class="custom-editor" cols="15"
                  rows="5">{{ $product->description_short }}</textarea>
            @if($errors->has('description_short'))
                <span class="wow flash error-msg">{{ $errors->first('description_short') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-7">
        <div class="form-group">
            <label for="editor">Long product description</label>
            <textarea name="description_long" id="editor" class="custom-editor" cols="30"
                      rows="10">{{ $product->description_long }}</textarea>
            @if($errors->has('description_long'))
                <span class="wow flash error-msg">{{ $errors->first('description_long') }}</span>
            @endif
        </div>
    </div>
    <hr/>
    <div class="col-md-12">
        <div class="form-group">
            <label for="editor_stuff">What to be included with the product</label>
        <textarea name="stuff_included" id="editor_stuff" class="custom-editor" cols="30"
                  rows="10">{{ $product->stuff_included }}</textarea>
            @if($errors->has('stuff_included'))
                <span class="wow flash error-msg">{{ $errors->first('stuff_included') }}</span>
            @endif
        </div>
    </div>

</div>