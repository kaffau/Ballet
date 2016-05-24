'use strict';
module.exports = function (grunt) {
    grunt.initConfig({
        meta: {
            version: '1.0.0'
        },
        shell: {
            clearCache: {
                options: {
                    stdout: true
                },
                command: 'php app/console cache:clear'
            },
            asseticDump: {
                options: {
                    stdout: true
                },
                command: 'php app/console assetic:dump web'
            },
            assetsInstall: {
                options: {
                    stdout: true
                },
                command: 'php app/console assets:install web'
            }
        },

        /********** JS **********/
        concat: {
            options: {
                banner: '<%= banner %>',
                stripBanners: true
            },
            js: {
                src: [
                    'web/bundles/balletwaytoc/assets/js/jquery-1.11.1.js',
                    'web/bundles/balletwaytoc/assets/js/jquery.ui.js',
                    'web/bundles/balletwaytoc/assets/js/jquery.mousewheel.min.js',
                    'web/bundles/balletwaytoc/assets/js/bootstrap.min.js',
                    'web/bundles/balletwaytoc/assets/js/masonry.min.js',
                    'web/bundles/balletwaytoc/assets/js/scroll-frame-head.js',
                    'web/bundles/balletwaytoc/assets/js/scroll-frame.js',
                    'web/bundles/balletwaytoc/assets/js/imagesLoaded.js',
                    'web/bundles/balletwaytoc/assets/js/infinite-scroll.js',
                    'web/bundles/balletwaytoc/assets/js/dropzone.js',
                    'web/bundles/balletwaytoc/assets/js/jquery.lazyload.min.js',
                    'web/bundles/balletwaytoc/assets/js/app.js'
                ],
                dest: 'web/bundles/balletwaytoc/assets/js/main.js'
            }
        },

        cssmin: {
            combine: {
                files: {
                    'web/bundles/balletwaytoc/assets/css/main.min.css': [
                        'src/Ballet/WaytocBundle/Resources/public/assets/css/bootstrap.min.css',
                        'src/Ballet/WaytocBundle/Resources/public/assets/css/output.css'
                    ]
                }
            }
        },
        compass: {
            app: {
                options: {
                    sassDir: 'src/Ballet/WaytocBundle/Resources/public/assets/sass',
                    cssDir: 'src/Ballet/WaytocBundle/Resources/public/assets/css',
                    imagesDir: 'src/Ballet/WaytocBundle/Resources/public/assets/images',
                    fontsDir: 'src/Ballet/WaytocBundle/Resources/public/assets/fonts',
                    httpPath: "/",
                    relativeAssets: true,
                    boring: true,
                    debugInfo: true,
                    outputStyle: 'compressed',
                    raw: 'preferred_syntax = :sass\n'

                }
            }
        },

        uglify: {
            options: {
                banner: '<%= banner %>'
            },
            dist: {
                files: {
                    'web/bundles/balletwaytoc/assets/js/main.min.js': ['web/bundles/balletwaytoc/assets/js/main.js']
                }
            }
        },

        jshint: {
            options: {
                node: true,
                curly: true,
                eqeqeq: true,
                immed: true,
                latedef: true,
                newcap: true,
                noarg: true,
                sub: true,
                undef: true,
                unused: true,
                boss: true,
                eqnull: true,
                browser: true,
                globals: {}
            },
            gruntfile: {
                src: 'Gruntfile.js'
            }
        },

        watch: {
            options: {
                livereload: true
            },
            css: {
                files: ['src/Ballet/WaytocBundle/Resources/public/assets/sass/waytoc/*.scss'],
                tasks: 'default'
            },
            scripts: {
                files: ['src/Ballet/WaytocBundle/Resources/public/assets/js/*.js'],
                tasks: 'default'
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-shell');

    grunt.registerTask('default', ['shell:assetsInstall', 'jshint', 'concat:js', 'uglify' , 'compass', 'cssmin' ]);
    grunt.registerTask('production', ['jshint'/*, 'removelogging'*/, 'concat', 'uglify', 'compass']);
};