module.exports = function(grunt) {
	// Project configuration.
	grunt.initConfig({
		uglify: {
			options: {
				sourceMap: true,
			},
			prod: {
				files: {
					'public/assets/admin/js/scripts.min.js': [
						'public/assets/admin/js/bootstrap/alert.js',
						'public/assets/admin/js/bootstrap/transition.js',
						'public/assets/admin/js/bootstrap/dropdown.js',
						'public/assets/admin/js/bootstrap/collapse.js',
						'public/assets/admin/js/jquery.tablesorter.js',
						'public/assets/admin/js/jquery.tablesorter.widgets.js',
						'public/assets/admin/js/main.js'
					],
					'public/assets/js/scripts.min.js': [
						'public/assets/js/jquery.h5validate.js.',
						'public/assets/js/zebra_dialog.js',
						'public/assets/js/main.js'
					]
				}
			}
		}
	});

	// Load plugins
	grunt.loadNpmTasks('grunt-contrib-uglify');

	// Default task(s).
	grunt.registerTask('default', ['uglify']);
};