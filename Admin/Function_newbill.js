<script>
function updateTotalAmount() {
    var currentAmount = parseFloat(document.getElementById('current').value) || 0;
    var serviceFee = parseFloat(document.getElementById('service').value) || 0;
    var penalties = parseFloat(document.getElementById('penalties').value) || 0;

    var totalAmount = currentAmount + serviceFee + penalties;

    // Check if totalAmount is a valid number before calling toFixed
    if (!isNaN(totalAmount)) {
        document.getElementById('total').value = totalAmount.toFixed(2);
    }
}

// Attach the updateTotalAmount function to the 'input' event of the current amount field
document.getElementById('current').addEventListener('input', updateTotalAmount);



function updateBillingDetails() {
    var selectedUserId = document.getElementById('tableusers_id').value;
    var currentAmount = parseFloat(document.getElementById('current').value) || 0;

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);

                if (response.error) {
                    console.error('Error: ' + response.error);
                } else {
                    document.getElementById('previous').value = parseFloat(response.previousBalance) || 0;
                    
                    // Set the service fee to 10 pesos
                    document.getElementById('service').value = 10;
                    
                    document.getElementById('penalties').value = parseFloat(response.penalties) || 0;

                    var totalAmount = currentAmount + 10 + (parseFloat(response.penalties) || 0);

                    // Check if totalAmount is a valid number before calling toFixed
                    if (!isNaN(totalAmount)) {
                        document.getElementById('total').value = totalAmount.toFixed(2);
                    } 
                }
            } else {
                console.error('Error: ' + xhr.status);
            }
        }
    };

    xhr.open('POST', 'get_billing_details.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    
    // Adjust the data being sent to match what your PHP script expects
    xhr.send('userId=' + selectedUserId);
}

document.getElementById('tableusers_id').addEventListener('change', updateBillingDetails);

</script>



