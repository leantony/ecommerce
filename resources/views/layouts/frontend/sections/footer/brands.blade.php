<div class="container" data-toggle-animation>
    <div id="brands-carousel" class="logo-slider  ">

        <h3 class="section-title">Shop By Brand</h3>

        <div class="logo-slider-inner">
            <div id="brand-slider" class="owl-carousel brand-slider custom-carousel owl-theme">
                @foreach($brands as $brand)
                    <div class="item p-all-10">
                        <a href="{{ route('brands.shop', ['brand' => $brand->id]) }}"
                           class="image" name="{{ $brand->name }}">
                            <img src="{{ display_img($brand, false, 'logo') }}" class="img-responsive img-thumbnail"
                                 style="width: 200px; height: 100px;">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
