var del = require('del');

var
    concat = require('gulp-concat'),
    gulp = require('gulp'),
    sass = require('gulp-sass'),
    uglify = require('gulp-uglify'),
    yarn = require('gulp-yarn')
    ;

var
    jsSources = ['./src/assets/scripts/*.js'],
    jsSourcesDirTmp = "./tmp/scripts",
    jsSourcesFilesTmp = [
        "./tmp/scripts/jquery.js",
        "./tmp/scripts/bootstrap.js",
        "./tmp/scripts/bootstrap-multiselect.js",
        "./tmp/scripts/scripts.js"
    ],
    jsSourcesTmp = "./tmp/scripts/*.js",
    pluginjQueryJsFilepath = "./node_modules/jquery/dist/jquery.js",
    pluginBtJsFilepath = "./node_modules/bootstrap/dist/js/bootstrap.js",
    pluginAppJsFilepath = "./src/assets/scripts/*.js",
    pluginBtCssFilepath = "./node_modules/bootstrap/dist/css/bootstrap.css",
    pluginBtMultiselectJsFilepath = "./node_modules/bootstrap-multiselect/dist/js/bootstrap-multiselect.js",
    pluginBtMultiselectCssFilepath = "./node_modules/bootstrap-multiselect/dist/css/bootstrap-multiselect.css",
    cssSourcesDirTmp = "./tmp/styles",
    cssSourcesTmp = "./tmp/styles/*.css",
    sassSources = [
        './src/assets/styles/*.scss'
    ],
    sassSourcesCommon = [
        './node_modules/bootstrap/scss/bootstrap.scss'
    ],
    htmlSources = ['**/*.html'],
    outputDir = './../expressive/public/assets',
    tmpDirStyles = "./tmp",
    cssBtFontsDir = './node_modules/bootstrap/dist/fonts',
    cssBtFontsDestDir = './../expressive/public/assets/fonts'
    ;

gulp.task('css', function() {
    gulp.src('./src/assets/styles/styles.scss')
        .pipe(sass({
            style: 'expanded',
            outputStyle: 'compressed',
            sourceComments: false,
            errLogToConsole: true
        }))
        .pipe(gulp.dest('./tmp/styles/'))
});

gulp.task('css_copy_tmp', function() {
    gulp.src(cssSourcesTmp)
        .pipe(concat('styles.min.css'))
        .pipe(gulp.dest(outputDir + "/styles"))
});

// Copy Bootstrap styles to TMP
gulp.task('css_bt_prep', function() {
    // copy js to TMP
    gulp.src(pluginBtCssFilepath)
        .pipe(gulp.dest(cssSourcesDirTmp))
});

// Copy Bootstrap-multiselect styles to TMP
gulp.task('css_bt_multiselect_prep', function() {
    // copy js to TMP
    gulp.src(pluginBtMultiselectCssFilepath)
        .pipe(gulp.dest(cssSourcesDirTmp))
});

// Copy jQuery scripts to TMP
gulp.task('js_jquery_prep', function() {
    // copy js to TMP
    gulp.src(pluginjQueryJsFilepath)
        .pipe(gulp.dest(jsSourcesDirTmp))
});

// Copy Bootstrap scripts to TMP
gulp.task('js_bt_prep', function() {
    // copy js to TMP
    gulp.src(pluginBtJsFilepath)
        .pipe(gulp.dest(jsSourcesDirTmp))
});

// Copy Bootstrap-multiselect scripts to TMP
gulp.task('js_bt_multiselect_prep', function() {
    // copy js to TMP
    gulp.src(pluginBtMultiselectJsFilepath)
        .pipe(gulp.dest(jsSourcesDirTmp))
});

// Copy Bootstrap styles to TMP
gulp.task('css_bt_prep', function() {
    // copy js to TMP
    gulp.src(pluginBtCssFilepath)
        .pipe(gulp.dest(cssSourcesDirTmp))
});

gulp.task('js_app', function() {
    gulp.src(jsSources)
        .pipe(gulp.dest(jsSourcesDirTmp))
});
gulp.task('js_tmp', function() {
    gulp.src(jsSourcesFilesTmp)
       .pipe(uglify())
        .pipe(concat('scripts.min.js'))
        .pipe(gulp.dest(outputDir + "/scripts"))
});


// Update packages
gulp.task('yarn', function() {
    return gulp.src(['./package.json'])
        .pipe(yarn());
});

gulp.task('watch_files', function() {
    gulp.watch(sassSources, [
        'css_bt_prep',
        'css_bt_multiselect_prep',
        'css',
        'css_copy_tmp',
        'js_tmp'
    ]);
    gulp.watch(jsSources, [
        'js_jquery_prep',
        'js_bt_prep',
        'js_bt_multiselect_prep',
        'js_app',
        'js_tmp'
    ]);
});

gulp.task('clean_tmp', function(){
    return del.sync(['./tmp'], {force:true});
});

gulp.task('css_bt_copy_fonts', function() {
    gulp.src(cssBtFontsDir + '/*')
        .pipe(gulp.dest(cssBtFontsDestDir))
});

gulp.task('default', [
    'css_bt_prep',
    'css_bt_multiselect_prep',
    'css',
    'css_copy_tmp',
    'js_jquery_prep',
    'js_bt_prep',
    'js_bt_multiselect_prep',
    'js_app',
    'js_tmp'
    // 'watch'
]);
gulp.task('watch',[

]);