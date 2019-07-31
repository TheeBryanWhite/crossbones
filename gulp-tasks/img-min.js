var pkg = require('../package.json');
var gulp = require('gulp');
var sass = require('gulp-sass');
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');
var pxtorem = require('postcss-pxtorem');
var mqpacker = require('css-mqpacker');
var uglify = require('gulp-uglify');
var uniqueSelectors = require('postcss-unique-selectors');
var cleanCSS = require('gulp-clean-css');

const streamToBrowserSync = require('./browser-sync').stream;

const sassOptions = {
    errLogToConsole: true,
    includePaths: [
        './node_modules/susy/sass',
        `${pkg.config.scss}/**/*.scss`
    ]
};

const autoprefixerOptions = {
    expand: true,
    flatten: true,
    browsers: ['last 2 versions']
};

const pxToRemOptions = {
    propWhiteList: [
        'font',
        'font-size',
        'line-height',
        'letter-spacing',
        'margin',
        'margin-top',
        'margin-right',
        'margin-bottom',
        'margin-left',
        'padding',
        'padding-top',
        'padding-right',
        'padding-bottom',
        'padding-left'
    ]
};

const mqpackerOptions = {
    sort: true
};

const build = function(){
    return gulp.src(`${pkg.config.scss}/**/*.scss`)
      .pipe(sass(sassOptions).on('error', function(err){
            console.error(err.message);
            this.emit('end');
        }))
      .pipe(postcss([
          autoprefixer(autoprefixerOptions),
          pxtorem(pxToRemOptions),
          mqpacker(mqpackerOptions),
          uniqueSelectors()
      ]))
      .pipe(cleanCSS({compatibility: 'ie8'}))
      .pipe(gulp.dest(pkg.config.css))
      .pipe(streamToBrowserSync());
}

module.exports = { build }
