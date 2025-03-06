<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php
                echo form_open_multipart('backend/setting/update', [
                    'autocomplete' => false, 'id' => 'edit_setting', 'method' => 'post'
                ])
                ?>
                <div class="form-group row"><label for="name" class="col-sm-2 col-form-label">Referral Coins *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" name="referral_amount" value="<?= $Setting->referral_amount ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="level_1" class="col-sm-2 col-form-label">Referral Level 1
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" min="0" max="100" name="level_1" value="<?= $Setting->level_1 ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="level_2" class="col-sm-2 col-form-label">Referral Level 2
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" min="0" max="100" name="level_2" value="<?= $Setting->level_2 ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="level_3" class="col-sm-2 col-form-label">Referral Level 3
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" min="0" max="100" name="level_3" value="<?= $Setting->level_3 ?>" required>
                    </div>
                </div>
                <div class="form-group row"><label for="level_4" class="col-sm-2 col-form-label">Referral Level 4
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" min="0" max="100" name="level_4" value="<?= $Setting->level_4 ?>" required>
                    </div>
                </div>
                <div class="form-group row"><label for="level_5" class="col-sm-2 col-form-label">Referral Level 5
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" min="0" max="100" name="level_5" value="<?= $Setting->level_5 ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="referral_id" class="col-sm-2 col-form-label">Referral ID
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="referral_id" value="<?= $Setting->referral_id ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="referral_link" class="col-sm-2 col-form-label">Referral Link
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="referral_link" value="<?= $Setting->referral_link ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="name" class="col-sm-2 col-form-label">Contact Us *</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" type="text" name="contact_us" required id="contact_us"><?= $Setting->contact_us ?></textarea>
                    </div>
                </div>

                <div class="form-group row"><label for="name" class="col-sm-2 col-form-label">About Us *</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" type="text" name="about_us" required id="about_us"><?= $Setting->about_us ?></textarea>
                    </div>
                </div>

                <div class="form-group row"><label for="refund_policy" class="col-sm-2 col-form-label">Refund Policy
                        *</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" type="text" name="refund_policy" required id="refund_policy"><?= $Setting->refund_policy ?></textarea>
                    </div>
                </div>

                <div class="form-group row"><label for="name" class="col-sm-2 col-form-label">Terms & Conditions
                        *</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" type="text" name="terms" required id="terms"><?= $Setting->terms ?></textarea>
                    </div>
                </div>

                <div class="form-group row"><label for="name" class="col-sm-2 col-form-label">Privacy Policy *</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" type="text" name="privacy_policy" required id="privacy_policy"><?= $Setting->privacy_policy ?></textarea>
                    </div>
                </div>

                <div class="form-group row"><label for="name" class="col-sm-2 col-form-label">Help & Support *</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" type="text" name="help_support" required id="help_support"><?= $Setting->help_support ?></textarea>
                    </div>
                </div>

                <!-- <div class="form-group row"><label for="default_otp" class="col-sm-2 col-form-label">Default OTP
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" min="0" name="default_otp"
                            value="<?= $Setting->default_otp ?>" required>
                    </div>
                </div> -->

                <div class="form-group row"><label for="game_for_private" class="col-sm-2 col-form-label">Game For
                        Private *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" min="0" name="game_for_private" value="<?= $Setting->game_for_private ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="joining_amount" class="col-sm-2 col-form-label">Joining Amount
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" min="0" name="joining_amount" value="<?= $Setting->joining_amount ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="min_withdrawal" class="col-sm-2 col-form-label">Minimum Withdrawal
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" min="0" name="min_withdrawal"
                            value="<?= $Setting->min_withdrawal ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="upi_merchant_id" class="col-sm-2 col-form-label">Upi Merchant Id
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="upi_merchant_id" value="<?= $Setting->upi_merchant_id ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="upi_secret_key" class="col-sm-2 col-form-label">Upi Secret Key
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="upi_secret_key" value="<?= $Setting->upi_secret_key ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="admin_commission" class="col-sm-2 col-form-label">Admin
                        Comission *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" min="0" name="admin_commission" value="<?= $Setting->admin_commission ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="whats_no" class="col-sm-2 col-form-label">Whatsapp *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" maxlength="10" name="whats_no" value="<?= $Setting->whats_no ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="app_version" class="col-sm-2 col-form-label">App Version
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="app_version" value="<?= $Setting->app_version ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="app_url" class="col-sm-2 col-form-label">App*(<?= ini_get('upload_max_filesize') ?>)</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="file" name="app_url">
                    </div>
                </div>

                <div class="form-group row"><label for="logo" class="col-sm-2 col-form-label">Logo*</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="file" name="logo" accept="image/*">
                    </div>
                </div>

                <div class="form-group row"><label for="bonus" class="col-sm-2 col-form-label">Bonus
                        *</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="bonus">
                            <option value="0" <?= ($Setting->bonus == '0' ? 'selected' : '') ?>>No</option>
                            <option value="1" <?= ($Setting->bonus == '1' ? 'selected' : '') ?>>Yes</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row"><label for="bonus_amount" class="col-sm-2 col-form-label">Bonus
                        Amount *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" min="0" name="bonus_amount" value="<?= $Setting->bonus_amount ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="payment_gateway" class="col-sm-2 col-form-label">Payment Gateway
                        *</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="payment_gateway">
                            <option value="0" <?= ($Setting->payment_gateway == '0' ? 'selected' : '') ?>>Razorpay
                            </option>
                            <option value="1" <?= ($Setting->payment_gateway == '1' ? 'selected' : '') ?>>Whatsapp
                            </option>
                            <option value="2" <?= ($Setting->payment_gateway == '2' ? 'selected' : '') ?>>Cashfree
                            </option>
                            <option value="3" <?= ($Setting->payment_gateway == '3' ? 'selected' : '') ?>>Paytm</option>
                            <option value="4" <?= ($Setting->payment_gateway == '4' ? 'selected' : '') ?>>PayUmoney
                            </option>
                            <option value="5" <?= ($Setting->payment_gateway == '5' ? 'selected' : '') ?>>UPIFreeWay
                            </option>
                            <option value="6" <?= ($Setting->payment_gateway == '6' ? 'selected' : '') ?>>AtomPay
                            </option>
                            <option value="7" <?= ($Setting->payment_gateway == '7' ? 'selected' : '') ?>>Custom
                            </option>
                            <option value="7" <?= ($Setting->payment_gateway == '8' ? 'selected' : '') ?>>Neokard
                            </option>
                            <option value="9" <?= ($Setting->payment_gateway == '9' ? 'selected' : '') ?>>Upi Gateway
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group row"><label for="qr_image" class="col-sm-2 col-form-label">QR Payment Image</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="file" name="qr_image" accept="image/*">
                    </div>
                </div>
                

                <div class="form-group row"><label for="app_upi_code" class="col-sm-2 col-form-label">App UPI Code</label>
                    <div class="col-sm-10">
                    <input class="form-control" type="text" name="app_upi_code" id="app_upi_code" value="<?= $Setting->app_upi_code ?>">                    </div>
                </div>

                <div class="form-group row"><label for="upi_id" class="col-sm-2 col-form-label">UPI ID
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="upi_id" id="upi_id" value="<?= $Setting->upi_id ?>">
                    </div>
                </div>

                <div class="form-group row"><label for="payumoney_key" class="col-sm-2 col-form-label">PayUmoney Key
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="payumoney_key" id="payumoney_key" value="<?= $Setting->payumoney_key ?>">
                    </div>
                </div>

                <div class="form-group row"><label for="payumoney_salt" class="col-sm-2 col-form-label">PayUmoney salt
                    </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="payumoney_salt" id="payumoney_salt" value="<?= $Setting->payumoney_salt ?>">
                    </div>
                </div>

                <div class="form-group row"><label for="neokred_client_secret" class="col-sm-2 col-form-label">Neokard
                        Client Secret *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="neokred_client_secret" id="neokred_client_secret" value="<?= $Setting->neokred_client_secret ?>">
                    </div>
                </div>

                <div class="form-group row"><label for="neokred_project_id" class="col-sm-2 col-form-label">Neokard
                        Project Id</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="neokred_project_id" id="neokred_project_id" value="<?= $Setting->neokred_project_id ?>">
                    </div>
                </div>

                <div class="form-group row"><label for="symbol" class="col-sm-2 col-form-label">Symbol
                        *</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="symbol">
                            <option value="0" <?= ($Setting->symbol == '0' ? 'selected' : '') ?>>Coin</option>
                            <option value="1" <?= ($Setting->symbol == '1' ? 'selected' : '') ?>>Rupee</option>
                            <option value="2" <?= ($Setting->symbol == '2' ? 'selected' : '') ?>>Dollar</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row"><label for="upi_gateway_key" class="col-sm-2 col-form-label">UPI Gateway API Key
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="upi_gateway_key" id="upi_gateway_key" value="<?= $Setting->upi_gateway_api_key ?>">
                    </div>
                </div>

                <div class="form-group row"><label for="razor_api_key" class="col-sm-2 col-form-label">Razor API Key
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="razor_api_key" id="razor_api_key" value="<?= $Setting->razor_api_key ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="razor_secret_key" class="col-sm-2 col-form-label">Razor Secert
                        Key
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="razor_secret_key" id="razor_secret_key" value="<?= $Setting->razor_secret_key ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="cashfree_stage" class="col-sm-2 col-form-label">Payment
                        Stage (TEST or PROD)
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="cashfree_stage" id="cashfree_stage" value="<?= $Setting->cashfree_stage ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="cashfree_client_id" class="col-sm-2 col-form-label">Cashfree
                        Client Id
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="cashfree_client_id" id="cashfree_client_id" value="<?= $Setting->cashfree_client_id ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="cashfree_client_secret" class="col-sm-2 col-form-label">Cashfree
                        Client Secert
                        Key
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="cashfree_client_secret" id="cashfree_client_secret" value="<?= $Setting->cashfree_client_secret ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="paytm_mercent_id" class="col-sm-2 col-form-label">Paytm Mercent
                        Id
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="paytm_mercent_id" id="paytm_mercent_id" value="<?= $Setting->paytm_mercent_id ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="paytm_mercent_key" class="col-sm-2 col-form-label">Paytm Mercent
                        Key
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="paytm_mercent_key" id="paytm_mercent_key" value="<?= $Setting->paytm_mercent_key ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="share_text" class="col-sm-2 col-form-label">Share Text
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="share_text" id="share_text" value="<?= $Setting->share_text ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="bank_detail_field" class="col-sm-2 col-form-label">Bank Detail
                        Field
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="bank_detail_field" id="bank_detail_field" value="<?= $Setting->bank_detail_field ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="adhar_card_field" class="col-sm-2 col-form-label">Aadhar Card
                        Field
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="adhar_card_field" id="adhar_card_field" value="<?= $Setting->adhar_card_field ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="upi_field" class="col-sm-2 col-form-label">UPI Field
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="upi_field" id="upi_field" value="<?= $Setting->upi_field ?>" required>
                    </div>
                </div>

                <div class="form-group row"><label for="app_message" class="col-sm-2 col-form-label">App Message
                        *</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="app_message" id="app_message" value="<?= $Setting->app_message ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="sms_send" class="col-sm-2 col-form-label">SMS Send *</label>
                    <div class="col-sm-10">
                       <input class="form-control" type="number" name="sms_send" id="sms_send" value="<?= $Setting->sms_send ?>" readonly>
                    </div>
                </div>


                <div class="form-group row"><label for="aviator_bucket" class="col-sm-2 col-form-label">Aviator Bucket</label>
                    <div class="col-sm-6">
                        <input class="form-control" readonly type="text" name="aviator_bucket" id="aviator_bucket" value="<?= $Setting->aviator_bucket ?>">
                    </div>
                    <div class="col-sm-4">
                        <?php
                    echo form_button('button', 'Transfer', ['class' => 'btn btn-primary waves-effect waves-light mr-1 transfer']);
                      ?>
                    </div>
                </div>

                <div>
                    <?php if ($_ENV['ENVIRONMENT'] == 'demo' || $_ENV['ENVIRONMENT'] == 'fame') { ?>

                    <?php } else { ?>
                        <?php
                        echo form_submit('submit', 'Update', ['class' => 'btn btn-primary waves-effect waves-light mr-1']);
                        echo form_reset(['class' => 'btn btn-secondary waves-effect', 'value' => 'Cancel']);
                        ?>
                    <?php  } ?>

                </div>
            </div>
            <?php
            echo form_close();
            ?>
        </div>
    </div><!-- end col -->
</div>

<script>
    // user for ckeditor.
    CKEDITOR.replace('contact_us');
    CKEDITOR.replace('about_us');
    CKEDITOR.replace('refund_policy');
    CKEDITOR.replace('terms');
    CKEDITOR.replace('privacy_policy');
    CKEDITOR.replace('help_support');
</script>

<script>
$(document).on('click', '.transfer', function(e) {
    e.preventDefault();
    jQuery.ajax({
        type: 'POST',
        url: '<?= base_url('backend/Setting/Transfer') ?>',
        data: {
        },
        beforeSend: function() {},
        success: function(response) {
            if(response){
               $('#aviator_bucket').val(0)
            }
        },
        error: function(e) {}
    })
});
</script>