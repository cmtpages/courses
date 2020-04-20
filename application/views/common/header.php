<!DOCTYPE html>
<html lang="fr">
<head>
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
	<?php echo link_tag('asset/css/design.css'); ?>
	<script src="<?php echo base_url().'asset/js/tinymce/tinymce.min.js'; ?>"></script>
	<script src="<?php echo base_url().'asset/js/search_bar/search.js'; ?>"></script>
	<script>
	tinymce.init({
		language: 'fr_FR',
		selector: 'textarea',
		menubar:false,
		branding: false,
		plugins: 'lists',
		toolbar: 'h4 h5 numlist bullist italic bold'
    });
    </script>
    
    <script src="<?php echo base_url().'asset/js/jquery/jquery.min.js'; ?>"></script>
	
	<script src="<?php echo base_url().'asset/js/repeater/repeater.js'; ?>"></script>

	<?php echo link_tag('asset/css/select2.min.css'); ?>
    <script src="<?php echo base_url().'asset/js/chosen/select2.min.js'; ?>"></script>
	<script src="<?php echo base_url().'asset/js/chosen/select2.js'; ?>"></script>
	<title>Gestion des listes de courses</title>
</head>

<body>
	<header><h1>
		<?php echo $header_title; ?>
	</h1></header>
