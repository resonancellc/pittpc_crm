<div class="modal fade" id="addInvoicePaymentModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-piggy-bank"></i> New Account</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="post.php" method="post" autocomplete="off">
        <input type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>">
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-sm-8">
              <label>Date</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
                <input type="date" class="form-control" name="date" required>
              </div>
            </div>
            <div class="form-group col-sm-4">
              <label>Amount</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-usd"></i></span>
                </div>
                <input type="number" class="form-control" step="0.01" min="0" name="amount" value="<?php echo $invoice_amount; ?>" required>
              </div>
            </div>
          </div>
          <div class="form-row">  
            <div class="form-group col">
              <label>Account</label>
              <div class="input-group"> 
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-university"></i></span>
                </div> 
                <select class="form-control" name="account" required>
                  <option value="">- Account -</option>
                  <?php 
                  
                  $sql = mysqli_query($mysqli,"SELECT * FROM accounts"); 
                  while($row = mysqli_fetch_array($sql)){
                    $account_id = $row['account_id'];
                    $account_name = $row['account_name'];
                  ?>
                    <option value="<?php echo $account_id; ?>"><?php echo "$account_name"; ?></option>
                  
                  <?php
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group col">
              <label>Payment Method</label>
              <div class="input-group"> 
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-university"></i></span>
                </div> 
                <select class="form-control" name="payment_method" required>
                  <option value="">- Payment Method -</option>
                  <?php 
                  
                  $sql = mysqli_query($mysqli,"SELECT * FROM categories WHERE category_type = 'Payment Method'"); 
                  while($row = mysqli_fetch_array($sql)){
                    $category_id = $row['category_id'];
                    $category_name = $row['category_name'];
                  ?>
                    <option value="<?php echo $category_id; ?>"><?php echo "$category_name"; ?></option>
                  
                  <?php
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" name="add_invoice_payment" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>