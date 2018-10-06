<form action="{{route('stripe.store')}}" method="POST">
    <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="pk_test_w6X0pgzaYcT2Bm1vkIfiGAMD"
            data-image="https://ru.zenlix.com/img/logo_site.png"
            data-name="Your Website Name"
            data-panel-label="Update Card Details"
            data-label="Update Card Details"
            data-allow-remember-me=false
            data-locale="auto">
    </script>
</form>