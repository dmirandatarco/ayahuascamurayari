<div>
    @if(Cart::content()->count())
        <li class="nav-item">
            <a class="nav-link text-capitalize" href="/reserva/checkout" aria-haspopup="true" aria-expanded="false">
                <span style="position: relative;">
                    <i class="fas fa-shopping-cart" style="font-size: 24px;"></i>
                <span class="cart-badge">{{Cart::content()->count()}}</span> <!-- Número de productos en el carrito -->
                </span>
            </a>
        </li>
    @else
        <li class="nav-item">
            <a class="nav-link text-capitalize" href="/reserva/checkout" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-shopping-cart" style="font-size: 24px;"></i>
                </span>
            </a>
        </li>
    @endif
</div>
