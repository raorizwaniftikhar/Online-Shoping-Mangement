<?php 
$item  = $_REQUEST['item'];
$amount = $_REQUEST['amount'];
$qty = $_REQUEST['qty'];
?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="payPalForm">

 <input type="hidden" name="item_number" value="<?php echo $item; ?>">
 <input type="hidden" name="cmd" value="_xclick">
 <input type="hidden" name="no_note" value="<?php echo $qty; ?>">
 <input type="hidden" name="business" value="tauqer15@gmail.com">
 <input type="hidden" name="currency_code" value="USD">
 <input type="hidden" name="return" value="http://freelanceswitch.com/payment-complete/">

<input name="item_name" type="hidden" id="item_name" value="Name"  size="45">

<input name="amount" type="hidden" id="amount" value="<?php echo $amount; ?>" size="45">



 </form>
<script type="text/javascript">
document.forms["payPalForm"].submit();
</script>