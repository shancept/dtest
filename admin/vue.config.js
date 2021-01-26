const path = require('path');

module.exports = {
    css: {
        sourceMap: true,
    },
    publicPath: '/admin',
    outputDir: '../web/admin',
    filenameHashing: false,
    lintOnSave: false,
    configureWebpack: {
        performance: {
            maxAssetSize: 500000,
        },
        devtool: 'source-map',
        output: {
            hotUpdateChunkFilename: 'hot-update.js', // use for AssetsPlugin to filter out hot updates
        },
        entry: {
            app: './src/main.js'
        },
        //ставится только тогда когда нам не нужен runtime
        resolve: {
            alias: {
                'vue$': 'vue/dist/vue.esm.js',
                '@': path.resolve(__dirname, './src')
            }
        },
    },
};


