<?php
if ( $current_user->user_id <= 0 ) exit;
$current_user->init_wallet();
?>
<h4>Пополнить баланс</h4>
<hr />
<div class="row">
	<div class="col" style="max-width: 250px;">
		Сумма:
	</div>
	<div class="col">
		<input type="number" class="form-control" id="amount" name="amount" placeholder="Ваш баланс: <?php echo $current_user->wallet->balance;?> руб." />
	</div>
</div>
<br />
<div class="row">
	<div class="col">
		<span class="pull-right">
			<div class="wdo-btn btn-sm bg-purple" onClick="balance_refill();"><i class="fa fa-credit-card"></i> Продолжить</div>
		</span>
	</div>
</div>

<script>
function balance_refill()
{
	amount = parseInt($("#amount").val());
	$.ajax({
		type: "POST",
		url: "/user.balanceRefill",
		data: {
			"amount": amount
		},
		dataType: "JSON",
		success: function (response) {
			var alert_type = ( response.result == "false" ) ? "danger" : "success";
			showAlert(alert_type,response.message);
		}
	})
}
$(function(){
})
</script>