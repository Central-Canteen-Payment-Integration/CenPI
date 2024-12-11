<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-cTqhWteHD6IgJ7nU"></script>
<script>
    snap.pay('<?= $data['snapToken']; ?>', {
        onSuccess: function(result) {
            console.log(result);
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
</script>