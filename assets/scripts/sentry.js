import { configureScope, init } from '@sentry/browser'
import { BrowserTracing } from '@sentry/tracing'

export default function initSentry () {
  const config = JSON.parse(document.querySelector('html').getAttribute('data-sentry'))

  init({
    debug: config.debug,
    dsn: config.dsn,
    environment: config.environment,
    integrations: [
      new BrowserTracing({
        tracingOrigins: [
          'aircraft-database.com',
          'aircraft-database.local'
        ]
      })
    ],
    release: config.release,
    sampleRate: config.sampleRate,
    tracesSampleRate: config.tracesSampleRate
  })

  configureScope(scope => {
    scope.setTransactionName(config.transactionName)
    scope.setTags(config.tags)
    scope.setUser(config.user)
  })
}
