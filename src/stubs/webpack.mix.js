const mix = require('laravel-mix');

// https://laravel-mix.com/extensions/polyfill
require('laravel-mix-polyfill');

// https://github.com/scottcharlesworth/laravel-mix-polyfill/issues/15
// https://warlord0blog.wordpress.com/2018/08/01/i-hate-internet-explorer/
const TargetsPlugin = require('targets-webpack-plugin');

mix.webpackConfig({
        plugins: [
            new TargetsPlugin({
                browsers: ['last 2 versions', 'chrome >= 41', 'IE 11'],
            }),
        ],
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
    .polyfill({
        enabled: true,
        useBuiltIns: "usage",
        targets: {
            "firefox": "50",
            "ie": 11
        },
        corejs: 3
    })
    .version()
    .extract(['vue', 'axios', 'laravel-mix-polyfill', 'targets-webpack-plugin']);
