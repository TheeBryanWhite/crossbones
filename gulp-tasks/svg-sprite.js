'use strict';

var pkg      = require('../package.json'),
gulp         = require('gulp'),
svgSprite    = require('gulp-svg-sprite'),
plumber      = require('gulp-plumber'),
baseDir      = 'wp-content/themes/cdi4001/assets/icons/source/',   // <-- Set to your SVG base directory
svgGlob      = '**/*.svg',       // <-- Glob to match your SVG files
outDir       = 'wp-content/themes/cdi4001/assets/icons/',     // <-- Main output directory
config       = {
    "dest": "dist",
    "shape": {
        "dimension": {
            "maxWidth": 64,
            "maxHeight": 64
        },
        "spacing": {
            "padding": 10
        }
    },
    "svg": {
        "xmlDeclaration": false
    },
    "mode": {
        "symbol": {
            "sprite": "sprite.symbol.svg.php",
            "example": true
        }
    }
};

const build = function() {
    return gulp.src(svgGlob, {cwd: baseDir})
        .pipe(plumber())
        .pipe(svgSprite(config))
        .on('error', function(error)
            { console.log(error); }
        )
        .pipe(gulp.dest(outDir))
}

module.exports = { build };
