<link rel="shortcut icon" href="<?php echo APP_LOGO; ?>">
<link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/adminlte.min.css" />
<link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/app.css" />
<link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/theme.css" />
<link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/utility.css" />
<link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/plugins/fontawesome-free/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.css" integrity="sha512-EaaldggZt4DPKMYBa143vxXQqLq5LE29DG/0OoVenoyxDrAScYrcYcHIuxYO9YNTIQMgD8c8gIUU8FQw7WpXSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="<?php echo ASSETS_URL; ?>/js/textarea.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script>
  tinymce.init({
    selector: 'textarea.editor',
    menubar: false
  });
</script>
<style>
  @media print {

    html,
    body {
      /* Hide the whole page */
      display: none;
    }
  }
</style>
