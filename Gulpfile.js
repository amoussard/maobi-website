const gulp = require('gulp');
const imagemin = require('gulp-imagemin');
const pngquant = require('imagemin-pngquant');
const cleanCSS = require('gulp-clean-css');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');

gulp.task('image-min', () => {
    return gulp.src([
            'app/Resources/images/**/*',
        ])
        .pipe(imagemin({
            progressive: true,
            optimizationLevel: 3,
            svgoPlugins: [
                {removeViewBox: false},
                {cleanupIDs: false}
            ],
            use: [pngquant()]
        }))
        .pipe(gulp.dest('web/images'));
});

gulp.task('css', () => {
    return gulp.src([
            'app/Resources/styles/bootstrap.css',
            'app/Resources/styles/common.css',
            'app/Resources/styles/style.css',
            'app/Resources/styles/font-awesome.min.css',
            'app/Resources/styles/icon.css',
            'app/Resources/styles/carousel.css',
            'app/Resources/styles/moabi-color-green.css'
        ])
        // .pipe(cleanCSS({debug: true}, function(details) {
        //     console.log(details.name + ': ' + details.stats.originalSize);
        //     console.log(details.name + ': ' + details.stats.minifiedSize);
        // }))
        .pipe(concat('app.min.css'))
        .pipe(gulp.dest('web/css'));
});

gulp.task('fonts', () => {
    return gulp.src([
            'app/Resources/fonts/*'
        ])
        .pipe(gulp.dest('web/fonts'));
});

gulp.task('js', () => {
    return gulp.src([
            'app/Resources/scripts/jquery-2.2.3.min.js',
            'app/Resources/scripts/bootstrap.js',
            'app/Resources/scripts/isotope.pkgd.min.js',
            'app/Resources/scripts/swiper.js',
            'app/Resources/scripts/dcalendar.picker.js',
            'app/Resources/scripts/carousel.js',
            'app/Resources/scripts/video.js',
            'app/Resources/scripts/chart.min.js',
            'app/Resources/scripts/horizontal-timeline.js',
            'app/Resources/scripts/modernizr.js',
            'app/Resources/scripts/parallax.js',
            'app/Resources/scripts/photoswipe.js',
            'app/Resources/scripts/jquery.multiscroll.js',
            'app/Resources/scripts/grid.js',
            'app/Resources/scripts/jquery.countTo.js',
            'app/Resources/scripts/jquery.appear.js',
            'app/Resources/scripts/jquery.time-to.js',
            'app/Resources/scripts/slick.js',
            'app/Resources/scripts/jrespond.js',
            'app/Resources/scripts/template-functions.js',
            // 'app/Resources/scripts/color-style.js',
            'app/Resources/scripts/banner.js'
        ])
        .pipe(concat('app.min.js'))
        // .pipe(uglify())
        .pipe(gulp.dest('web/js'));
});

gulp.task('image', ['image-min']);
gulp.task('default', ['css', 'fonts', 'js']);
