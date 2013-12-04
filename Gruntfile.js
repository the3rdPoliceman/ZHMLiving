module.exports = function(grunt) {
    grunt.initConfig({
        clean: {
            build: [
                'build'
            ]
        },
        jshint: {
            work: [
                'work/js/*.js',
                'Gruntfile.js'
            ]
        },
        watch: {
            js: {
                files: [
                    'work/js/**/*.js'
                ],
                tasks: [
                    'jshint:work',
                    'browserify2'
                ]
            },
            sass: {
                files: [
                    'work/sass/**/*.scss'
                ],
                tasks: [
                    'compass:dev'
                ]
            }
        },
        uglify: {
            production: {
                files: {
                    'build/js/app.min.ec1a70d1.cache.js': 'build/js/app.min.ec1a70d1.cache.js'
                }
            }
        },
        cssmin: {
            production: {
                expand: true,
                cwd: 'build/css',
                src: ['*.css'],
                dest: 'build/css'
            }
        },
        'ftp-deploy': {
            build: {
                auth: {
                    host: 'zhm-living.ch',
                    port: 21,
                    authKey: 'key1'
                },
                src: 'build',
                dest: '/',
                exclusions: ['build/**/.DS_Store', 'build/**/Thumbs.db', 'dist/tmp']
            }
        }
    });
    grunt.loadNpmTasks('grunt-ftp-deploy');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
};