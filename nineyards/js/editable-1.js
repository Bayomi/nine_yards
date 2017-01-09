$(document).ready(function() {
     $('.edit').editable('save.php', {
         indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         cancel    : 'Cancel',
         type : 'textarea',
         submit : 'Confirm'
     });
 });