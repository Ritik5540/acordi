<button id="pay-btn">Pay Now</button>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
document.getElementById('pay-btn').onclick = function () {

    fetch('create-order.php')
    .then(res => res.json())
    .then(data => {

        var options = {
            "key": "rzp_test_SYhOqsVk99ss1T",
            "amount": "50000",
            "currency": "INR",
            "name": "Test Company",
            "description": "Test Payment",
            "order_id": data.order_id,

            "handler": function (response){
                // send to server for verification
                fetch('verify.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(response)
                })
                .then(res => res.text())
                .then(data => alert(data));
            },

            "theme": {
                "color": "#3399cc"
            }
        };

        var rzp = new Razorpay(options);
        rzp.open();
    });
};
</script>