import SentryPlugin from '@sentry/webpack-plugin'
import Encore from '@symfony/webpack-encore'
import ESLintPlugin from 'eslint-webpack-plugin'
import ImageMinimizerPlugin from 'image-minimizer-webpack-plugin'
import StylelintPlugin from 'stylelint-webpack-plugin'

if (!Encore.isRuntimeEnvironmentConfigured()) {
  Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev')
}

Encore
  .setOutputPath('public/assets/')
  .setPublicPath('/assets')
  .addEntry('scripts/main', './assets/scripts/main.js')
  .addStyleEntry('styles/main', './assets/styles/main.scss')
  .enableVersioning(Encore.isProduction())
  .enableSourceMaps()
  .enableSingleRuntimeChunk()
  .splitEntryChunks()
  .enablePostCssLoader()
  .enableSassLoader()
  .enableStimulusBridge('./assets/controllers.json')
  .enableBuildNotifications()
  .cleanupOutputBeforeBuild()
  .enableIntegrityHashes(Encore.isProduction(), ['sha256', 'sha384', 'sha512'])
  .addCacheGroup('vendor', {
    test: /\/node_modules\//
  })
  .copyFiles({
    from: 'assets',
    pattern: /site\.webmanifest$/i,
    to: '[name]' + (Encore.isProduction() ? '.[contenthash:8].[ext]' : '.[ext]')
  })
  .copyFiles({
    from: 'assets/images',
    pattern: /\.(gif|ico|jpe?g|png|svg|webp)$/i,
    to: 'images/[name]' + (Encore.isProduction() ? '.[contenthash:8].[ext]' : '.[ext]')
  })
  .configureFontRule({
    type: 'asset/resource',
    filename: 'fonts/[name]' + (Encore.isProduction() ? '.[contenthash:8][ext]' : '[ext]')
  })
  .configureImageRule({
    type: 'asset/resource',
    filename: 'images/[name]' + (Encore.isProduction() ? '.[contenthash:8][ext]' : '[ext]')
  })
  .addPlugin(new ESLintPlugin({
    context: 'assets',
    files: '**/*.js'
  }))
  .addPlugin(new StylelintPlugin({
    context: 'assets',
    files: '**/*.scss'
  }))
  .addPlugin(new ImageMinimizerPlugin({
    minimizer: {
      implementation: ImageMinimizerPlugin.squooshMinify
    }
  }))
  .when(encore => encore.isProduction(), encore => encore.addPlugin(new SentryPlugin({
    include: 'public/assets',
    release: 'aircraft-database@' + process.env.npm_package_version
  })))

module.exports = Encore.getWebpackConfig()
