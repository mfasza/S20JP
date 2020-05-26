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

    $('#generate').click(function(){
        checked = $('input[type=checkbox]:checked').length;
        firstCheckbox = $('input[type=checkbox]')[1];
        firstCheckbox.setCustomValidity('');

        if (!checked) {
            const errorMessage = 'At least one checkbox must be selected.';
            firstCheckbox.setCustomValidity(errorMessage);
        }
    })
});

// toggle untuk pilih semua
function toggle(source) {
    checkboxes = document.getElementsByName('check[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = source.checked;
    }
}
