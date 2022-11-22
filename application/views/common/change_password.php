<!-- Modal -->
<div class="modal fade" id="change-pwd-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title">Change Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <form action="<?php echo base_url();?>common/form_action" method="post" class="parsley-examples edit_form">
                    
                    <input type="hidden" id="redirect" name="redirect" value="<?php echo $this->uri->segment(1);?>">
                    <input type="hidden" id="user_id" name="user_id" value="<?php echo $this->session->userdata('user_id');?>">
                    
                        <div class="form-group">
                            <label for="new_passsword">New Password</label>
                            <input type="password" class="form-control" name="new_passsword" id="new_passsword" required>
                                
                        </div>

                        <div class="form-group">
                            <label for="c_new_passsword">Confirm Password</label>
                            <input type="password" class="form-control" name="c_new_passsword" id="c_new_passsword" required data-parsley-equalto="#new_passsword">
                                
                        </div>
                    

                    <div class="text-right">
                        
                        <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script>

//$(document).ready(function(){

// updating the view with notifications using ajax

// function load_unseen_notification(view = '')

// {

//  $.ajax({

//   url:"<?php //echo base_url();?>notification/fetch",
//   method:"POST",
//   data:{view:view},
//   dataType:"json",
//   success:function(data)

//   {

//         console.log(data);

//        $('.list-group').html(data.notification);

//        if(data.unseen_notification > 0)
//        {
//         $('.num').html(data.unseen_notification);
//        }

//   }

//  });

// }

//load_unseen_notification();

// load new notifications

// $(document).on('click', '.notif', function(){
  
//     $('.num').html('');

//  load_unseen_notification('yes');

// });

// setInterval(function(){

//  load_unseen_notification();;

// }, 10000);

// });

</script>