<div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1 produts-sidebar-filter">
    <div class="filter-widget">
        <h4 class="fw-title">Collection</h4>
        <ul class="filter-catagories">
            @foreach ($categories as $category)
        <li><a href="{{route('shoppage.category',$category->id)}}">{{$category->category_name}}</a></li>
            @endforeach

        </ul>
    </div>
  <form action="{{route('shoppage.filterbyprice')}}" method="POST">
    @csrf
    <div class="filter-widget">
        <h4 class="fw-title">Brand</h4>
        <div class="fw-brand-check">
          @foreach ($brands as $brand)
          <div class="bc-item">
            <label for="bc-{{$brand->id}}">
              {{$brand->brand_name}}
                <input type="checkbox" id="bc-{{$brand->id}}" name="brand[]" value="{{$brand->id}}">
                <span class="checkmark"></span>
            </label>
        </div>
          @endforeach
            

        </div>
    </div>
    <div class="filter-widget">
        <h4 class="fw-title">Price</h4>
        <div class="filter-range-wrap">
            <div class="range-slider">
                <div class="price-input">
                <input type="text" id="minamount" name="minamount">
                <input type="text" id="maxamount" name="maxamount">
                </div>
            </div>
            <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                data-min="{{round($minprice)}}" data-max="{{round($maxprice)}}">
                <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
            </div>
        </div>
        <button type="submit" class="btn filter-btn">Filter</button>
    </div>
  </form>

    <div class="filter-widget">
        <h4 class="fw-title">Tags</h4>
        <div class="fw-tags">
          @foreach ($tags as $tag)
        <a href="{{route('shoppage.tagproduct',$tag->id)}}">{{$tag->tag_name}}</a>
          @endforeach
        </div>
    </div>
</div>