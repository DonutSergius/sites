const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const concat = require('gulp-concat');

gulp.task('style-scss', function() {
  return gulp.src('./styles/scss/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(concat('styles.css'))
    .pipe(gulp.dest('./styles/css/'));
});

gulp.task('watch-scss', function() {
  gulp.watch('./styles/scss/*.scss', gulp.series('style-scss'));
});