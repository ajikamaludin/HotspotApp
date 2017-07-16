$('.button-collapse').sideNav({
   menuWidth: 300, // Default is 300
   edge: 'right', // Choose the horizontal origin
   closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
   draggable: true // Choose whether you can drag to open on touch screens
});
$(document).on('click', '#edit_profile', function() {
    $('.validate').removeAttr('disabled');
    $('.materialize-textarea').removeAttr('disabled');
});
$(document).ready(function() {
   $('select').material_select();
}); 
$('#rsync').click(function(){
	$('#loader').fadeIn();
	$('#data-table').fadeOut();
});

$(document).on('click','.hapus_post',function(){
  var id_pengguna = $(this).attr('data-id');
  var id_post = $(this).attr('data-postid');
  $.ajax({
  method: "POST",
  url: "function/ajax_hapus_index.php",
  data: { id_pengguna : id_pengguna, id_post : id_post, aksi: "hapus" },
  success: function(data){
    $("#data_"+id_post).remove();
    console.log(data);
    	}
	})
});