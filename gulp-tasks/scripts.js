var pkg = require('../package.json');
var gulp = require('gulp');
var eslint = require('gulp-eslint');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');

const build = function() {
    return gulp.src(`${pkg.config.scripts}/source/**/*.js`)
        .pipe(concat('main.js'))
        .pipe(uglify())
        .pipe(gulp.dest(`${pkg.config.scripts}/site/`))
        .on('error', function(err) {
            console.error('Error in build task', err.toString());
        });
}

const lint = function(){
    return gulp.src(`${pkg.config.scripts}/source/**/*.js`)
        .pipe(eslint())
        .pipe(eslint.format())
        .pipe(eslint.failAfterError());
}
module.exports = { lint, build }