// gulpfile.js
var gulp = require("gulp"),
    sass = require("gulp-sass"),
    postcss = require("gulp-postcss"),
    autoprefixer = require("autoprefixer"),
    sourcemaps = require("gulp-sourcemaps");

var paths = {
    styles: {
        // By using styles/**/*.sass we're telling gulp to check all folders for any sass file
        src: ['src/admin/css/doppler-for-learnpress-admin.scss', 'src/public/css/doppler-for-learnpress-public.scss'],
        // Compiled files will end up in whichever folder it's found in (partials are not compiled)
        dest: "."
    }
 
    // Easily add additional paths
    // ,html: {
    //  src: '...',
    //  dest: '...'
    // }
};

// Define tasks after requiring dependencies
function style() {
    // Where should gulp look for the sass files?
    // My .sass files are stored in the styles folder
    // (If you want to use scss files, simply look for *.scss files instead)
    return (
        gulp
            //.src("styles/*.sass")
            //Search in admin and public folders
            .src(paths.styles.src, { base: '.' })

            // Initialize sourcemaps before compilation starts
            .pipe(sourcemaps.init())
 
            // Use sass with the files found, and log any errors
            .pipe(sass())
            .on("error", sass.logError)
 
            // Use postcss with autoprefixer and compress the compiled file using cssnano
            .pipe(postcss([autoprefixer()]))

            // Now add/write the sourcemaps
            .pipe(sourcemaps.write())

            // What is the destination for the compiled file?
            //.pipe(gulp.dest("styles"))
            //Same destination as scss file
            .pipe(gulp.dest(paths.styles.dest))
    );
}

function watch(){
    // gulp.watch takes in the location of the files to watch for changes
    // and the name of the function we want to run on change
    gulp.watch(paths.styles.src, style)
}
 
// Expose the task by exporting it
// This allows you to run it from the commandline using
// $ gulp style
exports.style = style;
exports.watch = watch