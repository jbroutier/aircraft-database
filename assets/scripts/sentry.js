import { init } from '@sentry/browser'
import { BrowserTracing } from '@sentry/tracing'

export function initSentry () {
  const html = document.querySelector('html')

  init({
    debug: Boolean(html.dataset.debug),
    dsn: process.env.SENTRY_DSN,
    environment: html.dataset.environment,
    integrations: [
      new BrowserTracing({
        beforeNavigate: context => ({ ...context, name: html.dataset.route }),
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
}
