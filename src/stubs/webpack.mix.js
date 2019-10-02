const mix = require('laravel-mix');

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

mix.webpackConfig({
        module: {
            rules: [{
                test: /\.jsx?$/,
                exclude: /('')/,
                use: [{
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'] // npm install --save-dev @babel/preset-env
                    }
                }]
            }]
        },
        resolve: {
            alias: {
                RootJsDir: path.resolve(__dirname, 'resources', 'js'),
                ClassesDir: path.resolve(__dirname, 'resources', 'js', 'classes'),
                ComponentsDir: path.resolve(__dirname, 'resources', 'js', 'components')
            }
        }
    })
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .version()
    .extract(['vue', 'axios']);
