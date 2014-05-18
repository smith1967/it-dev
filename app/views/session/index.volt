
{{ content() }}
       <div class="login-or-signup">
            <div class="row">
                <div class="col-sm-3 col-md-4"></div>
                <div class="col-sm-5 col-md-5">
                    <div class="panel panel-default">
                        <div class="panel-heading"> 
                            <div class="clearfix">
                                <div class="pull-left panel-heading"><h4>ลงชื่อเข้าระบบ</h4></div>
                                <div class="pull-right panel-heading"> 
                                {{ link_to('session/register', '<h4><span class="glyphicon glyphicon-plus"></span> ลงทะเบียน</h4>' ) }}
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            {{ form('session/start', 'method': 'post') }}
{#                            <form role="form" action="/phalcon/auth/session" method="post">#}
                                <div class="form-group">
                                    <label for="Email">อีเมล์ (Email)</label>
                                    {{ text_field('email', 'size': "30", 'class': "form-control input-xlarge") }}
{#                                    <input type="email" class="form-control" id="Email" placeholder="Enter email" name="email">#}
                                </div>
                                <div class="form-group">
                                    <div class="clearfix">
                                        <div class="pull-left"><label for="Password">รหัสผ่าน (Password)</label></div>
                                    </div>
                       {{ password_field('password', 'size': "30", 'class': "form-control input-xlarge") }}
     
{#                                    <input type="password" class="form-control" id="Password" placeholder="Password" name="password">#}
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg btn-block">เข้าระบบ</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>


