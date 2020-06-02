// ajax untuk menampilkan pilihan unit kerja
$(document).ready(function(){
    $('#generate').click(function(){
        checked = $('input[type=checkbox]:checked').length;
        firstCheckbox = $('input[type=checkbox]')[1];
        firstCheckbox.setCustomValidity('');

        if (!checked) {
            const errorMessage = 'Pilih paling tidak satu unit kerja.';
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
