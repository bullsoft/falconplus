<div class="container">
    <div class="row">
        <div>
            <!-- CREDIT CARD FORM STARTS HERE -->
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading">
                    <div class="row display-tr" >
                        <h3 class="panel-title display-td">&nbsp;支付结果</h3>
                    </div>
                </div>
                <div class="panel-body">
                    <form role="form" id="payment-form">
                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-success btn-lg btn-block" type="submit">支付成功</button>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-fail btn-lg btn-block" type="submit">支付失败</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- CREDIT CARD FORM ENDS HERE -->
        </div>
    </div>
</div>

<script type="text/javascript">
 window.open('{{redirectUrl}}','_blank');
</script>
