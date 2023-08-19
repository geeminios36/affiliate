<style>
    textarea {
        resize: none;
    }
</style>
<div class="modal fade" id="payment-request-modal" tabindex="-1" role="dialog"
    aria-labelledby="payment-request-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="smallBody">
                <div class="alert alert-danger" style="display:none"></div>
                @php
                    $wallets = \App\Wallet::where('user_id', Auth::user()->id)->first();
                    
                @endphp
                <form id="payment-request-form" method="POST"
                    enctype="multipart/form-data"
                    action={{ route('create-payment-request') }}>
                    @csrf
                    <div
                        class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-3">Payment Request</h3>
                        <p class="">
                            Amount in your wallet: <span
                                class="wallet_amount font-weight-bold">{{ single_price($wallets->amount) }}</span>
                            </span>
                        </p>
                    </div>
                    <div class="form-group">
                        <label for="message">Message
                        </label>
                        <textarea rows="5" class="form-control" id="message"
                            aria-label="messages" name="message" placeholder="What's on your mind?"></textarea>
                        <small id="messageHelpText" class="form-text text-red">
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input placeholder="How much do you want to withdraw?"
                            type="tel" class="form-control" id="amount"
                            name="amount">
                        <small id="amountHelpText" class="form-text text-red">

                        </small>
                    </div>
                    <div class="text-right">
                        <button type="button"
                            onClick="createNewPaymentRequeset()"
                            class="btn btn-primary rounded-2"
                            id="form-submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
