const mix = require('laravel-mix');

mix.webpackConfig({
     resolve: {
         alias: {
             RootJsDir: path.resolve(__dirname, 'resources', 'js'),
             ClassesDir: path.resolve(__dirname, 'resources', 'js', 'classes'),
             ComponentsDir: path.resolve(__dirname, 'resources', 'js', 'components'),
         }
     }
    })
    .js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .version()
   .extract(['vue', 'axios']);
