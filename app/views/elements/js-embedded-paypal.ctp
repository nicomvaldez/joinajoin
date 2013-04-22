<script type="text/javascript">
	var dgFlow = new PAYPAL.apps.DGFlow({trigger:'pay_button'});
	function MyEmbeddedFlow(embeddedFlow) {
		this.embeddedPPObj = embeddedFlow;
		this.paymentSuccess = function () {
			this.embeddedPPObj.closeFlow();
		};
		this.paymentCanceled = function () {
			this.embeddedPPObj.closeFlow();
		};
     }
	 var myEmbeddedPaymentFlow = new MyEmbeddedFlow(dgFlow);
</script>