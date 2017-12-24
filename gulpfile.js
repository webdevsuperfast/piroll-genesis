var gulp = require('gulp'),
    sass = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    cleancss = require('gulp-clean-css'),
    jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    cache = require('gulp-cache'),
    vinylpaths = require('vinyl-paths'),
    cmq = require('gulp-combine-mq'),
    merge = require('merge-stream'),
    foreach = require('gulp-flatmap'),
    changed = require('gulp-changed'),
    runSequence = require('run-sequence'),
    wait = require('gulp-wait'),
    del = require('del');

// CSS
gulp.task('styles', function(){
    var cssStream = gulp.src('node_modules/normalize.css/normalize.css')
        .pipe(wait(400))
        .pipe(concat('normalize.css'))

    var sassStream = gulp.src('assets/scss/style.scss')
        .pipe(wait(400))
        .pipe(sass.sync().on('error', sass.logError))
        .pipe(concat('app.scss'))
    
    var mergeStream = merge(cssStream, sassStream)
        .pipe(concat('app.css'))
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
        .pipe(cmq())
        .pipe(gulp.dest('temp/css'))
        .pipe(rename('app.css'))
        .pipe(cleancss({
            level: {1: {specialComments: 0 }}
        }))
        .pipe(gulp.dest('assets/css'))
        .pipe(notify({ message: 'Styles task complete' }));
    
    return mergeStream;
});

// JSHint
gulp.task('lint', function(){
    return gulp.src('assets/js/source/*.js')
        .pipe(jshint('.jshintrc'))
        .pipe(jshint.reporter('default'))
});

// Scripts
gulp.task('scripts', function() {
    return gulp.src([
        'assets/js/source/*.js',
        'assets/js/vendor/*.js'
    ])
    .pipe(changed('js'))
    .pipe(foreach(function(stream, file){
        return stream
            .pipe(uglify())
            .pipe(rename({suffix: '.min'}))
            .pipe(gulp.dest('temp/js'))
    }))
    .pipe(gulp.dest('assets/js'))
    .pipe(notify({ message: 'Scripts task complete' }));
});

// Clean
gulp.task('clean', function(cb) {
    return gulp.src('temp/*')
    .pipe(vinylpaths(del))
});

// Default task
gulp.task('default', function() {
    runSequence(
        'clean',
        ['styles', 'lint', 'scripts'],
        'watch'
    );
});

// Watch
gulp.task('watch', function() {
    // Watch .scss files
    gulp.watch(['assets/scss/*.scss', 'assets/scss/**/*.scss'], ['styles']);

    // Watch .js files
    gulp.watch(['assets/js/vendor/*.js', 'assets/js/source/*.js'], ['scripts']);
});