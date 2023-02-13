const {src, dest, watch, parallel} = require('gulp');
const sass = require('gulp-sass')(require('sass'));
sass.compiler = require('node-sass');


const autoprefixer = require('gulp-autoprefixer');
const svgSprite = require('gulp-svg-sprite');


const config = {
    shape: {
        dimension: {
            maxWidth: 32,
            maxHeight: 32,
            precision: 2,
            attributes: false,
        }
    },
    mode: {
        symbol: {
            dest: './',
            sprite: 'sprite.svg'
        }
    },
    dest: './'
};


function css() {
    var common = src('scss/common*.scss')
            .pipe(sass())
            .pipe(autoprefixer())
            .pipe(dest('application/views/css'))
            .pipe(dest('dashboard/views/css'));
    var frontend = src('scss/frontend*.scss')
            .pipe(sass())
            .pipe(autoprefixer())
            .pipe(dest('application/views/css'));
    var dashboard = src('scss/dashboard*.scss')
            .pipe(sass())
            .pipe(autoprefixer())
            .pipe(dest('dashboard/views/css'));
    return (common, frontend, dashboard);
}

function svg() {
    var frontend = src('application/views/images/sprite/*.svg')
            .pipe(svgSprite(config))
            .pipe(dest('application/views/images'));
    var dashboard = src('dashboard/views/images/sprite/*.svg')
            .pipe(svgSprite(config))
            .pipe(dest('dashboard/views/images'));
    return merge(frontend, dashboard);
}

function watchFiles() {
    watch(['scss'], parallel(css));
}

exports.default = parallel(css, svg);
exports.watch = watchFiles;
