<meta name="csrf-token" content="{{ csrf_token() }}">
<title>print</title>
<div id="app">
<transferinvoice-component></transferinvoice-component>
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/qrcode.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>