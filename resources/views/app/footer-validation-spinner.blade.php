<script>
(function() {
  'use strict';
  window.addEventListener('load', function() {
    var formsCreate = document.getElementsByClassName('validation-create');
    var formsUpdate = document.getElementsByClassName('validation-update');
    var formsDelete = document.getElementsByClassName('validation-delete');
    const spinnerCreate = document.getElementById('spinner-create');
    const spinnerUpdate = document.getElementById('spinner-update');
    const spinnerDelete = document.getElementById('spinner-delete');
    var validationCreate = Array.prototype.filter.call(formsCreate, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        if (form.checkValidity()) {
            spinnerCreate.classList.toggle('show-spin');
        }
        form.classList.add('was-validated');
      }, false);
    });
    var validationUpdate = Array.prototype.filter.call(formsUpdate, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        if (form.checkValidity()) {
            spinnerUpdate.classList.toggle('show-spin');
        }
        form.classList.add('was-validated');
      }, false);
    });
    var validationDelete = Array.prototype.filter.call(formsDelete, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        if (form.checkValidity()) {
            spinnerDelete.classList.toggle('show-spin');
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>