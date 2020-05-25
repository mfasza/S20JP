// ajax untuk menampilkan pilihan unit kerja
$(document).ready(function(){
    document.getElementById('filter').addEventListener('change', function(){
        if($(this).val() != ''){
            var value = $(this).val();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url : "../report/selection",
                type : "post",
                data : {value: value, _token: _token},
                success : function(result){
                    $('#unit-kerja-selector').html(result);
                }
            })
        }
    });
});

// toggle untuk pilih semua
function toggle(source) {
    checkboxes = document.getElementsByName('check');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = source.checked;
    }
}
