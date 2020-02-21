const path = require("path");
//const FaviconsWebpackPlugin = require('favicons-webpack-plugin');

/*
 * ВАЖНО! Скорее всего понадобится добавить в package.json следующие пакеты:
 * yarn add -D compression-webpack-plugin imagemin-webpack-plugin jimp responsive-loader @vue/cli-plugin-babel@^4.1.1
 * + поставить nvm и node версии 11
 * nvm install 11
 * nvm alias default 11
 * + запомнить команду npm rebuild node-sass
 * */
// Плагин сжатия кода в .gzip и .br
const CompressionPlugin = require("compression-webpack-plugin");

// Плагин сжатия изображений
const ImageminPlugin = require("imagemin-webpack-plugin").default;

// Если хотим именно этот сжиматель .jpg (он может оказаться лучше)
// in dire situations
// const imageminJpegoptim = require('imagemin-jpegoptim');

module.exports = {
  chainWebpack: config => {
    // Добавления предзагрузки шрифтов. Вещь очень полезная и лучше пользовать всегда
    config.plugin("preload-font").use(require("@vue/preload-webpack-plugin"), [
      {
        rel: "preload",
        include: "allAssets",
        fileWhitelist: [/.woff$/],
        as: "font"
      }
    ]);

    /* Замена стандартного правила обработки изображений на responsive-loader
     *  Важные выдержки из доки, как пользоваться этим:
     * 1) size в опциях - максимальная ширина в принципе для всех изображений. Обычно больше 1900 никогда и не нужно
     * 2) Для каждого изображения можно в юрле на него указывать ?size=xxx, где ххх - макс ширина в пикселях.
     * Пример: background: url(imgs/car_one.jpg?size=400) обрежет car_one.jpg, если картинка окажется больше шириной.
     */

    // Еще один важный момент - если нужен import и юрл (прим. для я.карт), то надо пользовать String(placemarkImg)
    const images_rule = config.module.rule("images");
    images_rule.uses.clear();

    images_rule
      .use("responsive-loader")
      .loader("responsive-loader")
      .tap(options => {
        return {
          disable: process.env.NODE_ENV !== "production",
          outputPath: "img/",
          size: 1920 //max size. Anything bigger is resized
        };
      });
  },
  configureWebpack: {
    plugins: [
      // Плагин, чтобы добавлять иконку, если вдруг такое понадобится (навряд ли)
      /*new FaviconsWebpackPlugin({
                logo: './src/images/favicon.png',
                prefix: 'icons/',
                emitStats: false,
                statsFilename: 'iconstats.json',
                inject: true,
                persistentCache: false
            }),*/

      // Настройки для сжатия кода в .gzip и .br на этапе билда. Помогает слабо, но хоть как-то
      new CompressionPlugin({
        filename: "[path].br[query]",
        algorithm: "brotliCompress",
        test: /\.(css|js)$/,
        exclude: /back\//,
        compressionOptions: { level: 9 },
        threshold: process.env.NODE_ENV !== "production" ? Infinity : 1024,
        minRatio: 0.8
      }),
      new CompressionPlugin({
        filename: "[path].gz[query]",
        test: /\.(css|js)$/,
        exclude: /back\//,
        threshold: process.env.NODE_ENV !== "production" ? Infinity : 1024,
        minRatio: 0.8
      }),

      // Плагин для сжатия картинок. Если появляются артефакты - можно менять настройки.
      // Используется плагин, а не лоадер, потому что лоадер не будет работать с responsive-loader.
      new ImageminPlugin({
        disable: process.env.NODE_ENV !== "production", // Disable during development
        optipng: {
          optimizationLevel: 4
        },
        jpegtran: {
          progressive: true
        },
        test: [/.*\.jpe?g/, /.*\.png/, /.*\.svg/]

        // in dire situations
        /*optipng: null,
                jpegtran: null,
                pngquant: {
                    quality: '50-80'
                },
                plugins: [
                    imageminJpegoptim({
                        progressive: true,
                        max: 80
                    })
                ]*/
      })
    ],
    resolve: {
      extensions: [".js", ".vue", ".json"],
      alias: {
        vue$: "vue/dist/vue.esm.js",
        "@": path.join(__dirname, "src"),
        styles: path.join(__dirname, "src/styles"),
        swiper$: "swiper/dist/js/swiper.js"
      }
    }
  },
  outputDir: "build",
  publicPath: "/overall/"
};
