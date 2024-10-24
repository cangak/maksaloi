/**
 * Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

/* exported initSample */

if ( CKEDITOR.env.ie && CKEDITOR.env.version < 9 )
	CKEDITOR.tools.enableHtml5Elements( document );

// The trick to keep the editor in the sample quite small
// unless user specified own height.
CKEDITOR.config.height = 150;
CKEDITOR.config.width = 'auto';

var initSample = ( function() {
	var wysiwygareaAvailable = isWysiwygareaAvailable(),
		isBBCodeBuiltIn = !!CKEDITOR.plugins.get( 'bbcode' );

	return function() {
		var editorElement = CKEDITOR.document.getById( 'editor' );

		// :(((
		if ( isBBCodeBuiltIn ) {
			editorElement.setHtml(
				'Hello world!\n\n' +
				'I\'m an instance of [url=https://ckeditor.com]CKEditor[/url].'
			);
		}

		// Depending on the wysiwygare plugin availability initialize classic or inline editor.
		if ( wysiwygareaAvailable ) {
			CKEDITOR.replace( 'editor' );
		} else {
			editorElement.setAttribute( 'contenteditable', 'true' );
			CKEDITOR.inline( 'editor' );

			// TODO we can consider displaying some info box that
			// without wysiwygarea the classic editor may not work.
		}
	};

	function isWysiwygareaAvailable() {
		// If in development mode, then the wysiwygarea must be available.
		// Split REV into two strings so builder does not replace it :D.
		if ( CKEDITOR.revision == ( '%RE' + 'V%' ) ) {
			return true;
		}

		return !!CKEDITOR.plugins.get( 'wysiwygarea' );
	}
	function cek_data() {
		var no_services = $('[name="no_services[]"]').val(); // Mendapatkan nilai yang dipilih sebagai array
		$.ajax({
			type: 'POST',
			data: {
				"cek_data": 1,
				"no_services": no_services
			},
			url: '<?= site_url('bill/view_data') ?>',
			cache: false,
			beforeSend: function() {
				$('[name="no_services[]"]').attr('disabled', true);
				$('.loading').html(`
					<div class="container">
						<div class="text-center">
							<div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
								<span class="sr-only">Loading...</span>
							</div>
						</div>
					</div>`);
			},
			success: function(data) {
				$('[name="no_services[]"]').attr('disabled', false);
				$('.loading').html('');
				console.log("Data diterima:", data); // Log data yang diterima
				$('.view_data').html(data);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log("Kesalahan AJAX:", textStatus, errorThrown);
			}
		});
		return false;
	}
	
} )();

