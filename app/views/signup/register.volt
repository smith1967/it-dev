{{ content() }}
<h2>สมัครสมาชิก</h2><hr>
{{ form('signup/register', 'class': 'form-horizontal') }}
<fieldset>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="name">ชื่อ-นามสกุล</label>
        <div class="col-sm-3">
            {{ text_field('name', 'size': "30", 'class': "form-control") }}
        </div>
    </div> 
    <div class="form-group">
        <label class="col-sm-2 control-label" for="username">ชื่อผู้ใช้</label>
        <div class="col-sm-3">
            {{ text_field('username', 'size': "30", 'class': "form-control") }}
        </div>
    </div> 
    <div class="form-group">
        <label class="col-sm-2 control-label" for="password">รหัสผ่าน</label>
        <div class="col-sm-3">
            {{ password_field('password', 'size': "30", 'class': "form-control") }}
       </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="repeatPassword">ยืนยันรหัสผ่าน</label>
        <div class="col-sm-3">
            {{ password_field('repeatPassword', 'size': "30", 'class': "form-control") }}
       </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="username">อีเมล์</label>
        <div class="col-sm-3">
            {{ text_field('email', 'size': "30", 'class': "form-control") }}
        </div>
    </div>
    <input type="hidden" name="<?php echo $this->security->getTokenKey() ?>"
        value="<?php echo $this->security->getToken() ?>"/>
    <div class="form-actions">
        <div class="col-sm-offset-3">
            {{ submit_button('สมัครสมาชิก', 'class': 'btn btn-primary btn-large') }}
        </div>
    </div>
</fieldset>
</form>