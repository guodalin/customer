const mix = require('laravel-mix');
const fs = require('fs');
const path = require('path');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.setPublicPath('public');

let packagesFolder = './packages';
let depth = 2; // vender(1)/packagename(2)

// using vendor package when in production
if (mix.inProduction()) {
    packagesFolder = './vendor/comcsoft';
    depth = 1;
}

/**
 * 遍历目录
 *
 * @param {String} p
 * @param {Number} depth
 */
const walk = function (p, deep) {
    if (deep > depth) {
        return true;
    }

    let list = fs.readdirSync(p).filter(function (f) {
        return fs.statSync(path.resolve(p, f)).isDirectory();
    });

    // found
    if (deep === depth) {
        list.forEach(function (packageName) {
            const jsFolder = path.resolve(p, packageName, 'resources', 'js');
            const cssFolder = path.resolve(p, packageName, 'resources', 'scss');

            files(jsFolder, 'js').forEach(function (js) {
                mix.js(path.resolve(jsFolder, js), path.resolve('vendor', packageName, 'js', js));
            });

            files(cssFolder, 'scss').forEach(function (scss) {
                mix.sass(path.resolve(cssFolder, scss), path.resolve('vendor', packageName, 'css', path.basename(scss, path.extname(scss)) + '.css'));
            });
        });
    } else {
        list.forEach(function (d) {
            walk(path.resolve(p, d), deep + 1);
        });
    }
};

const files = function (dir, ext) {
    if (!fs.existsSync(dir)) {
        return [];
    }

    return fs.readdirSync(dir).filter(function (f) {
        return fs.statSync(path.resolve(dir, f)).isFile() && (path.extname(f).toLocaleLowerCase() === ('.' + ext).toLocaleLowerCase());
    });
};

walk(packagesFolder, 1);

mix
    // .setResourceRoot('../') // turns assets paths in css relative to css file
    .sass('resources/sass/frontend/app.scss', 'css/frontend.css')
    .sass('resources/sass/backend/app.scss', 'css/backend.css')
    .js('resources/js/frontend/app.js', 'js/frontend.js')
    .js([
        'resources/js/backend/before.js',
        'resources/js/backend/app.js',
        'resources/js/backend/after.js'
    ], 'js/backend.js')
    .extract([
        // Extract packages from node_modules to vendor.js
        'jquery',
        'bootstrap',
        'popper.js',
        'axios',
        'sweetalert2',
        'toastr',
        'lodash',
        'vue'
    ])
    .sourceMaps();

if (mix.inProduction()) {
    mix.version()
        .options({
            // Optimize JS minification process
            terser: {
                cache: true,
                parallel: true,
                sourceMap: false
            }
        });
} else {
    // Uses inline source-maps on development
    mix.webpackConfig({
        devtool: 'inline-source-map'
    });
}
