    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Payment Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Choose a payment method:</p>
                    <form action="pay_bill.php" method="post">
                        <input type="hidden" name="pay" value="<?php echo $row['id']; ?>">
                        <label for="gcash">Gcash</label>
                        <input type="radio" id="gcash" name="payment_method" value="gcash" required>
                        <br>
                        <label for="paymaya">Paymaya</label>
                        <input type="radio" id="paymaya" name="payment_method" value="paymaya" required>
                        <br><br>
                        <button type="submit" class="btn btn-success">Confirm Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
