const merge = require('webpack-merge');
const common = require('./Webpack.Common.js');
const WebpackShellPlugin = require('webpack-shell-plugin');

module.exports = merge(common, {
	mode: 'development',
	devtool: 'cheap-source-map',
	devServer: {
		contentBase: './dist',
		host: "192.168.100.46",
		port: 8099
	},
	performance: {
		hints: 'warning'
	},
	plugins: [
		new WebpackShellPlugin(
			{
				onBuildStart:['sh Configuration/Webpack/Shell/Dev.Start.sh']
			}
		)
	]
});