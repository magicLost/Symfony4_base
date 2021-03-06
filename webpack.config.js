const Encore = require('@symfony/webpack-encore');
const CopyWebpackPlugin = require('copy-webpack-plugin');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public.local/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    //.enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
    .addEntry('app', './assets/js/app.js')
    //add another page js file
    .addEntry('app', './assets/js/login.js')

    .enableBuildNotifications()
    // .addStyleEntry('css/app', './assets/css/app.scss')

    // uncomment if you use Sass/SCSS files
    // .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
     .autoProvidejQuery()

    .addPlugin(new CopyWebpackPlugin([
        { from: './assets/static', to: 'static' }
    ]))

;

module.exports = Encore.getWebpackConfig();
