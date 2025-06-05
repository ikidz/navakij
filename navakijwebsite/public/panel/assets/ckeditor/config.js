/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.skin = 'moono-lisa';
	config.width='100%';
	config.height=450;
	//config.removeButtons = 'Underline,Subscript,Superscript';
	//config.filebrowserBrowseUrl = admin_url+'filemanager/';
	config.filebrowserImageUploadUrl = admin_url+'/filemanager/upload';
	config.baseurl = base_url;

	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		'/',
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];

	config.removeButtons = 'Save,NewPage,ExportPdf,Preview,Print,Templates,Find,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Anchor,Flash,Smiley,SpecialChar,PageBreak,Styles,Font,Format,Maximize,ShowBlocks,About';
	// config.toolbarGroups = [
	// 	// { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
	// 	// { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
	// 	// { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
	// 	// { name: 'forms', groups: [ 'forms' ] },
	// 	// '/',
	// 	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
	// 	// { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
	// 	// { name: 'links', groups: [ 'links' ] },
	// 	// { name: 'insert', groups: [ 'insert' ] },
	// 	// '/',
	// 	{ name: 'styles', groups: [ 'styles' ] },
	// 	{ name: 'colors', groups: [ 'colors' ] },
	// 	// { name: 'tools', groups: [ 'tools' ] },
	// 	// { name: 'others', groups: [ 'others' ] },
	// 	// { name: 'about', groups: [ 'about' ] }
	// ];
};
