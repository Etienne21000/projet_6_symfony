const gulp = require('gulp');
const sass = require('gulp-sass');
const watch = require('gulp-watch');

sass.compiler = require('node-sass');

gulp.task('sass', function() {
    return gulp.src('public/scss/main.scss')
        .pipe(sass({outputStyle: 'compressed'}))
        .pipe(rename('main.min.css'))
        .pipe(gulp.dest('public/main-css'));
});
