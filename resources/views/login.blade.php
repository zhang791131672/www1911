@include('public.top')
@include('public.content')
<!-- login -->
<div class="pages section">
    <div class="container">
        <div class="pages-head">
            <h3>LOGIN</h3>
        </div>
        <div class="login">
            <div class="row">
                <form class="col s12">
                    <div class="input-field">
                        <input type="text" name="user_name" class="validate" placeholder="USERNAME" required>
                    </div>
                    <div class="input-field">
                        <input type="password" name="user_pass"  class="validate" placeholder="PASSWORD" required>
                    </div>
                    <a href=""><h6>Forgot Password ?</h6></a>
                    <a href="" id="login" class="btn button-default">LOGIN</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end login -->
@include('public.footer')
<script>
    $(document).ready(function () {
        $(document).on('click','#login', function () {
             var user_name=$("input[name='user_name']").val();
             var user_pass=$("input[name='user_pass']").val();
//             if(user_name==''||user_pass==''){
//                alert('用户名或者密码不能为空');
//                return false;
//             }
            //调用自己需要加,调用api不需要
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            $.ajax({
               url:'/login',
               data:{user_name:user_name,user_pass:user_pass},
               type:"post",
               dataType:'json',
               success:function(res){
                    if(res.errno==200){
                        alert(res.data);
                    }else{
                        alert('登录失败');
                    }
               }
            });
            return false;
        })
    })
</script>
