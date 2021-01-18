<script>
// auth data
let auth = '';
<?php if(Session::get('auth')) echo 'auth = ' . Session::get('auth'); ?>;

// timezone offset
const timezoneOffset = -(new Date().getTimezoneOffset());
</script>
