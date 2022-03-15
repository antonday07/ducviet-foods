<a  href="{{ route('cart') }}"><i class="pe-7s-shopbag giohang"></i>
    {{-- <span class="product-count bg-black">{{ Cart::count() }}</span> --}}
    @php
        $cart = session('cart');
        $countCart = 0;
        if (!empty($cart)) {
          $countCart = count($cart);
        }
    @endphp
    <span class="product-count bg-black">{{ $countCart }}</span>
</a>