
/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');
const feather = require('feather-icons');
// As an Es6 module (if using webpack or Rollup).

feather.replace();
// import ClassicEditor = require('@ckeditor/ckeditor5-build-classic');
window.ClassicEditor = require('@ckeditor/ckeditor5-build-classic');
// import select2 from 'select2';
window.select2 = require('select2');

window.slugify = function (text) {
  return text.toString().toLowerCase().replace(/\s+/g, '-') // Replace spaces with -
  .replace(/[^\w\-]+/g, '') // Remove all non-word chars
  .replace(/\-\-+/g, '-') // Replace multiple - with single -
  .replace(/^-+/, '') // Trim - from start of text
  .replace(/-+$/, ''); // Trim - from end of text
};