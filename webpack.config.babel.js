import SentryWebpackPlugin from '@sentry/webpack-plugin'
import Encore from '@symfony/webpack-encore'
import ESLintWebpackPlugin from 'eslint-webpack-plugin'
import FaviconsWebpackPlugin from 'favicons-webpack-plugin'
import ImageMinimizerPlugin from 'image-minimizer-webpack-plugin'
import {resolve} from 'path'
import StylelintWebpackPlugin from 'stylelint-webpack-plugin'

if (!Encore.isRuntimeEnvironmentConfigured()) {
  Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev')
}

Encore
  .setOutputPath('public/assets/')
  .setPublicPath('/assets')
  .addEntry('scripts/app', './assets/scripts/app.js')
  .addStyleEntry('styles/app', './assets/styles/app.scss')
  .enableStimulusBridge('./assets/controllers.json')
  .splitEntryChunks()
  .enableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild()
  .enableBuildNotifications()
  .enableSourceMaps()
  .enableVersioning(Encore.isProduction())
  .enableSassLoader()
  .enablePostCssLoader()
  .enableIntegrityHashes(Encore.isProduction(), ['sha256', 'sha384', 'sha512'])
  .copyFiles({
    from: './assets/images',
    pattern: /\.(jpe?g|png|svg|webp)$/,
    to: 'images/[path][name]' + (Encore.isProduction() ? '.[hash:8].[ext]' : '.[ext]')
  })
  .configureFontRule({
    type: 'asset',
    maxSize: 16384
  })
  .configureImageRule({
    type: 'asset',
    maxSize: 16384
  })
  .addPlugin(new ESLintWebpackPlugin({
    context: 'assets',
    files: '**/*.js'
  }))
  .addPlugin(new StylelintWebpackPlugin({
    context: 'assets',
    files: '**/*.scss'
  }))
  .addPlugin(new ImageMinimizerPlugin({
    minimizer: {
      implementation: ImageMinimizerPlugin.squooshMinify
    }
  }))
  .addPlugin(new FaviconsWebpackPlugin({
    devMode: 'webapp',
    logo: './assets/images/logo.svg',
    prefix: 'favicons',
    favicons: {
      appName: 'Aircraft database',
      background: '#ffffff',
      themeColor: '#1e88e5',
      icons: {
        android: {
          background: '#ffffff',
          mask: true,
          offset: 10
        },
        appleIcon: {
          background: '#ffffff',
          mask: true,
          offset: 10
        },
        appleStartup: false,
        coast: false,
        favicons: true,
        firefox: false,
        windows: false,
        yandex: false
      }
    }
  }))
  .addAliases({
    '@images': resolve(__dirname, 'assets/images'),
    '@scripts': resolve(__dirname, 'assets/scripts'),
    '@styles': resolve(__dirname, 'assets/styles')
  })

if (Encore.isProduction()) {
  Encore.addPlugin(new SentryWebpackPlugin({
    include: '.',
    org: 'jbroutier',
    project: 'aircraft-database',
    release: 'aircraft-database@' + process.env.npm_package_version
  }))
}

module.exports = Encore.getWebpackConfig()
