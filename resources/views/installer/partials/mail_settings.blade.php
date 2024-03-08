<h3>Mail settings</h3>
<section>

    <div class="form_wrapper">

     <div id="mail-message-wrapper" class="alert_"></div>

        <div class="form-group ">
            <label for="mail_driver">Mail driver</label>
            <select name="mail_driver" id="mail_driver">
                <option value="sendmail">sendmail</option>
                <option value="smtp">SMTP</option>
            </select>
        </div>
        <div class="form-group ">
            <label for="mail_host">Mail host</label>
            <input type="text" disabled name="mail_host" id="mail_host" value="" class="smtpClass">
        </div>
        <div class="form-group ">
            <label for="mail_port">Mail port</label>
            <input type="text"  disabled name="mail_port" id="mail_port" value="" class="smtpClass">
        </div>
        <div class="form-group ">
            <label for="mail_encryption">Mail encryption</label>
            <input type="text"  disabled name="mail_encryption" id="mail_encryption" value="" class="smtpClass">
        </div>
        <div class="form-group ">
            <label for="mail_username">Mail username</label>
            <input type="text"  disabled name="mail_username" id="mail_username" value="" class="smtpClass">
        </div>
        <div class="form-group ">
            <label for="mail_password">Mail password</label>
            <input type="password"  disabled name="mail_password" id="mail_password" value="" class="smtpClass">
        </div>
        <div class="form-group ">
            <label for="mail_from_address">Mail from address</label>
            <input type="text" name="mail_from_address" id="mail_from_address" value="">
        </div>
        <div class="form-group ">
            <label for="mail_from_name">Mail from name</label>
            <input type="text" name="mail_from_name" id="mail_from_name" value="">
        </div>
     </div>
    
</section>