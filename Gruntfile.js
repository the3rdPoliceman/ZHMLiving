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
                dest: '/www/test.zhm-living.ch/',
                exclusions: ['build/**/.DS_Store', 'build/**/Thumbs.db', 'dist/tmp']
            }
        },
        copy: {
            main: {
                files: [{
                    expand: true,
                    cwd: 'contents/',
                    src: ['**'],
                    dest: 'build/'
                }]
            }
        }
    });
    grunt.loadNpmTasks('grunt-ftp-deploy');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-copy');

    grunt.registerTask('default', ['clean:build', 'copy:main:files']);
    grunt.registerTask('deploy', ['clean:build', 'copy:main:files', 'ftp-deploy']);
};