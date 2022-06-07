import SentryWebpackPlugin from '@sentry/webpack-plugin'
import Encore from '@symfony/webpack-encore'
import { config } from 'dotenv'
import ESLintWebpackPlugin from 'eslint-webpack-plugin'
import FaviconsWebpackPlugin from 'favicons-webpack-plugin'
import { existsSync } from 'fs'
import ImageMinimizerPlugin from 'image-minimizer-webpack-plugin'
import { resolve } from 'path'
import StylelintWebpackPlugin from 'stylelint-webpack-plugin'

if (!Encore.isRuntimeEnvironmentConfigured()) {
  Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev')
}

Encore
  .setOutputPath('public/assets/')
  .setPublicPath('/assets')
  .addEntry('scripts/app', './assets/scripts/app.js')
  .addStyleEntry('styles/app', './assets/styles/app.scss')
  .addStyleEntry('styles/fonts', './assets/styles/fonts.scss')
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
    pattern: /\.(gif|jpe?g|png|svg|webp)$/,
    to: 'images/[path][name]' + (Encore.isProduction() ? '.[hash:8].[ext]' : '.[ext]')
  })
  .configureDefinePlugin(options => {
    const envFiles = ['.env', '.env.local']
    envFiles.forEach(envFile => {
      const envFilePath = resolve(__dirname, envFile)
      if (existsSync(envFilePath)) {
        const envVars = config({ path: envFilePath }).parsed
        Object.keys(envVars).forEach(envVar => {
          options['process.env.' + envVar] = JSON.stringify(envVars[envVar])
        })
      }
    })
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
      themeColor: '#ffffff',
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

if (Encore.isProduction()) {
  Encore.addPlugin(new SentryWebpackPlugin({
    include: '.',
    org: 'aircraft-database',
    project: 'aircraft-database',
    release: 'aircraft-database@' + process.env.npm_package_version
  }))
}

module.exports = Encore.getWebpackConfig()
