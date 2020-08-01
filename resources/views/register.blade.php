@include('public.top')
@include('public.content')
<!-- register -->
<div class="pages section">
    <div class="container">
        <div class="pages-head">
            <h3>REGISTER</h3>
        </div>
        <div class="register">
            <div class="row">
                <form class="col s12">
                    <div class="input-field">
                        <input type="text" class="validate" id="user_name" placeholder="NAME" required>
                    </div>
                    <div class="input-field">
                        <input type="email" placeholder="EMAIL" id="user_email" class="validate" required>
                    </div>
                    <div class="input-field">
                        <input type="password" placeholder="PASSWORD" id="user_pass" class="validate" required>
                    </div>
                    <div id="register" class="btn button-default">REGISTER</div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end register -->
@include('public.footer')
<script>
    $(function(){
        $(document).on('click','#register',function(){
            var user_name=$("#user_name").val();
            var user_pass=$("#user_pass").val();
            var user_email=$("#user_email").val();
            if(user_name==''||user_pass==''||user_email==''){
                alert('请检查是否已全部填写');
                return false;
            }
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            $.ajax({
                url:'/register',
                data:{user_name:user_name,user_pass:user_pass,user_email:user_email},
                type:'post',
                dataType:'json',
                success:function(res){
                    console.log(res);
                }
            })
        })
    })
</script>