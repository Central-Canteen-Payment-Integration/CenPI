<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-cTqhWteHD6IgJ7nU"></script>
<body>
</body>
<script>
    var snapToken = '<?= $data['snapToken']; ?>';
    var baseUrl = '<?= BASE_URL; ?>';

    snap.pay(snapToken, {
        onSuccess: function(result) {
            swalert('success', 'Success Payment, You will be redirected to My Orders!', { timer: 2500 });
            setTimeout(function() {
                window.location.href = baseUrl + '/User/order'; 
            }, 3000);
        },
        onPending: function(result) {
            swalert('info', 'You will be redirected to My Orders!', { timer: 2500 });
            setTimeout(function() {
                window.location.href = baseUrl + '/User/order'; 
            }, 3000);
        },
        onError: function(result) {
            console.log(result);
        },
        onClose: function() {
            swalert('info', 'You will be redirected to My Orders!', { timer: 2500 });
            setTimeout(function() {
                window.location.href = baseUrl + '/User/order'; 
            }, 3000);
        }
    });
</script>