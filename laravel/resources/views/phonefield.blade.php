<input type="tel" name="phone_main" id="phone" value="{{ $value }}">
<script>
 const input = document.querySelector("#phone");
 intlTelInput(input, {customContainer:'form-control', initialCountry: 'nl', hiddenInput: 'phone',
                      utilsScript:"https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/utils.min.js"});
</script>
<style>
 .iti input {
     width: 100%;
     border: 0;
 }
 .iti input:focus {
     outline: none;
 }
</style>
