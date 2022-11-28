const mix = require('laravel-mix');
// mix
// .js('resources/js/app.js', 'public/js')
// .postCss('resources/css/app.css', 'public/css', [
//     require('postcss-import'),
//     require('tailwindcss'),
//     require('autoprefixer'),
// ]);

mix.webpackConfig(webpack => {
    return {
        plugins: [
            new webpack.DefinePlugin({
                'process.env': {
                    SOCKET_PORT: JSON.stringify(process.env.SOCKET_PORT || '3000'),
                    SOCKET_HOST: JSON.stringify(process.env.SOCKET_HOST || 'localhost'),
                }
            })
        ]
    }
})

mix
    .js('resources/js/app.js', 'public/js')
    .sass('resources/scss/app.scss', 'public/css')
mix
    .js('resources/js/master-data/unit.js', 'public/js/master-data')
    .js('resources/js/master-data/materials.js', 'public/js/master-data')
    .js('resources/js/master-data/product.js', 'public/js/master-data')
    .js('resources/js/master-data/machine.js', 'public/js/master-data')
    .js('resources/js/master-data/error.js', 'public/js/master-data')


