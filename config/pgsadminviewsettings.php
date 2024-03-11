<?php
/***
buttons
========
By default every slug will have all buttons set to true except for delete button.
If u only need to change edit button then you can only provide that e.g: 'about_us'=>['edit'=>false]

hasGallery
==========
Not used, but may be in future

singlePost
==========
for single posts

listing
=========
list page settings 2 parameters pagination( pagination count ) && fields ( Fields to display, by default page title and manage buttons will be displayed )

filter
=========

sorting
========

 ***/
return [
	'setting' => [
		'buttons' => ['add' => false, 'edit' => true, 'delete' => false, 'status' => false],
		'hasGallery' => false,
		'singlePost' => true,
	],
    'media-uploads' => [
		'buttons' => ['add' => true, 'edit' => true, 'delete' => true, 'status' => false],
		'hasGallery' => false,
		'singlePost' => false,
	],
	'about' => [
		'buttons' => ['add' => false, 'edit' => true, 'delete' => false, 'status' => false],
		'hasGallery' => false,
		'singlePost' => true,
	],
	'news' => [
		'buttons' => ['add' => true, 'edit' => true, 'delete' => true, 'status' => true],
		'hasGallery' => false,
		'singlePost' => false,
	],
	'gallery' => [
		'buttons' => ['add' => true, 'edit' => true, 'delete' => true, 'status' => true],
		'hasGallery' => true,
		'singlePost' => false,
		'hideGalleryLang' => true,
		'hideGalleryText' => true,
		'hideGallerySource' => true,
	],

];
