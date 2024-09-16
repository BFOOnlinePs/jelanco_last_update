<div class="card-body">
    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <a href="{{ route('product.index') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">قائمة الاصناف</span>
                        <span class="info-box-number">{{ $product_count }}</span>
                    </div>

                </div>
            </a>

        </div>

        <div class="col-md-4 col-sm-6 col-12">
            <a href="{{ route('category.index') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">مجموعات الأصناف</span>
                        <span class="info-box-number">{{ $category_count }}</span>
                    </div>

                </div>
            </a>


        </div>

        <div class="col-md-4 col-sm-6 col-12">
            <a href="{{ route('units.index') }}" style="text-decoration: none" class="text-dark">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">الوحدات</span>
                        <span class="info-box-number">{{ $unit_count }}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
