const webpack = require('webpack'),
	webpackMerge = require('webpack-merge'),
	commonConfig = require('./webpack.comm.js'),
	path = require('path'),
	CopyWebpackPlugin = require('copy-webpack-plugin'),
	BrowserSyncPlugin = require('browser-sync-webpack-plugin'),
	MiniCssExtractPlugin = require("mini-css-extract-plugin")
	autoprefixer = require('autoprefixer');

const ENV = process.env.NODE_ENV = process.env.ENV = 'production';

module.exports = webpackMerge(commonConfig, {
	mode: ENV,
	devtool: 'source-map',

	output: {
		path: path.resolve(__dirname, '../../') + '/assets',
		publicPath: '',
		filename: '[name].js',
		chunkFilename: '[id].chunk.js'
	},
	module: {
		rules: [
			{
				test: /\.(gif|png|jpe?g|svg)$/i,
				use: [
					'file-loader?name=assets/[name].[ext]',
					'image-webpack-loader'
				]
			},
			{
				test: /\.css$/, use: [
					MiniCssExtractPlugin.loader,
					{ loader: 'css-loader', options: { sourceMap: true, importLoaders: 1 } },
					{ loader: 'postcss-loader', options: { sourceMap: true, plugins: (loader) => [autoprefixer()] } }]
			},
			{
				test: /\.scss$/, use: [
					MiniCssExtractPlugin.loader,
					{ loader: 'css-loader', options: { sourceMap: true, importLoaders: 1, minimize: true } },
					{ loader: 'postcss-loader', options: { sourceMap: true, plugins: (loader) => [autoprefixer()] } },
					{ loader: 'sass-loader', options: { sourceMap: true, importLoaders: 1 } }]
			}
		]
	},
	optimization: {
		minimize: true
	},
	plugins: [
		new webpack.DefinePlugin({
			'process.env': {
				'ENV': JSON.stringify(ENV)
			}
		}),
		new BrowserSyncPlugin({
			proxy: 'http://127.0.0.1/edsa-wp/',
			files: ['./*.php', './views/**/*.twig', './assets/**/*.*'],
		}),
		new CopyWebpackPlugin([{
			from: path.resolve(__dirname, '../../') + '/src/images',
			to: path.resolve(__dirname, '../../') + '/assets/images',
		}]),
		new MiniCssExtractPlugin({
			filename: "[name].css"
		})
	]
});



