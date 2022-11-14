module.exports = {
	config: {
		tailwindjs: "./tailwind.config.js",
		port: 9050
	},
	paths: {
		root: "./",
		src: {
			base: "./src",
			css: "./src/css",
			cssExt: "./src/css/external",
			cssLogin: "./src/css/login",
			js: "./src/js",
			jsExt: "./src/js/external",
			img: "./src/img"
		},
		dist: {
			base: "./dist",
			css: "./dist/css",
			cssExt: "./dist/css/external",
			js: "./dist/js",
			jsExt: "./dist/js/external",
			img: "./dist/img"
		},
		build: {
			base: "./build",
			css: "./build/css",
			cssExt: "./build/css/external",
			cssLogin: "./build/scss/login",
			js: "./build/js",
			jsExt: "./build/js/external",
			img: "./build/img"
		}
	}
}