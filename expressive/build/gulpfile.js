var concat      = require('gulp-concat');
var gulp        = require('gulp');
var sass        = require('gulp-sass');
var uglify        = require('gulp-uglify');
var cleanCSS = require('gulp-clean-css');

gulp.task('bt_sass', function() {
    return gulp.src([
        'node_modules/bootstrap/scss/bootstrap.scss',
        'src/scss/*.scss'
    ])
    .pipe(sass())
    .pipe(gulp.dest("tmp/css"));
});

gulp.task('fa_sass', function() {
    return gulp.src([
        'node_modules/components-font-awesome/scss/fontawesome.scss',
        'node_modules/components-font-awesome/scss/fa-solid.scss',
        'node_modules/components-font-awesome/scss/fa-regular.scss'
    ])
    .pipe(sass())
    .pipe(gulp.dest("tmp/css"));
});

gulp.task('css_copy', function() {
    // copy js to TMP
    gulp.src('tmp/css/*.css')
        .pipe(concat('styles.min.css'))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(gulp.dest('../public/assets/styles/'))
});

gulp.task('fa_fonts_copy', function() {
    // copy js to TMP
    gulp.src('node_modules/components-font-awesome/webfonts/*')
        .pipe(gulp.dest('../public/assets/webfonts/'))
});

gulp.task('bt_js', function() {
    return gulp.src([
        'node_modules/jquery/dist/jquery.js',
        'node_modules/bootstrap/dist/js/bootstrap.min.js'
    ])
    .pipe(uglify())
    .pipe(concat('scripts.min.js'))
    .pipe(gulp.dest("tmp/js"));
});

gulp.task('js_copy', function() {
    gulp.src('tmp/js/*.min.js')
        .pipe(gulp.dest('../public/assets/scripts/'))
});

gulp.task('default', ['bt_sass','fa_sass','fa_fonts_copy','css_copy','bt_js','js_copy']);