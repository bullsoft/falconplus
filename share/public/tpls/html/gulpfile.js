var gulp = require('gulp'),
	autoprefixer = require('gulp-autoprefixer'),
	sass = require('gulp-sass'),
    browserSync = require('browser-sync').create();


 
gulp.task('sass', function() {
  return gulp.src('scss/stylesheet.scss')
    .pipe(sass({outputStyle: 'compact'}))
    .pipe(autoprefixer('> 1%', 'last 2 versions', 'ie 9', 'Opera 12.1'))
    .pipe(gulp.dest('style'))
});

gulp.task('html', function() {
	return gulp.src('*.html')
});


gulp.task('browser-sync', function() {
    browserSync.init(["style/*.css", "script/*.js", "*.html"],{
        server: {
            baseDir: "./"
        }
    });
});

gulp.task('watch', function() {
	gulp.watch('scss/*.scss', ['sass'])
	gulp.watch('*.html', ['html'])
});

gulp.task('html', ['sass', 'watch', 'html', 'browser-sync']);