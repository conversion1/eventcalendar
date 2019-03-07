var path = require('path');
const common = require('./Webpack.Common.js');
const merge = require('webpack-merge');
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');
const WebpackShellPlugin = require('webpack-shell-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');

module.exports = merge(common, {
    mode: 'production',
	output: {
		path: path.resolve(__dirname, '../../Resources/Public'),
		filename: 'Js/dist/[name].build.js',
		publicPath: '/'
	},
	optimization: {
		minimizer: [
			new UglifyJSPlugin({
				cache: true,
				parallel: true,
				sourceMap: true,
				uglifyOptions: {
					compress: {
						drop_console: true,
					}
				}
			}),
			new OptimizeCSSAssetsPlugin({})
		]
	},
	module: {
		rules: [
			{
				test: /\.(scss|css)$/,
				use: [
					MiniCssExtractPlugin.loader,
					"css-loader",
					"sass-loader"
				]
			}
		]
	},
	plugins: [
		new WebpackShellPlugin(
			{
				onBuildStart:['sh Configuration/Webpack/Shell/Prod.Start.sh']
			}
		),
        /* config.plugin('extract-css') */
        new MiniCssExtractPlugin(
            {
                filename: 'Css/dist/[name].css',
                chunkFilename: 'Css/dist/[name].css'
            }
        ),
	]
});