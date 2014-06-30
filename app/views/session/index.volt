
{{ content() }}

<div class="login-form">
    <div class="row">
        <div class="col-sm-3 col-md-4"></div>
        <div class="col-sm-5 col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading"> 
                    <div class="clearfix"></div>
                    <div class="panel-heading"><h4>ลงชื่อเข้าระบบ
                        <div class="pull-right"> 
                            {{ link_to('signup/register', '<span class="glyphicon glyphicon-plus"></span> ลงทะเบียน' ) }}
                        </div>
                        </h4>
                    </div>
                    </div>
                        <div class="clearfix"> </div>    
                    <div class="panel-body">
                        {{ form('session/login', 'method': 'post') }}
                        <div class="form-group">
                            <label for="Username">ชื่อผู้ใช้ (Username)</label>
                            {{ text_field('username', 'size': "30", 'class': "form-control input-xlarge") }}
                            {#                                    <input type="email" class="form-control" id="Email" placeholder="Enter email" name="email">#}
                        </div>
                        <div class="form-group">
                            <div class="clearfix">
                                <div class="pull-left"><label for="Password">รหัสผ่าน (Password)</label></div>
                            </div>
                            {{ password_field('password', 'size': "30", 'class': "form-control input-xlarge") }}
                            <input type="hidden" name="<?php echo $this->security->getTokenKey() ?>"
                                   value="<?php echo $this->security->getToken() ?>"/>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block">เข้าระบบ</button>
                        </form>
                    </div>             
            </div>
        </div>

    </div>
</div>
