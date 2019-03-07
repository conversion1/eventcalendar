var path = require('path');
var webpack = require('webpack');
const VueLoaderPlugin = require('vue-loader/lib/plugin');
const TSLintPlugin = require('tslint-webpack-plugin');
const FriendlyErrorsWebpackPlugin = require('friendly-errors-webpack-plugin');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
	entry: {
		'event-calendar': './Resources/Private/Js/Main.ts'
	},
	output: {
		path: path.resolve(__dirname, '../../Resources/Public/Js/dist'),
		filename: '[name].build.js',
		publicPath: '/'
	},
	resolve: {
        extensions: [
            '.js',
            '.vue',
            '.json',
            '.ts',
            '.tsx'
        ],
        alias: {
            '@': './Resources/Private/Js',
            vue$: 'vue/dist/vue.esm.js',
            modernizr$: path.resolve(__dirname, '.modernizrrc')
        },
	},
    resolveLoader: {
        modules: [
            'node_modules/@vue/cli-plugin-typescript/node_modules',
            'node_modules/@vue/cli-plugin-eslint/node_modules',
            'node_modules/@vue/cli-plugin-babel/node_modules',
            'node_modules',
            'node_modules/@vue/cli-service/node_modules'
        ]
    },
	module: {
		rules: [
            {
                test: /\.vue$/,
                use: [
                    {
                        loader: 'vue-loader',
                        options: {
                            compilerOptions: {
                                preserveWhitespace: false
                            },
                            cacheDirectory: 'node_modules/.cache/vue-loader',
                            cacheIdentifier: '2b8d0076'
                        }
                    }
                ]
            },
            /* config.module.rule('eslint') */
            {
                enforce: 'pre',
                test: /\.(vue|(j|t)s?)$/,
                use: [
                    /* config.module.rule('eslint').use('eslint-loader') */
                    {
                        loader: 'eslint-loader',
                        options: {
                            extensions: [
                                '.js',
                                '.vue',
                                '.ts',
                            ],
                            cache: true,
                            emitWarning: true,
                            emitError: false,
                            formatter: function () { /* omitted long function */ }
                        }
                    }
                ]
            },
            {
                test: /\.ts$/,
                use: [
                    /* config.module.rule('ts').use('babel-loader') */
                    {
                        loader: 'babel-loader'
                    },
                    /* config.module.rule('ts').use('ts-loader') */
                    {
                        loader: 'ts-loader',
                        options: {
                            transpileOnly: true,
                            appendTsSuffixTo: [
                                '\\.vue$'
                            ],
                            happyPackMode: false
                        }
                    }
                ]
            },
			{
				test: /\.scss$/,
				use: [
					{
						loader: "style-loader" // creates style nodes from JS strings
					},
					{
						loader: "css-loader" // translates CSS into CommonJS
					},
					{
						loader: "sass-loader" // compiles Sass to CSS
					}
				]
			},
            {
                test: /\.modernizrrc$/,
                loader: "modernizr-loader!json-loader"
            },
		]
	},
	optimization: {
		splitChunks: {
			cacheGroups: {
				commons: {
					test: /[\\/]node_modules[\\/]/,
					name: "event-calendar.vendor",
					chunks: "all",
				}
			}
		}
	},
	plugins: [
        new VueLoaderPlugin(),
		new TSLintPlugin({
			files: ['../../Resources/Private/TypeScript/**/*.ts']
		})
	]
}