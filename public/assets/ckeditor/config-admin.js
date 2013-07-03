/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	config.toolbar = [
		{ name: 'styles', items: ['Format'] },
		{ name: 'basicstyles', items: ['Bold', 'Italic', 'Strike', 'Underline'] },
		{ name: 'lists', items: ['NumberedList', 'BulletedList'] },
		{ name: 'insert', items: ['Image', 'Link', 'Unlink'] },
		{ name: 'source', items: ['Source'] }
	];

	config.format_tags = 'p;h3;h4;pre';
};