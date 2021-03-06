<div class="modal" id="editTransferModal<?php echo $transfer_id; ?>" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content bg-dark">
      <div class="modal-header">
        <h5 class="modal-title text-white"><i class="fa fa-fw fa-exchange-alt mr-2"></i>Modify Transfer</h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="post.php" method="post" autocomplete="off">
        <div class="modal-body bg-white">
          <input type="hidden" name="transfer_id" value="<?php echo $transfer_id; ?>">
          <input type="hidden" name="expense_id" value="<?php echo $expense_id; ?>">
          <input type="hidden" name="revenue_id" value="<?php echo $revenue_id; ?>">
          
          <ul class="nav nav-pills nav-justified mb-3" id="pills-tab<?php echo $transfer_id; ?>">
            <li class="nav-item">
              <a class="nav-link active" id="pills-details-tab<?php echo $transfer_id; ?>" data-toggle="pill" href="#pills-details<?php echo $transfer_id; ?>">Details</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="pills-notes-tab<?php echo $transfer_id; ?>" data-toggle="pill" href="#pills-notes<?php echo $transfer_id; ?>">Notes</a>
            </li>
          </ul>

          <div class="tab-content" id="pills-tabContent<?php echo $transfer_id; ?>">

            <div class="tab-pane fade show active" id="pills-details<?php echo $transfer_id; ?>">

              <div class="form-row">
                <div class="form-group col-sm">
                  <label>Date <strong class="text-danger">*</strong></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-fw fa-calendar"></i></span>
                    </div>
                    <input type="date" class="form-control" name="date" value="<?php echo $transfer_date; ?>" required>
                  </div>
                </div>
                <div class="form-group col-sm">
                  <label>Amount <strong class="text-danger">*</strong></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-fw fa-dollar-sign"></i></span>
                    </div>
                    <input type="number" class="form-control" step="0.01" min="0" name="amount" placeholder="Amount to transfer" value="<?php echo $transfer_amount; ?>" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Transfer <strong class="text-danger">*</strong></label>
                <div class="input-group"> 
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-fw fa-piggy-bank"></i></span>
                  </div> 
                  <select class="form-control select2" name="account_from" required>
                    <?php 
                    
                    $sql_accounts = mysqli_query($mysqli,"SELECT * FROM accounts WHERE company_id = $session_company_id ORDER BY account_name ASC"); 
                      while($row = mysqli_fetch_array($sql_accounts)){
                        $account_id_select = $row['account_id'];
                        $account_name_select = $row['account_name'];
                        $opening_balance = $row['opening_balance'];
                        
                        $sql_payments = mysqli_query($mysqli,"SELECT SUM(payment_amount) AS total_payments FROM payments WHERE account_id = $account_id_select");
                        $row = mysqli_fetch_array($sql_payments);
                        $total_payments = $row['total_payments'];
                        
                        $sql_revenues = mysqli_query($mysqli,"SELECT SUM(revenue_amount) AS total_revenues FROM revenues WHERE account_id = $account_id_select");
                        $row = mysqli_fetch_array($sql_revenues);
                        $total_revenues = $row['total_revenues'];

                        $sql_expenses = mysqli_query($mysqli,"SELECT SUM(expense_amount) AS total_expenses FROM expenses WHERE account_id = $account_id_select");
                        $row = mysqli_fetch_array($sql_expenses);
                        $total_expenses = $row['total_expenses'];

                        $balance = $opening_balance + $total_payments + $total_revenues - $total_expenses;
                    
                    ?>
                    <option <?php if($transfer_account_from == $account_id_select){ ?> selected <?php } ?> value="<?php echo $account_id_select; ?>"><?php echo $account_name_select; ?> [$<?php echo number_format($balance,2); ?>]</option>
                    <?php
                    }
                    
                    ?>
                  </select>
                </div>
              </div>
              
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-fw fa-arrow-right"></i></span>
                  </div>
                  <select class="form-control select2" name="account_to" required>
                    <?php 
                    
                    $sql2 = mysqli_query($mysqli,"SELECT * FROM accounts WHERE company_id = $session_company_id ORDER BY account_name ASC"); 
                    while($row = mysqli_fetch_array($sql2)){
                      $account_id2 = $row['account_id'];
                      $account_name = $row['account_name'];
                      $opening_balance = $row['opening_balance'];

                      $sql_payments = mysqli_query($mysqli,"SELECT SUM(payment_amount) AS total_payments FROM payments WHERE account_id = $account_id2");
                      $row = mysqli_fetch_array($sql_payments);
                      $total_payments = $row['total_payments'];

                      $sql_revenues = mysqli_query($mysqli,"SELECT SUM(revenue_amount) AS total_revenues FROM revenues WHERE account_id = $account_id2");
                      $row = mysqli_fetch_array($sql_revenues);
                      $total_revenues = $row['total_revenues'];
                      
                      $sql_expenses = mysqli_query($mysqli,"SELECT SUM(expense_amount) AS total_expenses FROM expenses WHERE account_id = $account_id2");
                      $row = mysqli_fetch_array($sql_expenses);
                      $total_expenses = $row['total_expenses'];

                      $balance = $opening_balance + $total_payments + $total_revenues - $total_expenses;

                    ?>
                    <option <?php if($transfer_account_to == $account_id2){ ?> selected <?php } ?> value="<?php echo $account_id2; ?>"><?php echo $account_name; ?> [$<?php echo number_format($balance,2); ?>]</option>
                    <?php
                    }
                    
                    ?>
                  </select>
                </div>
              </div>

            </div>

            <div class="tab-pane fade" id="pills-notes<?php echo $transfer_id; ?>">
              
              <div class="form-group">
                <textarea class="form-control" rows="8" name="notes"><?php echo $transfer_notes; ?></textarea>
              </div>

            </div>

          </div>

        </div>

        <div class="modal-footer bg-white">
          <a href="post.php?delete_transfer=<?php echo $transfer_id; ?>" class="btn btn-danger mr-auto"><i class="fa fa-trash text-white"></i></a>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" name="edit_transfer" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>