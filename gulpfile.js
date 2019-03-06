// Gulp.js configuration
var
	// modules
	gulp = require('gulp'),
	concat = require('gulp-concat'),
	deporder = require('gulp-deporder'),
	stripdebug = require('gulp-strip-debug'),
	uglify = require('gulp-uglify'),
	sass = require('gulp-sass'),
	postcss = require('gulp-postcss'),
	assets = require('postcss-assets'),
	autoprefixer = require('autoprefixer'),
	mqpacker = require('css-mqpacker'),
	cssnano = require('cssnano'),

	// folders
	folder = {
		src  : 'asset_sources/',
		build: 'built_assets/'
	};

// JavaScript processing
gulp.task('js', function() {

	var jsbuild = gulp.src(folder.src + 'js/**/*')
		.pipe(deporder())
		.pipe(concat('main.js'));

	jsbuild = jsbuild
		.pipe(stripdebug())
		.pipe(uglify());

	return jsbuild.pipe(gulp.dest(folder.build + 'js/'));

});

// CSS processing
gulp.task('css', function() {

	var postCssOpts = [
		autoprefixer({ browsers: ['last 2 versions', '> 2%'] }),
		mqpacker
	];

	// postCssOpts.push(cssnano);

	return gulp.src(folder.src + 'scss/**/*.scss')
		.pipe(sass({
			outputStyle: 'nested',
			precision: 3,
			errLogToConsole: true
		}))
		.pipe(postcss(postCssOpts))
		.pipe(gulp.dest(folder.build + 'css/'));

});

gulp.task('build', ['css', 'js']);
