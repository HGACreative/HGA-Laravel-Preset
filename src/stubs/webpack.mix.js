const mix = require('laravel-mix');
mix.webpackConfig({
        module: {
            rules: [{
                test: /\.jsx?$/,
                exclude: /('')/,
                use: [{
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'], // npm install --save-dev @babel/preset-env
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
    .extract(['vue', 'axios', 'laravel-mix-polyfill', 'targets-webpack-plugin']);
