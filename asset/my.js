//Hapus Data
$(document).on('click','.hapusUser',function(){
  var user = $(this).attr('data-id');
  $.ajax({
  method: "POST",
  url: "function/ajax_functions.php",
  data: { id : user, aksi: "hapusUser" },
  success: function(data){
    $("#data_"+user).remove();
    console.log(data);
    }
  })
});