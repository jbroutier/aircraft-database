import { configureScope, init } from '@sentry/browser'
import { BrowserTracing } from '@sentry/tracing'

export function initSentry () {
  const html = document.querySelector('html')

  init({
    debug: Boolean(html.dataset.debug),
    dsn: process.env.SENTRY_DSN,
    environment: html.dataset.environment,
    integrations: [
      new BrowserTracing({
        tracingOrigins: [
          'aircraft-database.com',
          'aircraft-database.local'
        ]
      })
    ],
    release: html.dataset.release,
    sampleRate: 1.0,
    tracesSampler: samplingContext => !samplingContext.location.pathname.match(/^\/admin\//i)
  })

  configureScope(scope => {
    scope.setTransactionName(html.dataset.route)
    scope.setTags({
      locale: html.dataset.locale
    })
    scope.setUser({
      id: html.dataset.user,
      ip_address: html.dataset.clientIp,
      username: html.dataset.username
    })
  })
}
