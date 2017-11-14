<div class="flex flex-column justify-between items-start col-w-bg mh2 mv4 br3 mw-20">
    <div class="pv4 flex justify-center items-center flex-auto ph2">
        <img src="{{ $featured_product->imageUrl('thumb') }}"
             alt=""
             class="mw-100"
        >
    </div>
    <div class="pl2">
        <p class="b body-type col-d ttu mb2">{{ $featured_product->title }}</p>
        <p class="ttu col-mg f6 body-type mt0">{{ $featured_product->code }}</p>
    </div>
</div>