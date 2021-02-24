<input type="tel" name="phone_main" id="phone" value="{{ $value }}">
<script>
 const input = document.querySelector("#phone");
 intlTelInput(input, {customContainer:'form-control', initialCountry: 'nl', hiddenInput: 'phone',
                      utilsScript:"{{ asset('js/itiUtils.js') }}" });
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
