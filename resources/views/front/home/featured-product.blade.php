<div class="flex flex-column justify-between items-start col-w-bg mh2 mv4 br3 mw-20">
    <div class="pv4 flex justify-center items-center flex-auto ph2">
        <a href="/products/{{ $featured_product->slug }}" class="link">
            <img src="{{ $featured_product->imageUrl('thumb') }}"
                 alt=""
                 class="mw-100"
            >
        </a>
    </div>
    <div class="pl2">
        <a href="/products/{{ $featured_product->slug }}" class="link">
            <p class="ff-title col-d mb2">{{ $featured_product->title }}</p>
            <p class="ttu col-mg ff-fine-body mt0">{{ $featured_product->code }}</p>
        </a>
    </div>
</div>