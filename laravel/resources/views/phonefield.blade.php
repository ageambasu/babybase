<input type="tel" name="phone_{{ $name }}" id="{{ $name }}" value="{{ $value }}">
<script>
 (function() {
 let input = document.querySelector("#{{ $name }}");
 intlTelInput(input, {customContainer:'form-control',
                      initialCountry: 'nl',
                      hiddenInput: '{{ $name }}',
                      customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                          return "e.g. " + selectedCountryPlaceholder;
                      },
                      utilsScript:"{{ asset('js/itiUtils.js') }}" });
 })();
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
