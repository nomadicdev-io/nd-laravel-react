{{ HTML::style('assets/admin/css/main.min.css') }}
{{ HTML::style('assets/admin/lib/jquery-ui/jquery-ui.min.css') }}
{{ HTML::style('assets/admin/lib/fontawesome-free/css/all.min.css') }}
{{ HTML::style('assets/admin/lib/typicons.font/typicons.css') }}

{{ HTML::style('assets/admin/lib/ionicons/css/ionicons.min.css') }}
<?php /*
{{ HTML::style('assets/admin/lib/flag-icon-css/css/flag-icon.min.css') }}
 */?>
{{ HTML::style('assets/admin/lib/fancybox/jquery.fancybox.min.css') }}
{{ HTML::style('assets/admin/lib/select2/css/select2.min.css') }}
{{ HTML::style('assets/admin/css/custom_admin.css') }}

<style>

	/*.uploadPreview.filePreview.img_uploaded {
		display: none;
	}*/

	/*.uploadPreview.img_uploaded {
		display: none;
	}*/
	.col-form-label em {
		color: red;
		font-style: normal;
	}

	html[dir="rtl"] .col-form-label em {
		margin-right: 2.5px;
	}

	html[dir="ltr"] .col-form-label em {
		margin-left: 2.5px;
	}

	.validation-messages {
		margin-bottom: 0;
	}

	.az-sidebar-body .nav-sub .nav-link.active,
	.az-sidebar-body .nav-sub .nav-link.active i {
		color: #e1b154 !important;
	}

	.change-status.az-toggle {
		width: 70px;
	}

	.change-status.az-toggle.on span {
	    left: 47px;
	}

	.change-status.az-toggle span::before, .change-status.az-toggle span::after {
		font-size:  7.5px;
		top: 5px;
	}

	.change-status.az-toggle span::after {
		content: '{{ lang('inactive') }}';
		right:  -40px;
	}

	.change-status.az-toggle span::before {
		content: '{{ lang('active') }}';
		left: -35px;
	}

	.select2-container--default.select2-container--open {
		z-index: 99999;
	}

	.lds-ring {
		display: inline-block;
		position: relative;
		width: 18px;
		height: 18px;
	}
	.lds-ring div {
		box-sizing: border-box;
		display: block;
		position: absolute;
		width: 18px;
		height: 18px;
		margin: 8px;
		border: 2px solid #198cde;
		border-radius: 50%;
		animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
		border-color: #198cde transparent transparent transparent;
	}
	.lds-ring div:nth-child(1) {
		animation-delay: -0.45s;
	}
	.lds-ring div:nth-child(2) {
		animation-delay: -0.3s;
	}
	.lds-ring div:nth-child(3) {
		animation-delay: -0.15s;
	}
	@keyframes lds-ring {
		0% {
			transform: rotate(0deg);
		}
		100% {
			transform: rotate(360deg);
		}
	}

	.lds-ring-wrapper-select {
		display: none;
		position: absolute;
	    right: 60px;
	    top: 50%;
	    z-index: 9999999;
	}

	.lds-ring-wrapper-select.show {
		display: block;
	}

	.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
	    top: 2px;
        color: red;
	}

	.select2-container--default .select2-selection--multiple .select2-selection__choice {
		padding:  0 20px;
		color:  #333;
	}

	.sub-nav-item.show ul.submenu-2.nav-sub-2.list-hidden {
		padding: 0px 0px 0px 5px;
	}

	.sub-nav-item.show ul.submenu-2.nav-sub-2.list-hidden li a {
		font-size: small;
	}
</style>