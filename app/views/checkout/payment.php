<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-cTqhWteHD6IgJ7nU"></script>

<button id="pay-button">Pay Now</button>

<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        snap.pay('<?= $data['snapToken']; ?>', {
            onSuccess: function(result) {
                console.log(result);
                window.location.href = '/checkout/success';
            },
            onPending: function(result) {
                console.log(result);
                alert('Waiting for payment...');
            },
            onError: function(result) {
                console.error(result);
                alert('Payment failed!');
            }
        });
    });
</script>